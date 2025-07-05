{{-- resources/views/layouts/stylepages.blade.php --}}
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', config('app.name', 'Laravel'))</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384‑Vkk+9PhQ+0Of0M3aM8mYOA75M98ENKQH3HxiqLvKz0lfjb2d96gk+e5+yhFxPJbM" crossorigin="anonymous" />
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384‑Vkk+9PhQ+0Of0M3aM8mYOA75M98ENKQH3HxiqLvKz0lfjb2d96gk+e5+yhFxPJbM" crossorigin="anonymous" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet" />

    <!-- AOS CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet" />

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Gtvk5mGil+e5POw3gksQXjHgdD8mx3YkzZ8J1DNK6/6rnT+FIWniwJj3BX1QJXOb" crossorigin="anonymous" />

    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
        integrity="sha512-pVnYH+dS0pXk6QVxwrWXEpl+8VwoVp9rNf1vV5b2Br1xHhwpbNzHnCv+Oe5h5eZL5X5fY0nP+IvljRVGD2fYkg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/dist/css/adminlte.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('vendor/adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css" rel="stylesheet">

    <!-- Google Font: Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-dNmYX0fCrGZtUgIqlr4O/ZZSjf9SOVnlcTsgze7vh6eGZlXBv0xgTwKtoDCN/0r8cErraY+CnKXkkQtvv7MXQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <!-- Make sure Font Awesome is properly loaded -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"
        integrity="sha512-dNmYX0fCrGZtUgIqlr4O/ZZSjf9SOVnlcTsgze7vh6eGZlXBv0xgTwKtoDCN/0r8cErraY+CnKXkkQtvv7MXQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    {{-- Your other CSS files: --}}
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @stack('css')
    <style>
        :root {
            /* Light Mode Colors */
            --primary-color: #6366f1;
            --primary-dark: #4f46e5;
            --primary-light: #a5b4fc;
            --secondary-color: #f8fafc;
            --accent-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --info-color: #3b82f6;

            /* Text Colors */
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-muted: #94a3b8;

            /* Background Colors */
            --bg-primary: #ffffff;
            --bg-secondary: #f8fafc;
            --bg-tertiary: #f1f5f9;
            --bg-card: #ffffff;

            /* Border & Shadow */
            --border-color: #e2e8f0;
            --border-light: #f1f5f9;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            --gradient-bg: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 50%, #e2e8f0 100%);
            --gradient-card: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }

        [data-theme="dark"] {
            /* Dark Mode Colors */
            --primary-color: #818cf8;
            --primary-dark: #6366f1;
            --primary-light: #c7d2fe;
            --secondary-color: #1e293b;
            --accent-color: #34d399;
            --warning-color: #fbbf24;
            --danger-color: #f87171;
            --info-color: #60a5fa;

            /* Text Colors */
            --text-primary: #f1f5f9;
            --text-secondary: #cbd5e1;
            --text-muted: #94a3b8;

            /* Background Colors */
            --bg-primary: #0f172a;
            --bg-secondary: #1e293b;
            --bg-tertiary: #334155;
            --bg-card: #1e293b;

            /* Border & Shadow */
            --border-color: #334155;
            --border-light: #475569;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.3);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.3), 0 2px 4px -2px rgb(0 0 0 / 0.3);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.3), 0 4px 6px -4px rgb(0 0 0 / 0.3);
            --shadow-xl: 0 20px 25px -5px rgb(0 0 0 / 0.3), 0 8px 10px -6px rgb(0 0 0 / 0.3);

            /* Gradients */
            --gradient-primary: linear-gradient(135deg, var(--primary-color) 0%, var(--primary-dark) 100%);
            --gradient-bg: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #334155 100%);
            --gradient-card: linear-gradient(145deg, #1e293b 0%, #334155 100%);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: var(--gradient-bg);
            color: var(--text-primary);
            line-height: 1.6;
            min-height: 100vh;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        /* Enhanced Navbar */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid var(--border-color);
            box-shadow: var(--shadow-sm);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
        }

        [data-theme="dark"] .navbar-custom {
            background: rgba(30, 41, 59, 0.95);
            border-bottom-color: var(--border-color);
        }

        .navbar-brand {
            font-weight: 800;
            font-size: 1.5rem;
            color: var(--primary-color) !important;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.75rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .navbar-brand:hover {
            color: var(--primary-dark) !important;
            transform: translateY(-2px);
        }

        .navbar-brand .bi {
            font-size: 1.75rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .lockscreen-logo {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin-left: 2rem;
        }

        .lockscreen-logo img {
            border-radius: 12px;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .lockscreen-logo img:hover {
            transform: scale(1.05) rotate(2deg);
            box-shadow: var(--shadow-lg);
        }

        /* Navigation Links */
        .navbar-nav .nav-link {
            color: var(--text-secondary) !important;
            font-weight: 600;
            padding: 0.75rem 1.25rem !important;
            border-radius: 12px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0 0.25rem;
        }

        .navbar-nav .nav-link:hover {
            color: var(--primary-color) !important;
            background: linear-gradient(135deg, rgba(99, 102, 241, 0.1), rgba(79, 70, 229, 0.05));
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .navbar-nav .nav-link::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 3px;
            background: var(--gradient-primary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .navbar-nav .nav-link:hover::before {
            width: 80%;
        }

        /* Dropdown Menu */
        .dropdown-menu {
            border: none;
            box-shadow: var(--shadow-xl);
            border-radius: 16px;
            padding: 0.75rem;
            margin-top: 0.75rem;
            background: var(--bg-card);
            backdrop-filter: blur(20px);
            min-width: 220px;
        }

        .dropdown-item {
            border-radius: 12px;
            padding: 0.875rem 1.25rem;
            font-weight: 600;
            color: var(--text-secondary);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .dropdown-item:hover {
            background: var(--gradient-primary);
            color: white;
            transform: translateX(6px);
            box-shadow: var(--shadow-md);
        }

        .dropdown-item i {
            width: 20px;
            text-align: center;
            font-size: 1.1rem;
        }

        /* User Avatar */
        .user-avatar {
            width: 36px;
            height: 36px;
            background: var(--gradient-primary);
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            font-size: 0.875rem;
            margin-right: 0.75rem;
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .user-avatar:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Sidebar Enhancements */
        .sidebar-offcanvas {
            width: 320px;
            background: var(--bg-card);
            box-shadow: var(--shadow-xl);
            border: none;
        }

        .sidebar-offcanvas .offcanvas-header {
            height: 80px;
            padding: 1.5rem;
            background: var(--gradient-card);
            border-bottom: 1px solid var(--border-color);
        }

        .sidebar-user {
            background: var(--bg-secondary);
            padding: 1.5rem;
            border-bottom: 1px solid var(--border-color);
            transition: all 0.3s ease;
        }

        .sidebar-user:hover {
            background: var(--bg-tertiary);
        }

        .sidebar-user .user-avatar {
            width: 48px;
            height: 48px;
            font-size: 1.1rem;
            margin-right: 1rem;
        }

        /* Navigation Links Container */
        .sidebar-nav {
            padding: 1rem 0;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            padding: 1rem 1.5rem;
            color: var(--text-secondary) !important;
            font-weight: 600;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            margin: 0.25rem 1rem;
            border-radius: 12px;
            text-decoration: none;
        }

        .sidebar-nav .nav-link i {
            font-size: 1.2rem;
            width: 28px;
            text-align: center;
            margin-right: 1rem;
            transition: all 0.3s ease;
        }

        .sidebar-nav .nav-link:hover,
        .sidebar-nav .nav-link.active {
            background: var(--gradient-primary);
            color: white !important;
            transform: translateX(8px);
            box-shadow: var(--shadow-md);
        }

        .sidebar-nav .nav-link:hover i,
        .sidebar-nav .nav-link.active i {
            color: white !important;
            transform: scale(1.1);
        }

        .sidebar-nav .nav-link.active::before {
            content: '';
            position: absolute;
            left: -1rem;
            top: 50%;
            transform: translateY(-50%);
            width: 4px;
            height: 60%;
            background: white;
            border-radius: 2px;
        }

        /* Dark Mode Toggle */
        /* Base Dark Mode Button */
        #darkModeToggle {
            background: linear-gradient(135deg, #2b2b2b, #3d3d3d);
            border: none;
            color: #f0f0f0;
            border-radius: 999px;
            padding: 0.6rem 1.2rem;
            font-weight: 600;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
            transition: all 0.4s ease-in-out;
            position: relative;
            overflow: hidden;
            width: 100%;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dropdown-menu {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
        }

        /* Hover Animation */
        #darkModeToggle::before {
            content: "";
            position: absolute;
            top: 0;
            left: -75%;
            width: 200%;
            height: 100%;
            background: linear-gradient(120deg, rgba(255, 255, 255, 0.05), rgba(255, 255, 255, 0));
            transform: skewX(-20deg);
            transition: 0.5s;
            z-index: 0;
        }

        #darkModeToggle:hover::before {
            left: 100%;
        }

        #darkModeToggle:hover {
            background: linear-gradient(135deg, #1e1e1e, #292929);
            color: #ffffff;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.2);
            transform: translateY(-2px);
        }

        /* Inner content stays on top */
        #darkModeToggle i,
        #darkModeToggle span {
            z-index: 1;

        }

        #mdropdownmenu {
            display: flex;
            justify-content: center;
            align-content: center;
            text-align: center;

        }

        #navitemdropdownmenu {
            display: flex;
            justify-content: center;
            align-content: center;
            text-align: center;
            padding: 0;
            width: 100%;


        }

        /*
         navitemdropdownmenu
        */
        .content-main {
            background: var(--bg-card);
            border-radius: 24px;
            box-shadow: var(--shadow-lg);
            padding: 3rem;
            border: 1px solid var(--border-color);
            margin: 2rem auto;
            max-width: 1400px;
            transition: all 0.3s ease;
        }

        .content-main:hover {
            box-shadow: var(--shadow-xl);
        }

        /* Utility Classes */
        .text-gradient {
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .btn-primary-custom {
            background: var(--gradient-primary);
            border: none;
            border-radius: 12px;
            padding: 0.875rem 2rem;
            font-weight: 700;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: var(--shadow-md);
            color: white;
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-xl);
            color: white;
        }

        /* Animations */
        @keyframes logoPulse {

            0%,
            100% {
                transform: scale(1) rotate(0deg);
            }

            50% {
                transform: scale(1.05) rotate(2deg);
            }
        }

        .img-logo {
            animation: logoPulse 6s ease-in-out infinite;
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .lockscreen-logo {
                display: none;
            }

            .navbar-brand {
                font-size: 1.25rem;
            }

            .content-main {
                margin: 1rem;
                padding: 2rem;
                border-radius: 16px;
            }

            .sidebar-offcanvas {
                width: 280px;
            }
        }

        /* Loading States */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        /* Selection */
        ::selection {
            background: var(--primary-color);
            color: white;
        }

        /* Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--bg-secondary);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--border-color);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--text-muted);
        }

        /* Focus States */
        .btn:focus,
        .nav-link:focus,
        .dropdown-item:focus {
            outline: 2px solid var(--primary-color);
            outline-offset: 2px;
        }

        /* darkmode */
        body.dark-mode .card {
            background-color: #404040 !important;
            border-color: #404040 !important;
            color: #4d4f97 !important;
        }

        /* dark mode css style  */

        body[data-theme="dark"] .offcanvas-body {
            background-color: #343a40 !important;
            /* same as Bootstrap’s bg-dark */
        }

        body[data-theme='dark'] .dropdown-menu {
            text-shadow: 0 0 1px rgba(236, 29, 255, 0.289);
        }

        body[data-theme='dark'] .card-primary {
            background-color: var(--bg-card);
            color: white;
        }

        body[data-theme='dark'] .d-flex {
            color: white !important;
        }

        body[data-theme='dark'] .mb-0 {
            color: rgb(63, 62, 62) !important;
        }

        body[data-theme='dark'] .text-muted {
            color: rgba(0, 0, 0, 0.674) !important;
        }

        body[data-theme='dark'] .font-weight-bold {
            color: rgb(255, 255, 255) !important;
            text-shadow: 0 0 1px rgba(0, 0, 0, 0.45);
        }

        body[data-theme='dark'] #createForm,
        .card-body {
            background-color: white;
            color: rgb(0, 0, 0) !important;
        }

        /* fas fa-users
        createForm
        font-weight-bold text-dark
        font-weight-bold text-dark  */
        /*--bg-table
 
        /* body[data-theme='dark'] .d-flex,
        body[data-theme='dark'] .d-flex * {
            color: rgb(255, 255, 255) !important;
            text-emphasis:  0 0 2px rgba(0, 0, 0, 0.308);
        } */
        body[data-theme='dark'] .pagination,
        body[data-theme='dark'] .pagination * {
            color: rgba(87, 18, 152, 0.921) !important;
        }


        .form-check-input[type=checkbox] {
            border-radius: .25em;
            position: relative;
            left: 27px;
            top: 9px;
            box-shadow: 0 0 2px -1px black;
        }

        /* cards stye */
        /* General Form Input Styling */
        form .form-control {
            border-radius: 0.5rem;
            border: 1px solid #ced4da;
            padding: 0.55rem 1rem;
            transition: all 0.3s ease;
            box-shadow: none;
            font-size: 0.95rem;
        }

        form .form-control:focus {
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.4);
            outline: none;
        }

        /* Stylish Select Dropdown */
        select.form-control {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23666' class='bi bi-chevron-down' viewBox='0 0 16 16'%3E%3Cpath fill-rule='evenodd' d='M1.646 4.646a.5.5 0 0 1 .708 0L8 10.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 1rem;
            padding-right: 2.5rem;
            cursor: pointer;
        }

        /* Hover effect for select */
        select.form-control:hover {
            border-color: #80bdff;
        }

        /* Animate option hover (limited, as native select is system-controlled) */
        select.form-control option {
            background-color: #fff;
            color: #333;
        }

        /* Option hover effect (may vary by browser) */
        select.form-control option:hover {
            background-color: #007bff;
            color: #fff;
        }

        /* Animate Search Button */
        form .btn-primary {
            transition: background-color 0.3s ease, transform 0.2s ease;
            border-radius: 0.5rem;
        }

        form .btn-primary:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        /* Smooth Table Hover */
        .table-hover tbody tr:hover {
            background-color: #eef7ff;
            transition: background-color 0.3s ease;
        }

        /* Checkbox Scale on Hover */
        input[type="checkbox"].form-check-input:hover {
            transform: scale(1.3);
            transition: transform 0.2s ease;
        }

        /* Bulk Action Buttons */
        #bulkActionForm .btn-group .btn {
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        #bulkActionForm .btn-group .btn:hover {
            transform: scale(1.05);
        }

        /* Badge Styling */
        .badge {
            transition: transform 0.2s ease;
        }

        .badge:hover {
            transform: scale(1.1);
        }

        /* xxxxxxxxxxxxxxxxxxx */

        /* Home Container */
        .home-container {
            min-height: 100vh;
            background: var(--gradient-bg);
        }

        /* Hero Section */
        .hero-section {
            background: var(--gradient-card);
            padding: 4rem 2rem;
            border-radius: 0 0 2rem 2rem;
            margin-bottom: 3rem;
            border: 1px solid var(--border-color);
        }

        .hero-content {
            text-align: center;
            max-width: 800px;
            margin: 0 auto 3rem;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 800;
            color: var(--text-primary);
            margin-bottom: 1rem;
            background: var(--gradient-primary);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            color: var(--text-secondary);
            margin-bottom: 2rem;
            font-weight: 500;
        }

        /* Search Bar */
        .hero-search {
            max-width: 600px;
            margin: 0 auto;
        }

        .search-form {
            position: relative;
        }

        .search-input-group {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--bg-card);
            border: 2px solid var(--border-color);
            border-radius: 50px;
            padding: 0.75rem 1.5rem;
            box-shadow: var(--shadow-lg);
            transition: all 0.3s ease;
        }

        .search-input-group:focus-within {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }

        .search-icon {
            color: var(--text-muted);
            margin-right: 1rem;
            font-size: 1.1rem;
        }

        .search-input {
            flex: 1;
            border: none;
            outline: none;
            background: transparent;
            font-size: 1.1rem;
            color: var(--text-primary);
            font-weight: 500;
        }

        .search-input::placeholder {
            color: var(--text-muted);
        }

        .search-btn {
            background: var(--gradient-primary);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-left: 1rem;
        }

        .search-btn:hover {
            transform: scale(1.1);
            box-shadow: var(--shadow-md);
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 1.5rem;
            max-width: 1000px;
            margin: 0 auto;
        }

        .stat-card {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-icon {
            width: 50px;
            height: 50px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--gradient-primary);
            color: white;
            font-size: 1.25rem;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 800;
            color: var(--text-primary);
            margin: 0;
        }

        .stat-label {
            color: var(--text-secondary);
            font-weight: 600;
            margin: 0;
        }

        /* Main Content */
        .main-content {
            padding: 0 2rem 3rem;
        }

        .content-grid {
            display: grid;
            grid-template-columns: 300px 1fr;
            gap: 3rem;
            max-width: 1400px;
            margin: 0 auto;
        }

        /* Sidebar */
        .sidebar {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 2rem;
            height: fit-content;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
            position: sticky;
            top: 2rem;
        }

        .sidebar-section {
            margin-bottom: 2rem;
        }

        .sidebar-section:last-child {
            margin-bottom: 0;
        }

        .sidebar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
        }

        /* Category List */
        .category-list {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .category-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            color: var(--text-secondary);
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .category-item:hover {
            background: var(--bg-secondary);
            color: var(--primary-color);
            border-color: var(--border-color);
        }

        .category-name {
            font-weight: 500;
        }

        .category-count {
            background: var(--bg-secondary);
            color: var(--text-muted);
            padding: 0.25rem 0.5rem;
            border-radius: 12px;
            font-size: 0.875rem;
            font-weight: 600;
        }

        /* Recent List */
        .recent-list {
            display: flex;
            flex-direction: column;
            gap: 0.75rem;
        }

        .recent-item {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: 1px solid transparent;
        }

        .recent-item:hover {
            background: var(--bg-secondary);
            border-color: var(--border-color);
        }

        .recent-icon {
            width: 35px;
            height: 35px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--bg-secondary);
            color: var(--primary-color);
            flex-shrink: 0;
        }

        .recent-title {
            font-weight: 600;
            color: var(--text-primary);
            margin: 0 0 0.25rem;
            font-size: 0.875rem;
        }

        .recent-date {
            color: var(--text-muted);
            font-size: 0.75rem;
        }

        /* Quick Upload */
        .quick-upload-card {
            background: var(--gradient-primary);
            border-radius: 12px;
            padding: 1.5rem;
            text-align: center;
            color: white;
        }

        .quick-upload-title {
            font-size: 1.1rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .quick-upload-text {
            font-size: 0.875rem;
            opacity: 0.9;
            margin-bottom: 1rem;
        }

        .quick-upload-btn {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .quick-upload-btn:hover {
            background: rgba(255, 255, 255, 0.3);
            color: white;
            transform: translateY(-2px);
        }

        /* Documents Area */
        .documents-area {
            background: var(--bg-card);
            border-radius: 16px;
            padding: 2rem;
            border: 1px solid var(--border-color);
            box-shadow: var(--shadow-md);
        }

        /* Filters Section */
        .filters-section {
            margin-bottom: 2rem;
        }

        .filters-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .filters-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
        }

        .view-toggle {
            display: flex;
            gap: 0.5rem;
        }

        .view-btn {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-btn.active,
        .view-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .filters-form {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-group {
            flex: 1;
            min-width: 150px;
        }

        .filter-select {
            width: 100%;
            padding: 0.75rem;
            border: 1px solid var(--border-color);
            border-radius: 8px;
            background: var(--bg-secondary);
            color: var(--text-primary);
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        .filter-apply-btn,
        .filter-clear-btn {
            padding: 0.75rem 1.5rem;
            border-radius: 8px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .filter-apply-btn {
            background: var(--gradient-primary);
            color: white;
        }

        .filter-apply-btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .filter-clear-btn {
            background: var(--bg-secondary);
            color: var(--text-secondary);
            border: 1px solid var(--border-color);
        }

        .filter-clear-btn:hover {
            background: var(--danger-color);
            color: white;
            border-color: var(--danger-color);
        }

        /* Documents Grid */
        .documents-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .document-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            overflow: hidden;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-sm);
        }

        .document-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
            border-color: var(--primary-color);
        }

        .document-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem;
            border-bottom: 1px solid var(--border-light);
        }

        .document-type-badge {
            background: var(--gradient-primary);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .document-actions {
            display: flex;
            gap: 0.5rem;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--border-color);
            background: var(--bg-secondary);
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .action-btn:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .document-content {
            padding: 1rem;
        }

        .document-title {
            margin: 0 0 1rem;
            font-size: 1.1rem;
            font-weight: 700;
        }

        .document-title a {
            color: var(--text-primary);
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .document-title a:hover {
            color: var(--primary-color);
        }

        .document-meta {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .document-category,
        .document-date {
            display: flex;
            align-items: center;
            font-size: 0.875rem;
            color: var(--text-secondary);
        }

        .document-category a {
            color: var(--primary-color);
            text-decoration: none;
            font-weight: 600;
        }

        .document-footer {
            display: flex;
            gap: 0.75rem;
            padding: 1rem;
            border-top: 1px solid var(--border-light);
        }

        .btn-view,
        .btn-download {
            flex: 1;
            padding: 0.75rem;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            text-align: center;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .btn-view {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-view:hover {
            background: var(--primary-color);
            color: white;
            border-color: var(--primary-color);
        }

        .btn-download {
            background: var(--gradient-primary);
            color: white;
            border: 1px solid var(--primary-color);
        }

        .btn-download:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        /* No Documents */
        .no-documents {
            grid-column: 1 / -1;
            text-align: center;
            padding: 4rem 2rem;
        }

        .no-documents-icon {
            font-size: 4rem;
            color: var(--text-muted);
            margin-bottom: 1rem;
        }

        .no-documents-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.5rem;
        }

        .no-documents-text {
            color: var(--text-secondary);
            margin-bottom: 2rem;
        }

        /* Pagination */
        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 1200px) {
            .content-grid {
                grid-template-columns: 250px 1fr;
                gap: 2rem;
            }
        }

        @media (max-width: 992px) {
            .content-grid {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .sidebar {
                position: static;
            }

            .hero-title {
                font-size: 2.5rem;
            }

            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 768px) {
            .hero-section {
                padding: 2rem 1rem;
            }

            .hero-title {
                font-size: 2rem;
            }

            .main-content {
                padding: 0 1rem 2rem;
            }

            .documents-grid {
                grid-template-columns: 1fr;
            }

            .filters-form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-group {
                min-width: auto;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>

<body data-theme="light">
    {{-- Top Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-custom animate-fade-in-up">
        <div class="container-fluid">
            {{-- Sidebar Toggle --}}
            <button class="btn btn-link text-secondary" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebar" aria-controls="sidebar" aria-label="Toggle sidebar">
                <i class="bi bi-list fs-4"></i>
            </button>

            {{-- Brand / Logo --}}
            <a class="navbar-brand ms-2" href="{{ url('/') }}">
                <i class="bi bi-lightning-charge-fill"></i>
                @if (config('adminlte.logo_img'))
                    <img src="{{ asset(config('adminlte.logo_img')) }}" height="40" alt="Logo" class="img-logo">
                @endif
                <span class="text-gradient">{{ config('app.name', 'SoliLMS') }}</span>
            </a>
            {{-- Navbar Collapse --}}
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation">
                <i class="bi bi-three-dots-vertical"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        @php
                            $user = auth()->user();
                            $path = request()->path(); // 'home', '', 'dashboard'
                        @endphp

                        @if ($user && ($user->isAdmin() || $user->isFormateur()))
                            @if ($path === '/' || $path === 'home')
                                <a class="nav-link" href="{{ route('dashboard') }}">
                                    <i class="bi bi-house me-1"></i>Dashboard
                                </a>
                            @elseif ($path === 'dashboard')
                                <a class="nav-link" href="{{ route('home') }}">
                                    <i class="bi bi-house me-1"></i>Home
                                </a>
                            @endif
                        @endif
                    </li>

                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Login
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">
                                <i class="bi bi-person-plus me-1"></i>Register
                            </a>
                        </li>
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle d-flex align-items-center"
                                href="" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="user-avatar">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                                <span>{{ Auth::user()->name }}</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" id="dropdownmenu" style="text-align: center;">
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-person"></i>Profile
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="#">
                                        <i class="bi bi-gear"></i>Settings
                                    </a>
                                </li>

                                <li>
                                    <button id="darkModeToggle" class="btn me-3" title="Toggle Dark Mode">
                                        <i class="bi bi-moon-fill"></i>
                                        <span class="d-none d-md-inline">Dark</span>
                                    </button>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="bi bi-box-arrow-right"></i>Logout
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                        class="d-none">
                                        @csrf
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>

    {{-- Sidebar Offcanvas --}}
    <div class="offcanvas offcanvas-start sidebar-offcanvas" tabindex="-1" id="sidebar"
        aria-labelledby="sidebarLabel">
        <div class="offcanvas-header">
            <a class="navbar-brand" href="{{ url('/') }}">
                <i class="bi bi-lightning-charge-fill"></i>
                @if (config('adminlte.logo_img'))
                    <img src="{{ asset(config('adminlte.logo_img')) }}" height="40" alt="Logo"
                        class="img-logo">
                @endif
                <span class="text-gradient">{{ config('app.name', 'SoliLMS') }}</span>
            </a>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>

        <div class="offcanvas-body p-0" id="offcanvasBody">
            @auth
                <div class="sidebar-user">
                    <div class="d-flex align-items-center">
                        <div class="user-avatar">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="fw-bold">{{ Auth::user()->name }}</div>
                            <small class="text-muted">{{ Auth::user()->email }}</small>
                        </div>
                    </div>
                </div>
            @endauth

            <nav class="nav flex-column sidebar-nav">
                @if ((auth()->check() && auth()->user()->isAdmin()) || auth()->user()->isFormateur())
                    <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                        href="{{ route('dashboard') }}">
                        <i class="bi bi-speedometer2"></i>
                        Dashboard
                    </a>
                @endif
                <a class="nav-link {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <i class="bi bi-person-circle"></i>
                    Profile
                </a>
                <a class="nav-link {{ request()->routeIs('settings') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i>
                    Settings
                </a>
                <a class="nav-link {{ request()->routeIs('reports') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i>
                    Reports
                </a>
                @if (request()->routeIs('dashboard'))
                    <a class="nav-link" id="exportData" href="#">
                        <i class="bi bi-download"></i>
                        Export Data
                    </a>
                @endif
                <a class="nav-link {{ request()->routeIs('help') ? 'active' : '' }}">
                    <i class="bi bi-question-circle"></i>
                    Help
                </a>
            </nav>
        </div>
    </div>

    {{-- Main Content --}}
    <div class="content-main animate-fade-in-up">
        @yield('content_header')
        @yield('content')
    </div>

    {{-- Scripts --}}
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" />
    <!-- Bootstrap 5 JS Bundle (includes Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384‑Us1eG6jeN3K6ZVXeqRO6LZxAcjEA9zP+N+Lhq8e/yZdh9t6zQD1Q8t+Z8y4T+gHg" crossorigin="anonymous">
    </script>
    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384‑Us1eG6jeN3K6ZVXeqRO6LZxAcjEA9zP+N+Lhq8e/yZdh9t6zQD1Q8t+Z8y4T+gHg" crossorigin="anonymous">
    </script>

    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 600,
                once: true
            });
        });
    </script>

    <!-- AOS JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            AOS.init({
                duration: 800,
                easing: 'ease-in-out',
                once: true
            });
        });
    </script>

    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script src="{{ asset('vendor/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('vendor/adminlte/dist/js/adminlte.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dark Mode Toggle
        document.addEventListener('DOMContentLoaded', function() {
            const darkModeToggle = document.getElementById('darkModeToggle');
            const body = document.body;
            const icon = darkModeToggle.querySelector('i');
            const text = darkModeToggle.querySelector('span');

            // Check for saved theme preference
            const savedTheme = localStorage.getItem('theme') || 'light';
            setTheme(savedTheme);

            darkModeToggle.addEventListener('click', function() {
                const currentTheme = body.getAttribute('data-theme');
                let newTheme;

                if (currentTheme === 'light') {
                    newTheme = 'dark';
                } else {
                    newTheme = 'light';
                }

                setTheme(newTheme);
            });

            function setTheme(theme) {
                body.setAttribute('data-theme', theme);
                localStorage.setItem('theme', theme);

                if (theme === 'dark') {
                    icon.className = 'bi bi-sun-fill';
                    if (text) text.textContent = 'Light';
                } else {
                    icon.className = 'bi bi-moon-fill';
                    if (text) text.textContent = 'Dark';
                }

                // Dispatch custom event for charts
                window.dispatchEvent(new CustomEvent('themeChanged', {
                    detail: {
                        theme
                    }
                }));
            }



        });
    </script>
    <!-- somewhere near the bottom of the <body> -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>


    @stack('scripts')
    @stack('js')

</body>

</html>
