<!DOCTYPE html>
<html lang="en">

<head>
    @yield('head')
</head>

<body>
    @yield('success-error')
    <div class="page-wrapper" data-page-header>
        <div class="sidebar">
            @yield('sidebar')
        </div>

        <main class="main-wrapper">

            <header class="header">
                @yield('header')
            </header>

            <div class="content-wrapper">
                @yield('main-content')
            </div>

            <footer class="footer">
                @yield('footer')
            </footer>

        </main>
    </div>
    @stack('scripts')
</body>

</html>