<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    @vite('resources/css/styleLogin.css')

</head>

<body>
    <div class="login-box">
        <div class="login-header">
            <header>
                <img src="{{ asset('img/logo.png') }}" class="logo">
            </header>
        </div>

        <form method="POST" action="{{ route('login.post') }}">
            @csrf
            <div class="input-box">
                <input
                    type="text"
                    name="nombre"
                    class="input-field"
                    placeholder="Usuario"
                    autocomplete="off"
                    required>
            </div>
            <div class="input-box">
                <input
                    type="password"
                    name="password"
                    class="input-field"
                    placeholder="Password"
                    autocomplete="off"
                    required>
            </div>
            <div class="forgot">
                <section>
                    <input
                        type="checkbox"
                        id="check"
                        name="remember">
                    <label for="check">Recuérdame</label>
                </section>
            </div>
            <form method="POST" action="{{ route('hectareas.index') }}">
                @csrf
                <input class="input-submit" type="hidden" name="usuario_id" value="{{ Auth::check() ? Auth::user()->nombre : '' }}">


                <button class="submit-btn" type="submit">Ir a Hectáreas</button>
            </form>
        </form>

    </div>
</body>

</html>