<nav class="navbar">
  <a href="{{ env('HOME_URL') . '/admin' }}" class="logo-container">
    <img src="{{ asset('img/alerta_unida_isotipo.png') }}" alt="logo">
  </a>
  <div class="navbar-container__apis">
    <a href="{{ route('admin.alerts.index') }}" class="navbar-link">Alertas</a>
    <a href="{{ route('admin.users.index') }}" class="navbar-link">Usuarios</a>
    <a href="{{ route('admin.brigades.index') }}" class="navbar-link">Brigadistas</a>
    <a href="{{ route('admin.simulacrums.index') }}" class="navbar-link">Simulacros</a>
    <a href="{{ route('admin.reports.index') }}" class="navbar-link">Reportes</a>
  </div>
</nav>
