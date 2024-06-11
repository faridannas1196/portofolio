<!DOCTYPE html>
<html lang="en" class="h-full">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Document</title>
  @vite('resources/css/app.css')
  <link rel="stylesheet" href="https://rsms.me/inter/inter.css">
  <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="h-full">
<div class="min-h-full">
 
  <x-navbar></x-navbar>
  <x-header>{{$header}}</x-header>

  
  <main>
    <div class="mx-auto max-w-7xl py-6 sm:px-6 lg:px-8">

        {{ $slot }}
    </div>
    <button id="scrollToTopButton" class="hidden fixed bottom-4 right-4 bg-blue-900 text-white p-3 rounded-full shadow-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-300">
      &#8679;
  </button>
  </main>
</div>
<script>
  // JavaScript untuk mengontrol visibilitas dan fungsi tombol scroll to top
  const scrollToTopButton = document.getElementById('scrollToTopButton');

  window.addEventListener('scroll', () => {
      if (window.scrollY > 100) {
          scrollToTopButton.classList.remove('hidden');
      } else {
          scrollToTopButton.classList.add('hidden');
      }
  });

  scrollToTopButton.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
  });
</script>
</body>
</html>