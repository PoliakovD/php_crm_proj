@extends('layouts.main')

@section('title', 'Галерея — ' . $owner->name)

@push('styles')
    <style>
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
            height: 200px;
            object-fit: cover;
            display: block;
            background: #f1f5f9;
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
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-images text-indigo-500 mr-2"></i>Галерея — {{ $owner->name }}
                </h1>
                <p class="text-gray-500 text-sm mt-0.5">Публичные изображения пользователя</p>
            </div>
        </div>

        @if($images->isEmpty())
            <div class="empty-state">
                <i class="fas fa-images text-gray-300 text-5xl"></i>
                <p class="text-gray-500 mt-3">У этого пользователя пока нет публичных изображений</p>
            </div>
        @else
            <div class="gallery-grid">
                @foreach($images as $image)
                    <div class="gallery-card">
                        <img class="thumb" src="{{ $image->url }}" alt="{{ $image->original_name }}" loading="lazy">
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
