<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login - Sistema KLP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
</head>
<body class="bg-gray-100 text-gray-800">
<div class="min-h-screen flex items-center justify-center px-4">
    {{ $slot }}
</div>
@livewireScripts
</body>
</html>

