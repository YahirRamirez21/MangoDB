<header>
    <nav class="navbar" role="navigation" aria-label="Navegación principal">
        <a href="#home"><img src="{{ asset('img/logo.png') }}" class="logo"></a>
        <a id="inicio" href="{{ $link ?? '#' }}">Inicio</a>
        <form action="{{ route('logout') }}" method="POST" style="display: inline;">
            @csrf
            <div class="contenedor-close">
                <button type="submit" class="logout close"> 
                    <svg class="icono" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 9V5.25A2.25 2.25 0 0 1 10.5 3h6a2.25 2.25 0 0 1 2.25 2.25v13.5A2.25 2.25 0 0 1 16.5 21h-6a2.25 2.25 0 0 1-2.25-2.25V15m-3 0-3-3m0 0 3-3m-3 3H15" />
                    </svg> 
                    <span>Cerrar Sesion</span>
                </button>
            </div>
        </form>
    </nav>
</header>
<br>