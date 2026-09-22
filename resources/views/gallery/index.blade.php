@extends('layouts.main')

@section('title', 'Моя галерея')

@push('styles')
    <style>
        .upload-container {
            background: white;
            border-radius: 16px;
            padding: 1.5rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            margin-bottom: 1.5rem;
        }
        .dropzone {
            border: 2px dashed #e2e8f0;
            border-radius: 14px;
            padding: 2rem 1rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.2s;
            background: #f8fafc;
        }
        .dropzone:hover,
        .dropzone.dragover {
            border-color: #6366f1;
            background: #eef2ff;
        }
        .dropzone i {
            font-size: 2rem;
            color: #94a3b8;
        }
        .dropzone.dragover i {
            color: #6366f1;
        }
        .preview-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(90px, 1fr));
            gap: 0.75rem;
            margin-top: 1rem;
        }
        .preview-grid img {
            width: 100%;
            height: 90px;
            object-fit: cover;
            border-radius: 10px;
            border: 1px solid #e2e8f0;
        }
        .toggle-switch {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            user-select: none;
        }
        .toggle-switch input {
            width: 40px;
            height: 22px;
            accent-color: #6366f1;
        }
        .btn-submit {
            background: linear-gradient(135deg, #6366f1, #8b5cf6);
            border: none;
            color: white;
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        .btn-submit:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
        }
        .form-error {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }

        /* Галерея */
        .gallery-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 1.25rem;
        }
        .gallery-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.2s;
        }
        .gallery-card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.08);
            transform: translateY(-2px);
        }
        .gallery-card .thumb {
            width: 100%;
            height: 160px;
            object-fit: cover;
            display: block;
            background: #f1f5f9;
        }
        .gallery-card .body {
            padding: 0.85rem 1rem;
        }
        .gallery-card .filename {
            font-size: 0.8rem;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            margin-bottom: 0.6rem;
        }
        .visibility-badge {
            padding: 3px 10px;
            border-radius: 50px;
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .visibility-public {
            background: #dcfce7;
            color: #166534;
        }
        .visibility-private {
            background: #f1f5f9;
            color: #64748b;
        }
        .gallery-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0.75rem;
            gap: 0.5rem;
        }
        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            color: #94a3b8;
            background: #f8fafc;
            cursor: pointer;
        }
        .btn-action:hover {
            background: #fee2e2;
            color: #dc2626;
        }
        .btn-toggle {
            border: none;
            border-radius: 8px;
            padding: 6px 10px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
        }
        .btn-toggle-make-public {
            background: #eef2ff;
            color: #4f46e5;
        }
        .btn-toggle-make-public:hover {
            background: #e0e7ff;
        }
        .btn-toggle-make-private {
            background: #f1f5f9;
            color: #475569;
        }
        .btn-toggle-make-private:hover {
            background: #e2e8f0;
        }
        .empty-state {
            background: white;
            border-radius: 16px;
            border: 1px solid #f1f5f9;
            padding: 3rem 1rem;
            text-align: center;
        }
    </style>
@endpush

@section('content')
    <div class="px-0">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Успешно!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-images text-indigo-500 mr-2"></i>Моя галерея
                </h1>
                <p class="text-gray-500 text-sm mt-0.5">
                    Загружайте изображения и управляйте доступом к ним.
                    Публичная ссылка: <a class="text-indigo-600 hover:underline" href="{{ route('gallery.public', auth()->id()) }}">{{ route('gallery.public', auth()->id()) }}</a>
                </p>
            </div>
        </div>

        <!-- Форма загрузки -->
        <div class="upload-container">
            <form action="{{ route('gallery.store') }}" method="POST" enctype="multipart/form-data" id="uploadForm">
                @csrf

                <label for="images" class="dropzone" id="dropzone">
                    <i class="fas fa-cloud-upload-alt"></i>
                    <p class="font-semibold text-gray-700 mt-2">Перетащите изображения сюда или нажмите для выбора</p>
                    <p class="text-xs text-gray-400 mt-1">JPEG, PNG, WEBP, GIF — до 4 МБ на файл, можно выбрать сразу несколько</p>
                    <input type="file" id="images" name="images[]" class="hidden" accept="image/*" multiple>
                </label>
                @error('images')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror
                @error('images.*')
                <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                @enderror

                <div class="preview-grid" id="previewGrid"></div>

                <div class="flex flex-wrap items-center justify-between gap-3 mt-4">
                    <label class="toggle-switch">
                        <input type="checkbox" name="is_public" value="1">
                        <span class="text-sm text-gray-700">Сделать загружаемые изображения публичными</span>
                    </label>
                    <button type="submit" class="btn-submit" id="submitBtn" disabled>
                        <i class="fas fa-upload"></i> Загрузить
                    </button>
                </div>
            </form>
        </div>

        <!-- Галерея -->
        @if($images->isEmpty())
            <div class="empty-state">
                <i class="fas fa-images text-gray-300 text-5xl"></i>
                <p class="text-gray-500 mt-3">У вас пока нет загруженных изображений</p>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($images as $image)
                    <div class="gallery-card">
                        <img class="thumb" src="{{ $image->url }}" alt="{{ $image->original_name }}" loading="lazy">
                        <div class="body">
                            <div class="filename" title="{{ $image->original_name }}">{{ $image->original_name }}</div>

                            <span class="visibility-badge {{ $image->is_public ? 'visibility-public' : 'visibility-private' }}">
                                <i class="fas {{ $image->is_public ? 'fa-globe' : 'fa-lock' }}"></i>
                                {{ $image->is_public ? 'Публичное' : 'Приватное' }}
                            </span>

                            <div class="gallery-actions">
                                <form method="POST" action="{{ route('gallery.update', $image) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="btn-toggle {{ $image->is_public ? 'btn-toggle-make-private' : 'btn-toggle-make-public' }}">
                                        {{ $image->is_public ? 'Сделать приватным' : 'Сделать публичным' }}
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('gallery.destroy', $image) }}" onsubmit="return confirm('Удалить изображение?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn-action" title="Удалить">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection

@push('scripts')
    <script>
        const input = document.getElementById('images');
        const dropzone = document.getElementById('dropzone');
        const previewGrid = document.getElementById('previewGrid');
        const submitBtn = document.getElementById('submitBtn');

        function renderPreviews(files) {
            previewGrid.innerHTML = '';
            submitBtn.disabled = files.length === 0;

            Array.from(files).forEach(file => {
                if (!file.type.startsWith('image/')) return;
                const reader = new FileReader();
                reader.onload = e => {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    previewGrid.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        input?.addEventListener('change', () => renderPreviews(input.files));

        ['dragenter', 'dragover'].forEach(evt => {
            dropzone?.addEventListener(evt, e => {
                e.preventDefault();
                dropzone.classList.add('dragover');
            });
        });

        ['dragleave', 'drop'].forEach(evt => {
            dropzone?.addEventListener(evt, e => {
                e.preventDefault();
                dropzone.classList.remove('dragover');
            });
        });

        dropzone?.addEventListener('drop', e => {
            const files = e.dataTransfer.files;
            if (files.length) {
                input.files = files;
                renderPreviews(files);
            }
        });
    </script>
@endpush
