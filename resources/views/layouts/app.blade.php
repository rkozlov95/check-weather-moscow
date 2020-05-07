<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="csrf-param" content="_token" />
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
  </head>
  <body>
    <div class="container h-100">
        <div class="row h-100 justify-content-center align-items-center">
            @yield('content')
        </div>
    </div>
    <script src="/js/app.js"></script>
    <script>
        @yield('script')
    </script>
  </body>
</html>
