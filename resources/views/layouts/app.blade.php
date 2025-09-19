<!DOCTYPE html>
<html lang="{{ env('APP_LOCALE') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}?v={{ filemtime(public_path('css/styles.css')) }}">
    <title>@yield('page-title', 'page')</title>
  </head>
  <body>
    @yield('navbar')
    <main>
      @yield('content')
    </main>
    @yield('footer')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script defer>
      document.addEventListener('DOMContentLoaded', () => {
        const burger = document.querySelector('.navbar-burger')
        const menu = document.querySelector('.navbar-menu')
        const navItems = document.querySelectorAll('.navbar-link')

        burger.addEventListener('click', () => {
          burger.classList.toggle('is-active')
          menu.classList.toggle('is-active')
        })

        navItems.forEach(item => {
          item.addEventListener('click', () => {
            burger.classList.remove('is-active')
            menu.classList.remove('is-active')
          })
        })
      })
    </script>
  </body>
</html>
