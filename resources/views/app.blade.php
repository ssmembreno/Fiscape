<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title inertia>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @routes
        @vite(['resources/js/app.js', "resources/js/Pages/{$page['component']}.vue"])
        @inertiaHead

        <!-- 👇 Archivos de la plantilla Eventix -->
      <link href="{{ asset('/assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/assets/vendor/bootstrap-icons/bootstrap-icons.css') }}" rel="stylesheet">
      <link href="{{ asset('/assets/vendor/aos/aos.css') }}" rel="stylesheet">
      <link href="{{ asset('/assets/vendor/swiper/swiper-bundle.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/assets/vendor/glightbox/css/glightbox.min.css') }}" rel="stylesheet">
      <link href="{{ asset('/assets/css/main.css') }}" rel="stylesheet">
    </head>
    <body class="font-sans antialiased">
        @inertia

    <!-- 👇 Scripts del template Eventix -->
      <script src="{{ asset('/assets/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
      <script src="{{ asset('/assets/vendor/php-email-form/validate.js') }}"></script>
      <script src="{{ asset('/assets/vendor/aos/aos.js') }}"></script>
      <script src="{{ asset('/assets/vendor/purecounter/purecounter_vanilla.js') }}"></script>
      <script src="{{ asset('/assets/vendor/imagesloaded/imagesloaded.pkgd.min.js') }}"></script>
      <script src="{{ asset('/assets/vendor/isotope-layout/isotope.pkgd.min.js') }}"></script>
      <script src="{{ asset('/assets/vendor/swiper/swiper-bundle.min.js') }}"></script>
      <script src="{{ asset('/assets/vendor/glightbox/js/glightbox.min.js') }}"></script>
      <script src="{{ asset('/assets/js/main.js') }}"></script>
    </body>
</html>
