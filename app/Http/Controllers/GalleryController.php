<?php

namespace App\Http\Controllers;

use App\Http\Requests\Image\ImageStoreRequest;
use App\Models\Image;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GalleryController extends Controller
{
    /**
     * Личная галерея текущего пользователя.
     */
    public function index(): View
    {
        return view('gallery.index', [
            'images' => auth()->user()->images()->latest()->get(),
        ]);
    }

    /**
     * Мультизагрузка изображений.
     */
    public function store(ImageStoreRequest $imageStoreRequest): RedirectResponse
    {
        $isPublic = $imageStoreRequest->boolean('is_public');

        foreach ($imageStoreRequest->file('images') as $file) {
            $path = $file->store('gallery/' . auth()->id(), 'public');

            auth()->user()->images()->create([
                'path' => $path,
                'original_name' => $file->getClientOriginalName(),
                'is_public' => $isPublic,
            ]);
        }

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Изображения успешно загружены.');
    }

    /**
     * Переключить публичный/приватный доступ к изображению.
     */
    public function update(Image $image): RedirectResponse
    {
        abort_if($image->user_id !== auth()->id(), 403);

        $image->update(['is_public' => !$image->is_public]);

        return redirect()
            ->route('gallery.index')
            ->with('success', $image->is_public ? 'Изображение сделано публичным.' : 'Изображение сделано приватным.');
    }

    /**
     * Удалить изображение.
     */
    public function destroy(Image $image): RedirectResponse
    {
        abort_if($image->user_id !== auth()->id(), 403);

        Storage::disk('public')->delete($image->path);
        $image->delete();

        return redirect()
            ->route('gallery.index')
            ->with('success', 'Изображение удалено.');
    }

    /**
     * Публичная галерея пользователя — видны только публичные изображения.
     */
    public function publicGallery(User $user): View
    {
        return view('gallery.public', [
            'owner' => $user,
            'images' => $user->images()->where('is_public', true)->latest()->get(),
        ]);
    }
}
