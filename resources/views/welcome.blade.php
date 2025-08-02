<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'FG') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
    <!-- nav bar section -->
<nav class="flex-wrap items-center justify-between">
   <div class="bg-zinc-300 min-h-screen">
    
  <!-- Header -->
  <header class="w-full bg-zinc-500 shadow-sm">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between py-4">
      <!-- Logo -->
      <div class="flex items-center space-x-2">
            <img src="https://play-lh.googleusercontent.com/s3Q_r6k5UXFcPIQxZXCOssMOubAOnEWJcv2_kgv0d9spJf0xbpybZi6LVccCIcIDTg" alt="Logo" class="w-12 h-12 rounded-full bg-emerald-200 object-cover">
       
        <span class="text-lg font-semibold text-black">Fitness Gain$</span>
      </div>
      <!-- Navigation Links -->
      
      <!-- Right Buttons -->
      <div class="flex items-center space-x-4">
        <a href="{{ route('login') }}" class="px-4 py-2 bg-zinc-300 text-black rounded-lg font-medium hover:bg-zinc-600 transition">Log in</a>
      </div>
    </div>
  </header>

  <!-- Hero Section -->
  <div class="max-w-7xl mx-auto px-6 py-12 grid md:grid-cols-2 gap-8 items-center">
    <!-- Left Content -->
    <div>
      <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">
        Fitness Gain$ <br />helps you with your <br/> fitness journey.
      </h1>
     
      <a
        href="{{ route('login') }}"
        class="px-6 py-3 bg-zinc-500 text-black font-medium text-lg rounded-lg hover:bg-zinc-200 transition"
      >
        Log In
      </a>
    </div>

    <!-- Right Content -->
    <div class="relative mt-12 ">
      
      <img
        src="https://img.freepik.com/premium-vector/young-man-shows-off-muscles-he-has-been-working-fitness-room-healthy-active-lifestyle-flat-style-cartoon-illustration-vector_610956-762.jpg?w=740" 
        alt="Acorns Mobile"
        class="relative rounded-md shadow-indigo-600 opacity-70 mx-auto "
      />
  </div>
</div>

  </body>
</html>
