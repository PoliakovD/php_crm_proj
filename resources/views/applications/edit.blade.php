@extends('layouts.main')

@section('title', 'Редактирование заявки')

@push('styles')
    <style>
        .form-container {
            background: white;
            border-radius: 16px;
            padding: 2rem;
            box-shadow: 0 1px 3px rgba(0,0,0,0.06);
            border: 1px solid #f1f5f9;
            max-width: 800px;
            margin: 0 auto;
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-label {
            display: block;
            font-size: 0.875rem;
            font-weight: 600;
            color: #1e293b;
            margin-bottom: 0.5rem;
        }
        .form-label .required {
            color: #ef4444;
            margin-left: 2px;
        }
        .form-control {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #f8fafc;
            color: #1e293b;
            outline: none;
        }
        .form-control:focus {
            background: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .form-control.is-invalid {
            border-color: #ef4444;
        }
        .form-text {
            font-size: 0.8rem;
            color: #94a3b8;
            margin-top: 0.375rem;
        }
        .form-error {
            font-size: 0.8rem;
            color: #ef4444;
            margin-top: 0.375rem;
            display: flex;
            align-items: center;
            gap: 0.25rem;
        }
        .form-select {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            font-size: 0.95rem;
            transition: all 0.2s;
            background: #f8fafc;
            color: #1e293b;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%2394a3b8' d='M6 8L1 3h10z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            padding-right: 2.5rem;
        }
        .form-select:focus {
            background-color: white;
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }
        .form-select.is-invalid {
            border-color: #ef4444;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }
        .form-actions {
            display: flex;
            gap: 1rem;
            padding-top: 1.5rem;
            border-top: 1px solid #f1f5f9;
            margin-top: 0.5rem;
            flex-wrap: wrap;
        }
        .btn-cancel {
            background: transparent;
            border: 1px solid #e2e8f0;
            color: #475569;
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
        }
        .btn-cancel:hover {
            background: #f8fafc;
            border-color: #94a3b8;
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
            flex: 1;
            justify-content: center;
            min-width: 120px;
        }
        .btn-submit:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(99, 102, 241, 0.4);
        }
        .btn-delete {
            background: transparent;
            border: 1px solid #fecaca;
            color: #dc2626;
            padding: 0.625rem 1.5rem;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.2s;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        .btn-delete:hover {
            background: #fee2e2;
        }
        .page-header {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }
        .page-header h1 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #1e293b;
            margin: 0;
        }
        .page-header .breadcrumb {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: #94a3b8;
        }
        .page-header .breadcrumb a {
            color: #6366f1;
            text-decoration: none;
        }
        .page-header .breadcrumb a:hover {
            text-decoration: underline;
        }
        @media (max-width: 640px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .form-container {
                padding: 1rem;
            }
            .form-actions {
                flex-direction: column-reverse;
            }
            .btn-submit, .btn-cancel, .btn-delete {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
@endpush

@section('content')
    <div class="px-0">

        <div class="page-header">
            <div>
                <div class="breadcrumb">
                    <a href="{{ route('applications.index') }}">Заявки</a>
                    <span>/</span>
                    <span class="text-gray-600 font-medium">Редактирование #{{ $application->id }}</span>
                </div>
                <h1>
                    <i class="fas fa-file-pen text-indigo-500 mr-2"></i>
                    Редактирование заявки
                </h1>
                <p class="text-gray-500 text-sm mt-0.5">Измените данные заявки и сохраните изменения</p>
            </div>
        </div>

        <div class="form-container">
            <form action="{{ route('applications.update', $application) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label for="title" class="form-label">
                        Заголовок <span class="required">*</span>
                    </label>
                    <input type="text"
                           id="title"
                           name="title"
                           class="form-control @error('title') is-invalid @enderror"
                           value="{{ old('title', $application->title) }}"
                           required>
                    @error('title')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">Описание</label>
                    <textarea id="description"
                              name="description"
                              class="form-control @error('description') is-invalid @enderror"
                              rows="4">{{ old('description', $application->description) }}</textarea>
                    @error('description')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="department_id" class="form-label">
                            Отдел <span class="required">*</span>
                        </label>
                        <select id="department_id" name="department_id" class="form-select @error('department_id') is-invalid @enderror" required>
                            <option value="">Выберите отдел</option>
                            @foreach($departments as $department)
                                <option value="{{ $department->id }}" {{ old('department_id', $application->department_id) == $department->id ? 'selected' : '' }}>
                                    {{ $department->title }}
                                </option>
                            @endforeach
                        </select>
                        @error('department_id')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">
                            Статус <span class="required">*</span>
                        </label>
                        <select id="status" name="status" class="form-select @error('status') is-invalid @enderror" required>
                            @foreach($statuses as $value => $label)
                                <option value="{{ $value }}" {{ old('status', $application->status) == $value ? 'selected' : '' }}>
                                    {{ $label }}
                                </option>
                            @endforeach
                        </select>
                        @error('status')
                        <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label for="user_id" class="form-label">Пользователь</label>
                    <select id="user_id" name="user_id" class="form-select @error('user_id') is-invalid @enderror">
                        <option value="">Анонимная заявка</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}" {{ old('user_id', $application->user_id) == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                    @error('user_id')
                    <div class="form-error"><i class="fas fa-exclamation-circle"></i>{{ $message }}</div>
                    @enderror
                    <div class="form-text">Оставьте пустым, чтобы сделать заявку анонимной</div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('applications.index') }}" class="btn-cancel">
                        <i class="fas fa-arrow-left"></i>
                        Отмена
                    </a>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-save"></i>
                        Сохранить изменения
                    </button>
                </div>
            </form>

            <form action="{{ route('applications.destroy', $application) }}" method="POST" class="mt-3" onsubmit="return confirm('Удалить заявку #{{ $application->id }}?');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete">
                    <i class="fas fa-trash"></i>
                    Удалить заявку
                </button>
            </form>
        </div>

    </div>
@endsection
