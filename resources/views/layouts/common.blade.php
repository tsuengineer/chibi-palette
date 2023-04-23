<!doctype html>
<html lang="ja">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="ちびキャラ専用のAIイラスト投稿サイトです。">

    <title>@yield('title')</title>

    <!-- OGP -->
    <meta property="og:title" content="@yield('title')" />
    <meta property="og:description" content="ちびキャラ専用のAIイラスト投稿サイトです。" />
    <meta property="og:type" content="article">
    <meta property="og:url" content="https://chibipalette.com" />
    <meta property="og:image" content="https://chibipalette.com/@yield('ogPath', '')" />
    <meta property="og:site_name" content="ちびキャラパレット" />

    <!-- Twitter -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@aichibigirl" />
    <meta name="twitter:domain" content="chibipalette.com" />
    <meta name="twitter:image" content="https://chibipalette.com/@yield('ogPath', '')" />
    <meta property="twitter:title" content="@yield('title')" />
    <meta name="twitter:description" content="ちびキャラ専用のAIイラスト投稿サイトです。" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script async src="//platform.twitter.com/widgets.js" charset="utf-8"></script>
    <link rel ="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-T8Q2QZ2TG6"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());

        gtag('config', 'G-T8Q2QZ2TG6');
    </script>
</head>
<body id="@yield('body-id', '')">
<header id="header">
    @yield('header')
</header>
<div class="content" style="min-height: calc(100vh - 177px)">
    @yield('content')
</div>
<footer id="footer" style="background-color: #2d3238;">
    @yield('footer')
</footer>
</body>
</html>

