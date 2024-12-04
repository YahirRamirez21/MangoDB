<header>
        <nav class="navbar">
            <a href="#home" class="titulo">MangoDB</a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout">Log Out</button>
            </form>
        </nav>
</header>

