<?php

namespace App\Http\Controllers;

use App\Enums\ApplicationStatusEnum;
use App\Http\Requests\Application\ApplicationStoreRequest;
use App\Http\Requests\Application\ApplicationUpdateRequest;
use App\Models\Application;
use App\Models\Department;
use App\Models\User;
use App\Repository\Application\ApplicationRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ApplicationController extends Controller
{
    public function __construct(
        private ApplicationRepository $applicationRepository
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('applications.index', [
            'applications' => $this->applicationRepository->getApplicationsPaginated(),
            'statuses' => ApplicationStatusEnum::options(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('applications.create', [
            'departments' => Department::all(),
            'users' => User::all(),
            'statuses' => ApplicationStatusEnum::options(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ApplicationStoreRequest $applicationStoreRequest): RedirectResponse
    {
        $this->applicationRepository->store($applicationStoreRequest);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Заявка успешно создана.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Application $application): View
    {
        return view('applications.edit', [
            'application' => $application,
            'departments' => Department::all(),
            'users' => User::all(),
            'statuses' => ApplicationStatusEnum::options(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ApplicationUpdateRequest $applicationUpdateRequest, Application $application): RedirectResponse
    {
        $this->applicationRepository->update($applicationUpdateRequest, $application);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Заявка успешно обновлена.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Application $application): RedirectResponse
    {
        $this->applicationRepository->destroy($application);

        return redirect()
            ->route('applications.index')
            ->with('success', 'Заявка успешно удалена.');
    }
}
