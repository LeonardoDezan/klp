<div x-data="{ aberto: true, submenu: null }"
     class="h-screen bg-gray-900 text-white transition-all duration-300"
     :class="aberto ? 'w-52' : 'w-20'">

    <!-- Logo e botão -->
    <div class="flex items-center justify-between p-4 border-b border-gray-700 h-20">
        <img src="{{ asset('storage/logo-klp.png') }}"
             alt="Logo"
             class="h-24 mx-auto mt-2"
             x-show="aberto"
             x-transition
        >


        <button @click="aberto = !aberto" class="text-gray-400 hover:text-white focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none"
                 viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
        </button>
    </div>

    <!-- Navegação -->
    <nav class="mt-4 space-y-2">
        <!-- Dashboard -->

        <a href="{{ route('dashboard') }}"
           class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 transition"
           :class="{ 'bg-gray-800': '{{ request()->routeIs('dashboard') }}' }">
            <span class="material-icons">dashboard</span>
            <span x-show="aberto" x-transition>Dashboard</span>
        </a>

        <!-- Clientes -->
        <div x-data="{ abertoClientes: false }">
            <button @click="abertoClientes = !abertoClientes"
                    class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-700 transition">
                <span class="material-icons">people</span>
                <span x-show="aberto" x-transition>Clientes</span>
                <svg x-show="aberto" :class="{ 'rotate-90': abertoClientes }"
                     class="ml-auto w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div x-show="abertoClientes && aberto" x-transition x-cloak class="pl-12 space-y-1 text-sm text-gray-300">
                <a href="{{ route('clientes.index') }}" class="block hover:text-white">Listar</a>
                <a href="{{ route('clientes.create') }}" class="block hover:text-white">Novo</a>
            </div>
        </div>

        <!-- Representantes -->
        <div x-data="{ abertoSub: false }">
            <button @click="abertoSub = !abertoSub"
                    class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-700 transition">
                <span class="material-icons">badge</span>
                <span x-show="aberto" x-transition>Representantes</span>
                <svg x-show="aberto" :class="{ 'rotate-90': abertoSub }"
                     class="ml-auto w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div x-show="abertoSub && aberto" x-transition x-cloak class="pl-12 space-y-1 text-sm text-gray-300">
                <a href="{{ route('representantes.index') }}" class="block hover:text-white">Listar</a>
                <a href="{{ route('representantes.create') }}" class="block hover:text-white">Novo</a>
            </div>
        </div>

        <!-- Usuários -->
        <a href="{{ route('usuarios.index') }}"
           class="flex items-center gap-3 px-4 py-2 hover:bg-gray-700 transition"
           :class="{ 'bg-gray-800': '{{ request()->routeIs('usuarios.*') }}' }">
            <span class="material-icons">manage_accounts</span>
            <span x-show="aberto" x-transition>Usuários</span>
        </a>

        <!-- Ferramentas -->
        <div x-data="{ abertoSub: false }">
            <button @click="abertoSub = !abertoSub"
                    class="flex items-center gap-3 w-full px-4 py-2 hover:bg-gray-700 transition">
                <span class="material-icons">construction</span>
                <span x-show="aberto" x-transition>Ferramentas</span>
                <svg x-show="aberto" :class="{ 'rotate-90': abertoSub }"
                     class="ml-auto w-4 h-4 transition-transform"
                     fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            <div x-show="abertoSub && aberto" x-transition x-cloak class="pl-12 space-y-1 text-sm text-gray-300">
                <a href="{{ route('ferramentas.romaneios') }}"
                   class="block hover:text-white {{ request()->routeIs('ferramentas.romaneios') ? 'text-gray-300 ' : '' }}">
                    Romaneios
                </a>
            </div>
        </div>


        <!-- Logout -->
        <div class="border-t border-gray-700">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="flex items-center gap-2 px-4 py-3 text-sm hover:bg-gray-800 transition w-full text-red-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                         viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5" />
                    </svg>
                    <span x-show="aberto" x-transition>Sair</span>
                </button>
            </form>
        </div>


    </nav>
</div>
