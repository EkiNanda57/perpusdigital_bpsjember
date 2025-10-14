<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title')</title>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

  <style>
    input[type="password"]::-ms-reveal,
    input[type="password"]::-webkit-credentials-auto-fill-button {
      display: none !important;
    }
  </style>
  
  @vite('resources/css/app.css')
</head>
<body class="antialiased">
  @yield('content')
</body>
</html>
