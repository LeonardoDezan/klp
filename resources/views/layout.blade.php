<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>KLP</title>
    @vite('resources/css/app.css')
    <style>[x-cloak] { display: none !important; }</style>
    @livewireStyles
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">


</head>

<body class="h-screen flex bg-gray-200">

<!-- Sidebar -->
        <livewire:sidebar/>

<!-- palco -->
<main class="flex-1 p-6 overflow-y-auto max-h-screen">

    @yield('conteudo')

    <livewire:alerta-mensagem />
</main>
@livewireScripts

</body>
</html>
