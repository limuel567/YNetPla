<!DOCTYPE html>
<html lang="en" class="@yield('class')">
    <head>
        <title>@yield('title') ~ YNetPla Admin</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1" />
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="apple-touch-icon" sizes="57x57" href="frontend/img/favicon/apple-icon-57x57.png">
        <link rel="apple-touch-icon" sizes="60x60" href="frontend/img/favicon/apple-icon-60x60.png">
        <link rel="apple-touch-icon" sizes="72x72" href="frontend/img/favicon/apple-icon-72x72.png">
        <link rel="apple-touch-icon" sizes="76x76" href="frontend/img/favicon/apple-icon-76x76.png">
        <link rel="apple-touch-icon" sizes="114x114" href="frontend/img/favicon/apple-icon-114x114.png">
        <link rel="apple-touch-icon" sizes="120x120" href="frontend/img/favicon/apple-icon-120x120.png">
        <link rel="apple-touch-icon" sizes="144x144" href="frontend/img/favicon/apple-icon-144x144.png">
        <link rel="apple-touch-icon" sizes="152x152" href="frontend/img/favicon/apple-icon-152x152.png">
        <link rel="apple-touch-icon" sizes="180x180" href="frontend/img/favicon/apple-icon-180x180.png">
        <link rel="icon" type="image/png" sizes="192x192"  href="frontend/img/favicon/android-icon-192x192.png">
        <link rel="icon" type="image/png" sizes="32x32" href="frontend/img/favicon/favicon-32x32.png">
        <link rel="icon" type="image/png" sizes="96x96" href="frontend/img/favicon/favicon-96x96.png">
        <link rel="icon" type="image/png" sizes="16x16" href="frontend/img/favicon/favicon-16x16.png">
        <link rel="manifest" href="frontend/img/favicon/manifest.json">
        <meta name="msapplication-TileColor" content="#ffffff">
        <meta name="msapplication-TileImage" content="frontend/img/favicon/ms-icon-144x144.png">
        <meta name="theme-color" content="#ffffff">
        @include('backend.includes.css')
    </head>
    <body class="app">

        @include('backend.includes.spinner')
    
        <div class="peers ai-s fxw-nw h-100vh">
          <div class="d-n@sm- peer peer-greed h-100 pos-r bgr-n bgpX-c bgpY-c bgsz-cv" style='background-image: url({{asset("frontend/img/banner-img.png")}})'>
            <div class="pos-a centerXY" style="left: 21%; top: 22%;">
                <img class="pos-a centerXY" src="{{asset('frontend/img/logo2.png')}}" alt="" height="300" width="400">
              {{-- <div class="bgc-white bdrs-50p pos-r" style='width: 120px; height: 120px;'>
              </div> --}}
            </div>
          </div>
          <div class="col-12 col-md-4 peer pX-40 pY-80 h-100 bgc-white scrollable pos-r" style='min-width: 320px;'>
            @yield('content')
          </div>
        </div>
      @include('backend.includes.js')
    </body>
</html>