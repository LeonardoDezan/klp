<?php
function formatarTelefone(string $telefone): string
{
    $telefone = preg_replace('/\D/', '', $telefone);

    if (strlen($telefone) === 11) {
        // Celular: (99) 9 9999-9999
        $ddd = substr($telefone, 0, 2);
        $primeiro = substr($telefone, 2, 1);
        $parte1 = substr($telefone, 3, 4);
        $parte2 = substr($telefone, 7, 4);
        return "($ddd) $primeiro $parte1-$parte2";
    } elseif (strlen($telefone) === 10) {
        // Fixo: (99) 9999-9999
        $ddd = substr($telefone, 0, 2);
        $parte1 = substr($telefone, 2, 4);
        $parte2 = substr($telefone, 6, 4);
        return "($ddd) $parte1-$parte2";
    }

    return $telefone; // Retorna cru se não bater com 10 ou 11 dígitos
}
