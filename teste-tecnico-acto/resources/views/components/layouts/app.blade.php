@props(['title' => null])

<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="utf-8">
  <title>{{ $title ?? config('app.name') }}</title>
  <meta name="viewport" content="width=device-width,initial-scale=1">
  @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-gray-50 font-sans">
  @include('layouts.navigation')
  <!-- Page Heading -->
  @isset($header)
      <header class="bg-white shadow">
          <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
              {{ $header }}
          </div>
      </header>
  @endisset

  <main class="mt-4 max-w-7xl mx-auto px-4">
    {{ $slot }}
  </main>
</body>
</html>
