@extends('layouts.main')

@section('title', 'Заявки CRM')

@push('styles')
    <style>
        .stat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .stat-card {
            background: white;
            border-radius: 16px;
            padding: 1.25rem 1.5rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
            transition: all 0.3s ease;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }

        .table-wrapper {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.06);
            border: 1px solid #f1f5f9;
        }

        .table-wrapper table {
            width: 100%;
            border-collapse: collapse;
        }

        .table-wrapper thead {
            background: #f8fafc;
            border-bottom: 2px solid #f1f5f9;
        }

        .table-wrapper thead th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            padding: 12px 16px;
            text-align: left;
            border: none;
            white-space: nowrap;
        }

        .table-wrapper tbody td {
            padding: 12px 16px;
            vertical-align: middle;
            border-bottom: 1px solid #f1f5f9;
            color: #1e293b;
            font-size: 14px;
        }

        .table-wrapper tbody tr:last-child td {
            border-bottom: none;
        }

        .table-wrapper tbody tr:hover {
            background: #f8fafc;
        }

        .status-badge {
            padding: 4px 12px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 4px;
            white-space: nowrap;
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
            background: transparent;
            cursor: pointer;
        }

        .btn-action:hover {
            background: #f1f5f9;
            color: #1e293b;
        }

        .btn-action-edit:hover {
            background: #eef2ff;
            color: #4f46e5;
        }

        .btn-action-delete:hover {
            background: #fee2e2;
            color: #dc2626;
        }

        .pagination-wrapper {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            border-top: 1px solid #f1f5f9;
            gap: 1rem;
        }

        .pagination-links {
            display: flex;
            gap: 4px;
            flex-wrap: wrap;
        }

        .pagination-links a,
        .pagination-links span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
            color: #1e293b;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.2s;
            background: white;
            text-decoration: none;
        }

        .pagination-links a:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
        }

        .pagination-links .active span {
            background: #6366f1;
            border-color: #6366f1;
            color: white;
        }

        .pagination-links .disabled span {
            opacity: 0.5;
            pointer-events: none;
        }

        @media (max-width: 768px) {
            .table-wrapper {
                overflow-x: auto;
            }

            .stat-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .pagination-wrapper {
                flex-direction: column;
                align-items: center;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .stat-grid {
                grid-template-columns: 1fr;
            }

            .stat-card {
                padding: 1rem;
            }
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

        <!-- Заголовок -->
        <div class="flex flex-wrap items-center justify-between gap-3 mb-6">
            <div>
                <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                    <i class="fas fa-file-inbox text-indigo-500 mr-2"></i>Заявки
                </h1>
                <p class="text-gray-500 text-sm mt-0.5">Управление заявками CRM-системы</p>
            </div>
            <div class="flex flex-wrap gap-2">
                <a href="{{ route('applications.create') }}">
                    <button class="btn-primary-custom text-sm">
                        <i class="fas fa-plus"></i> Добавить
                    </button>
                </a>
            </div>
        </div>

        <!-- Статистика -->
        <div class="stat-grid">
            <div class="stat-card">
                <div>
                    <p class="text-gray-500 text-xs font-semibold uppercase tracking-wider">Всего</p>
                    <h3 class="text-2xl font-bold">{{ $applications->total() }}</h3>
                </div>
                <div class="stat-icon" style="background: #eef2ff; color: #6366f1;">
                    <i class="fas fa-file-inbox"></i>
                </div>
            </div>
        </div>

        <!-- Таблица -->
        <div class="table-wrapper">
            <div class="overflow-x-auto">
                <table>
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Заголовок</th>
                        <th>Отдел</th>
                        <th>Пользователь</th>
                        <th>Статус</th>
                        <th>Дата создания</th>
                        <th style="text-align: right;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($applications as $application)
                        <tr>
                            <td>#{{ $application->id }}</td>
                            <td>
                                <div class="font-semibold text-gray-800">{{ $application->title }}</div>
                                @if($application->description)
                                    <small class="text-gray-400">{{ \Illuminate\Support\Str::limit($application->description, 60) }}</small>
                                @endif
                            </td>
                            <td>{{ $application->department?->title ?? '—' }}</td>
                            <td>
                                @if($application->user)
                                    {{ $application->user->name }}
                                @else
                                    <span class="text-gray-400"><i class="fas fa-user-secret mr-1"></i>Аноним</span>
                                @endif
                            </td>
                            <td>
                                <span class="status-badge" style="background: {{ $application->status === \App\Enums\ApplicationStatusEnum::NEW->value ? '#dbeafe' : '#f1f5f9' }}; color: {{ \App\Enums\ApplicationStatusEnum::from($application->status)->color() }};">
                                    <i class="fas {{ \App\Enums\ApplicationStatusEnum::from($application->status)->icon() }}"></i>
                                    {{ \App\Enums\ApplicationStatusEnum::from($application->status)->label() }}
                                </span>
                            </td>
                            <td>
                                <div class="flex flex-col">
                                    <span>{{ $application->created_at?->format('d.m.Y') }}</span>
                                    <small class="text-gray-400 text-xs">{{ $application->created_at?->diffForHumans() }}</small>
                                </div>
                            </td>
                            <td>
                                <div class="flex justify-end gap-1">
                                    <a href="{{ route('applications.edit', $application) }}">
                                        <button class="btn-action btn-action-edit" title="Редактировать">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </a>
                                    <form method="POST" action="{{ route('applications.destroy', $application) }}" onsubmit="return confirm('Удалить заявку #{{ $application->id }}?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-action btn-action-delete" title="Удалить">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-12">
                                <div class="flex flex-col items-center">
                                    <i class="fas fa-inbox text-gray-300 text-5xl"></i>
                                    <p class="text-gray-500 mt-3">Заявки не найдены</p>
                                    <a href="{{ route('applications.create') }}" class="btn-primary-custom mt-4 inline-flex items-center gap-2">
                                        <i class="fas fa-plus"></i> Добавить первую заявку
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Пагинация -->
            @if($applications->hasPages())
                <div class="pagination-wrapper">
                    <div class="text-gray-500 text-sm">
                        Показано <strong>{{ $applications->firstItem() ?? 0 }}</strong> —
                        <strong>{{ $applications->lastItem() ?? 0 }}</strong>
                        из <strong>{{ $applications->total() }}</strong> заявок
                    </div>
                    <div class="pagination-links">
                        @if($applications->onFirstPage())
                            <span class="disabled"><span><i class="fas fa-chevron-left"></i></span></span>
                        @else
                            <a href="{{ $applications->previousPageUrl() }}"><i class="fas fa-chevron-left"></i></a>
                        @endif

                        @foreach($applications->links()->elements as $element)
                            @if(is_string($element))
                                <span class="disabled"><span>…</span></span>
                            @endif
                            @if(is_array($element))
                                @foreach($element as $page => $url)
                                    @if($page == $applications->currentPage())
                                        <span class="active"><span>{{ $page }}</span></span>
                                    @else
                                        <a href="{{ $url }}">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if($applications->hasMorePages())
                            <a href="{{ $applications->nextPageUrl() }}"><i class="fas fa-chevron-right"></i></a>
                        @else
                            <span class="disabled"><span><i class="fas fa-chevron-right"></i></span></span>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
