@extends('layout')

@section('conteudo')

<div class="bg-white max-w-6xl mx-auto rounded-2xl shadow-md">

    {{-- Cabeçalho --}}
    <div class="px-6 py-4 border-b border-gray-200">
        <h1 class="text-lg font-semibold">
            Cadastro de Veículo
        </h1>
    </div>

    {{-- Conteúdo (NÃO usar flex aqui) --}}
    <div class="p-6">
        <livewire:veiculos.veiculo-formulario />
    </div>

</div>

@endsection
