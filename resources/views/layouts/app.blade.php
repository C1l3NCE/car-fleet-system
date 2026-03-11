<!DOCTYPE html>
<html lang="ru">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Автопарк' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f172a;
            --sidebar-hover: #1e293b;
            --primary-color: #2563eb;
            --content-bg: #f1f5f9;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--content-bg);
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100vh;
            width: var(--sidebar-width);
            background: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            overflow-y: auto;
            transition: 0.3s ease;
            z-index: 1050;
        }

        .sidebar-title {
            font-weight: 600;
            font-size: 18px;
            text-align: center;
            margin-bottom: 25px;
        }

        .sidebar a {
            color: #94a3b8;
            padding: 12px 22px;
            display: flex;
            align-items: center;
            gap: 10px;
            text-decoration: none;
            font-size: 14px;
            transition: 0.2s ease;
            border-left: 3px solid transparent;
        }

        .sidebar a:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar a.active {
            background: var(--sidebar-hover);
            color: #fff;
            border-left: 3px solid var(--primary-color);
        }

        /* ===== CONTENT ===== */

        .main-content {
            margin-left: var(--sidebar-width);
            padding: 30px;
            min-height: 100vh;
            transition: 0.3s ease;
        }

        .topbar {
            background: #fff;
            padding: 15px 20px;
            border-radius: 14px;
            margin-bottom: 25px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
        }

        /* ===== OVERLAY ===== */

        #overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            opacity: 0;
            visibility: hidden;
            transition: 0.3s;
            z-index: 1040;
        }

        #overlay.show {
            opacity: 1;
            visibility: visible;
        }

        /* ===== MOBILE ===== */

        @media (max-width: 992px) {

            .sidebar {
                left: -260px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
                padding: 20px;
            }
        }
    </style>
</head>

<body>

    @auth
        <div id="overlay"></div>

        <div class="sidebar" id="sidebar">

            <div class="sidebar-title">
                🚗 Автопарк
            </div>

            @php $role = auth()->user()->role ?? null; @endphp

            <a href="{{ route('dashboard') }}"
               class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="bi bi-speedometer2"></i> Панель
            </a>

            @if($role === 'admin')
                <a href="{{ route('users.index') }}"
                   class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Пользователи
                </a>

                <a href="{{ route('vehicles.index') }}"
                   class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Машины
                </a>
            @endif

            @if($role === 'operator')
                <a href="{{ route('operator.vehicles') }}"
                   class="{{ request()->routeIs('operator.*') ? 'active' : '' }}">
                    <i class="bi bi-truck"></i> Все машины
                </a>

                <a href="{{ route('reports.maintenance') }}"
                   class="{{ request()->routeIs('reports.maintenance*') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-data"></i> Затраты
                </a>

                <a href="{{ route('reports.needMaintenance') }}"
                   class="{{ request()->routeIs('reports.needMaintenance*') ? 'active' : '' }}">
                    <i class="bi bi-wrench-adjustable-circle"></i> Требуют ТО
                </a>
            @endif

            @if($role === 'driver')
                <a href="{{ route('driver.myvehicle') }}"
                   class="{{ request()->routeIs('driver.*') ? 'active' : '' }}">
                    <i class="bi bi-car-front"></i> Моя машина
                </a>
            @endif

            <div class="px-3 mt-auto">
                <div class="bg-dark bg-opacity-25 rounded-4 p-3 mb-3 text-white">

                    <div class="d-flex align-items-center mb-2">
                        <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                             style="width:38px;height:38px;font-weight:600;">
                            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                        </div>

                        <div class="ms-2">
                            <div style="font-size:14px;font-weight:600;">
                                {{ auth()->user()->name }}
                            </div>
                            <div style="font-size:11px;opacity:0.7;">
                                {{ auth()->user()->email }}
                            </div>
                        </div>
                    </div>

                    <span class="badge bg-secondary">
                        {{ ucfirst($role) }}
                    </span>

                </div>

                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger w-100 rounded-3">
                        <i class="bi bi-box-arrow-right me-1"></i> Выход
                    </button>
                </form>
            </div>

        </div>
    @endauth


    <div class="main-content">

        <div class="topbar d-flex justify-content-between align-items-center">

            @auth
                <button class="btn btn-outline-secondary d-lg-none" id="menuToggle">
                    <i class="bi bi-list"></i>
                </button>
            @endauth

            <h5 class="mb-0">{{ $title ?? '' }}</h5>

        </div>

        @yield('content')

    </div>

    <script>
        const menuBtn = document.getElementById('menuToggle');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('overlay');

        if (menuBtn && sidebar) {
            menuBtn.addEventListener('click', () => {
                sidebar.classList.toggle('active');
                overlay.classList.toggle('show');
            });
        }

        if (overlay) {
            overlay.addEventListener('click', () => {
                sidebar.classList.remove('active');
                overlay.classList.remove('show');
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>
</html>
