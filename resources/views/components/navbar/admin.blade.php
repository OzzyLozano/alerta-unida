<nav class="navbar mx-4">
  <div class="navbar-container__apis">
    <a href="{{ env('HOME_URL') . '/admin' }}" class="navbar-link">Admin</a>
    <a href="{{ route('admin.alerts.index') }}" class="navbar-link">Alertas</a>
    <a href="{{ route('admin.users.index') }}" class="navbar-link">Usuarios</a>
    <a href="{{ route('admin.brigades.index') }}" class="navbar-link">Brigadistas</a>
    <a href="{{ route('admin.simulacrums.index') }}" class="navbar-link">Simulacros</a>
    @if(Auth::guard('brigade')->check())
      <form method="POST" action="{{ route('brigade.logout') }}" style="display:inline;">
        @csrf
        <button type="submit" class="navbar-link">
          Log Out
        </button>
      </form>
    @else
      <a href="{{ route('brigade.login') }}" class="navbar-link">Log In</a>
    @endif
  </div>
</nav>
