@extends('layout')

@section('conteudo')
    <div class="bg-white max-w-6xl mx-auto rounded-2xl shadow-md">

        <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
            <h1 class="text-lg font-semibold">Editar veículo</h1>

            <a href="{{ route('veiculos.index') }}"
               class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-50 text-sm">
                Voltar
            </a>
        </div>

        <div class="p-6">
            <livewire:veiculos.veiculo-formulario :veiculoId="$id" />
        </div>

    </div>
@endsection
