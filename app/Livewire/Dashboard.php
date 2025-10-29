<?php


namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Computed;
use App\Models\Cliente;

class Dashboard extends Component
{
    /** Atualização automática (a cada 60s) */
    public int $pollSeconds = 60;

    #[Computed]
    public function totalClientes(): int
    {
        return Cliente::count();
    }

    #[Computed]
    public function clientesUltimos30Dias(): int
    {
        return Cliente::where('created_at', '>=', now()->subDays(30))->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
