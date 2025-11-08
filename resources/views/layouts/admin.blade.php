<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restaurant Admin</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100">
  <nav class="bg-white shadow p-4 flex justify-between">
      <h1 class="font-bold text-lg">🍽 Restaurant Admin</h1>
      <a href="{{ route('logout') }}"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
         class="text-red-500">Logout</a>
      <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">@csrf</form>
  </nav>

  <main class="p-6">
      @yield('content')
  </main>
</body>
</html>
