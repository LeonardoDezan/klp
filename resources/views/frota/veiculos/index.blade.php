@extends('layout')

@section('conteudo')
    <div class="bg-white max-w-6xl mx-auto rounded-2xl shadow-md">

        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h1 class="text-lg font-semibold">Veículos</h1>

            <a href="{{ route('veiculos.create') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Novo veículo
            </a>
        </div>

        <div class="p-6">
            <livewire:veiculos.veiculos-lista />
        </div>

    </div>
@endsection