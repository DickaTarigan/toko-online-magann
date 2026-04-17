<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title inertia> {{ config('app.name', 'Toko Online')}}</title>
     @vite(['resorces/css/app.css', 'resources/js/app.js'])
     @inertiaHead
</head>
<body class="font-sans antialiased bg-gray-50">
     @inertia
</body>
</html>