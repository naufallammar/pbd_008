<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem POS')</title>
    @include('layouts.partials.styles')
</head>

<body>
    @include('layouts.partials.sidebar')

    <div class="main-wrapper">
        @include('layouts.partials.navbar')

        <main class="content-area">
            @include('layouts.partials.alert')
            @yield('content')
        </main>
    </div>

    @include('layouts.partials.scripts')
</body>

</html>
