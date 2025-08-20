<nav class="navbar mx-4">
  <div class="navbar-container__apis">
    <a href="{{ env('HOME_URL') . '/admin' }}" class="navbar-link">Admin</a>
    <a href="{{ route('admin.alerts.index') }}" class="navbar-link">Alertas</a>
    <a href="{{ route('admin.users.index') }}" class="navbar-link">Usuarios</a>
    <a href="{{ route('admin.brigades.index') }}" class="navbar-link">Brigadistas</a>
    <a href="{{ route('admin.simulacrums.index') }}" class="navbar-link">Simulacros</a>
    <a href="{{ route('admin.reports.index') }}" class="navbar-link">Reportes</a>
    <a href="{{ route('admin.messages.index') }}" class="navbar-link">Mensajes</a>
    <a href="{{ route('admin.check_in.index') }}" class="navbar-link">Check-in</a>
  </div>
</nav>
