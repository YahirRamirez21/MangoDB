<header>
        <nav class="navbar">
            <a href="#home"><img src="{{ asset('img/logo.png') }}" class="logo"></a>
            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                @csrf
                <button type="submit" class="logout">Log Out</button>
            </form>
        </nav>
</header>

