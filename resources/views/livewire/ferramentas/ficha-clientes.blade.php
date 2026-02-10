<div class="space-y-4">

    <style>
        @media print {
            .no-print { display: none !important; }

            /* cada "sheet" é uma página, com 2 fichas dentro */
            .sheet {
                page-break-after: always;
            }

            /* para caber bem na folha */
            .sheet-inner {
                display: flex;
                flex-direction: column;
                gap: 12px;
            }

            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        }

        .box-line {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px;
            min-height: 38px;
        }

        .box-big {
            border: 1px solid #d1d5db;
            border-radius: 10px;
            padding: 10px;
            height: 120px; /* caixa grande */
        }

        .label {
            font-size: 12px;
            color: #6b7280;
            margin-bottom: 4px;
        }

        .check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-right: 18px;
            font-size: 14px;
        }

        .check-box {
            width: 16px;
            height: 16px;
            border: 1px solid #111827;
            display: inline-block;
        }
    </style>

    {{-- Ações --}}
    <div class="no-print flex items-center justify-between">
        <div class="text-sm text-gray-600">
            XML importados: <b>{{ $totalXml }}</b> • Fichas: <b>{{ $totalNaoCadastrados }}</b>
        </div>

        <div class="flex gap-2">
            <button type="button"
                    class="px-3 py-2 rounded-lg border text-sm hover:bg-gray-50"
                    wire:click="limpar">
                Limpar
            </button>

            @if($totalNaoCadastrados > 0)
                <button type="button"
                        class="px-3 py-2 rounded-lg bg-black text-white text-sm hover:opacity-90"
                        onclick="window.print()">
                    Imprimir (2 por folha)
                </button>
            @endif
        </div>
    </div>

    {{-- Upload --}}
    <div class="no-print p-4 rounded-xl border bg-white space-y-3">
        <div>
            <label class="block text-sm font-medium mb-1">Importar XML (múltiplos)</label>
            <input type="file" multiple accept=".xml" wire:model="arquivos"
                   class="block w-full text-sm border rounded-lg p-2">
            @error('arquivos') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
            @error('arquivos.*') <p class="text-sm text-red-600 mt-1">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-2 items-center">
            <button type="button"
                    class="px-4 py-2 rounded-lg bg-blue-600 text-white text-sm hover:opacity-90"
                    wire:click="processar"
                    wire:loading.attr="disabled"
                    wire:target="processar,arquivos">
                Processar
            </button>

            <span class="text-sm text-gray-600" wire:loading wire:target="processar">
                Processando...
            </span>
        </div>
    </div>

    {{-- Resultado --}}
    @if($totalXml > 0 && $totalNaoCadastrados === 0)
        <div class="p-4 rounded-xl border bg-green-50 text-green-800">
            Nenhum cliente novo encontrado. Todos já estão cadastrados.
        </div>
    @endif

    @if($totalNaoCadastrados > 0)

        @php
            // divide em páginas com 2 fichas por folha
            $paginas = array_chunk($fichas, 2);
        @endphp

        @foreach($paginas as $pagina)
            <div class="sheet">
                <div class="sheet-inner">

                    @foreach($pagina as $ficha)
                        {{-- FICHA --}}
                        <div class="bg-white border rounded-xl p-5">

                            {{-- Cabeçalho --}}
                            <div class="flex items-center justify-between mb-3 border-b pb-2">
                                <div class="flex items-center gap-3">
                                    <img src="{{ asset('storage/logo-klp.png') }}" alt="KLP" class="h-9">
                                    <div>
                                        <div class="text-base font-semibold">Ficha de Cadastro do Cliente</div>
                                        <div class="text-xs text-gray-600">Emissão: {{ now()->format('d/m/Y') }}</div>
                                    </div>
                                </div>

                                <div class="text-xs text-gray-600">
                                    CNPJ: <span class="font-semibold text-gray-900">{{ $ficha['documento'] ?? '' }}</span>
                                </div>
                            </div>

                            {{-- Pré-preenchido --}}
                            <div class="grid grid-cols-12 gap-3 text-sm mb-3">
                                <div class="col-span-12">
                                    <div class="label">Razão Social (pré-preenchido)</div>
                                    <div class="box-line">{{ $ficha['razao_social'] ?? '' }}</div>
                                </div>
                            </div>

                            {{-- Para preencher --}}
                            <div class="grid grid-cols-12 gap-3 text-sm">

                                <div class="col-span-6">
                                    <div class="label">Responsável</div>
                                    <div class="box-line"></div>
                                </div>

                                <div class="col-span-3">
                                    <div class="label">Telefone</div>
                                    <div class="box-line"></div>
                                </div>

                                <div class="col-span-3">
                                    <div class="label">Email</div>
                                    <div class="box-line"></div>
                                </div>

                                <div class="col-span-12">
                                    <div class="label">Horário de funcionamento</div>
                                    <div class="box-line"></div>
                                </div>

                                <div class="col-span-12">
                                    <div class="label">Recebe Carreta?</div>
                                    <div class="box-line">
                                        <span class="check"><span class="check-box"></span> Sim</span>
                                        <span class="check"><span class="check-box"></span> Não</span>
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <div class="label">Descarga (marcar com “X”)</div>
                                    <div class="box-line">
                                        <span class="check"><span class="check-box"></span> Empilhadeira</span>
                                        <span class="check"><span class="check-box"></span> Puxado</span>
                                        <span class="check"><span class="check-box"></span> Batido</span>
                                    </div>
                                </div>

                                <div class="col-span-12">
                                    <div class="label">Observações</div>
                                    <div class="box-big"></div>
                                </div>
                            </div>
                            {{-- /FICHA --}}
                        </div>
                    @endforeach

                </div>
            </div>
        @endforeach
    @endif

</div>
