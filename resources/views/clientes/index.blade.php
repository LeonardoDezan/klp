@extends('layout')

@section('conteudo')
    <div class="">
        <div class="bg-white max-w-6xl mx-auto rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-center mb-6 border-b border-gray-300 pb-3">
                <h1 class="text-2xl font-bold text-gray-900">Clientes</h1>
                <a href="{{ route('clientes.create') }}"
                   class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-yellow-400 hover:text-gray-900 transition">
                    + Novo Cliente
                </a>
            </div>

            <livewire:clientes.cliente-lista />
        </div>
    </div>
@endsection

