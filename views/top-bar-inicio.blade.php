<!-- Barra de Navegacion -->
<nav class="navbar fixed-top navbar-expand-lg navbar-dark bg-darkblue">
  <div class="container">
    <a class="navbar-brand font-weight-bold" href="{{URL::to('cms/inicio')}}" style="padding:0;">ECSL 2019</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto">
        <li>
          <a id="top-navbar-menu" href="#body" style="display: none;" class="sr-only">Scroll to navbar</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" id="navbarinfo" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                Información General
              </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarinfo">
            <a class="dropdown-item" href="{{URL::to('cms/logistica')}}"><i class="fa fa-info-circle" aria-hidden="true"></i> Logística</a>
            <a class="dropdown-item" href="{{URL::to('cms/faq')}}"><i class="fa fa-question-circle-o" aria-hidden="true"></i> Preguntas Frecuentes</a>
          </div>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle " href="#" id="navbarEvento" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                Evento
              </a>
          <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarEvento">
            <!-- <a class="dropdown-item" href="{{URL::to('cms/inicio/registro')}}"><i class="fa fa-address-card-o" aria-hidden="true"></i> Registro</a> -->
            <a class="dropdown-item" href="{{URL::to('cms/estadisticas')}}"><i class="fa fa-bar-chart" aria-hidden="true"></i> Estadísticas</a>
            <a class="dropdown-item" href="{{URL::to('cms/ejes-tematicos')}}"><i class="fa fa-list-ul" aria-hidden="true"></i> Ejes Temáticos</a>
            <a class="dropdown-item" href="{{URL::to('cms/becas')}}"><i class="fa fa-graduation-cap" aria-hidden="true"></i> Becas</a>
            <a class="dropdown-item" href="{{URL::to('cms/eventos-anteriores')}}"><i class="fa fa-calendar" aria-hidden="true"></i> Eventos Anteriores</a>
            <!-- <a class="dropdown-item" href="{{URL::to('cms/inicio/agenda')}}"><i class="fa fa-calendar" aria-hidden="true"></i>  Agenda</a> -->
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="{{URL::to('cms/agenda')}}">Agenda</a>
        </li>
        <li class="nav-item dropdown">
          <a class="nav-link fake-link" data-toggle="modal" data-target="#Contact" role="button">Contacto</a>
        </li>
      </ul>
      <ul class="navbar-nav">
        @if(!AuthManager::isCmsUserGuest('ecsl2019slca'))
        <li class="nav-item dropdown">
          <a class="nav-link p-2 dropdown-toggle" href="#" id="navbarDropdownUserMenu" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <img class='rounded-circle' onerror="this.src='{{URL::asset('assets/kwaai/images/anonymous.png')}}'" src='{{{ Gravatar::buildGravatarURL( AuthManager::getCmsSessionLoggedUser('ecsl2019slca', 'email'), 40 ) }}}'> {{ substr(AuthManager::getCmsSessionLoggedUser('ecsl2019slca', 'firstname'), 0, 10) }}
          </a>
          <div class="dropdown-menu" aria-labelledby="navbarDropdownUserMenu">
            <a class="dropdown-item" id='cms-dashboard' href="{{URL::to('cms/dashboard')}}">Dashboard</a>
            <a class="dropdown-item fake-link" id='cms-logout'>Salir</a>
          </div>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{URL::to('/login')}}"><strong>Iniciar sesión</strong></a>
        </li>
      	@endif
      </ul>
    </div>
  </div>
</nav>
