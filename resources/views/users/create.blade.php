@extends('layouts.app')
@php($title = 'Создать пользователя')
@section('title', 'Создать пользователя')

@section('content')
<div class="container py-5">

    <!-- Заголовок страницы -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold mb-1">Создание пользователя</h2>
            <p class="text-muted mb-0">
                Добавление нового сотрудника в систему автопарка
            </p>
        </div>
        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">
            ← Назад
        </a>
    </div>

    <!-- Карточка формы -->
    <div class="card shadow-sm border-0">
        <div class="card-body p-4">

            <!-- Ошибки валидации -->
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Ошибка!</strong> Проверьте введённые данные.
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('users.store') }}" method="POST">
                @csrf

                <div class="row">
                    <!-- Имя -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Имя</label>
                        <input type="text" 
                               name="name" 
                               value="{{ old('name') }}"
                               class="form-control"
                               placeholder="Введите имя"
                               required>
                    </div>

                    <!-- Email -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Email</label>
                        <input type="email" 
                               name="email" 
                               value="{{ old('email') }}"
                               class="form-control"
                               placeholder="example@mail.com"
                               required>
                    </div>
                </div>

                <div class="row">
                    <!-- Пароль -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Пароль</label>
                        <input type="password" 
                               name="password"
                               class="form-control"
                               placeholder="Введите пароль"
                               required>
                    </div>

                    <!-- Роль -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label fw-semibold">Роль пользователя</label>
                        <select name="role" class="form-select">
                            <option value="admin">Администратор</option>
                            <option value="operator">Оператор</option>
                            <option value="driver">Водитель</option>
                        </select>
                    </div>
                </div>

                <!-- Кнопки -->
                <div class="d-flex justify-content-end gap-2 mt-4">
                    <a href="{{ route('users.index') }}" class="btn btn-light">
                        Отмена
                    </a>
                    <button type="submit" class="btn btn-primary px-4">
                        Создать пользователя
                    </button>
                </div>

            </form>
        </div>
    </div>
</div>
@endsection
