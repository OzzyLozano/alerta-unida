<nav class="navbar mx-4">
  <div class="navbar-container__apis">
    <a href="{{ env('HOME_URL') . '/apis' }}" class="navbar-link">Apis</a>
    <a href="{{ route('alerts.index') }}" class="navbar-link">Alertas</a>
    <a href="{{ route('users.index') }}" class="navbar-link">Usuarios</a>
    <a href="{{ route('brigades.index') }}" class="navbar-link">Brigadistas</a>
  </div>
</nav>
