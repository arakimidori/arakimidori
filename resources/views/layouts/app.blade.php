<!DOCTYPE HTML>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <title>@yield('title')</title>
</head>

<body>
    <div class="container">
        @yield('content')
    </div>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-3gJwYpMtnR0bJmYh3z6kXJbN4GkqzZQ4R2q6m7rN4o="
        crossorigin="anonymous"></script>

    <script src="https://code.jquery.com/jquery-migrate-3.6.0.min.js"
        integrity="sha256-LWwll4H5AAC/20gH21NFgk4rYMvZhvc1KD0c5iG7QvM=" crossorigin="anonymous"></script>
    @stack('scripts')

    <script src="{{ asset('js/ajax.js') }}" defer></script>

    <!-- tablesorterプラグインを読み込む -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.1/js/jquery.tablesorter.min.js"></script>

</body>

</html>
