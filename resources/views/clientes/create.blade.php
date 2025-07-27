@extends('layout')

@section('conteudo')
    @if (session('mensagem'))
        <livewire:alerta-mensagem
            :titulo="session('mensagem')['titulo']"
            :tipo="session('mensagem')['tipo']"
        />
    @endif
    <h1 class="text-2xl font-bold mb-4">Cadastrar Cliente</h1>

    <livewire:clientes.cliente-formulario :clienteId="$clienteId ?? null" />
@endsection
