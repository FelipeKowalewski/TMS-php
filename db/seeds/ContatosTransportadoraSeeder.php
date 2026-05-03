<?php

use Phinx\Seed\AbstractSeed;

class ContatosTransportadoraSeeder extends AbstractSeed
{
    public function getDependencies(): array
    {
        return ['TransportadorasSeeder'];
    }

    public function run(): void
    {
        $this->table('contatos_transportadora')->insert([
            [
                'id_transportadora' => 1,
                'nome'     => 'Ana Lima',
                'email'    => 'ana.lima@transportesrapido.com.br',
                'telefone' => '(11) 99001-1111',
                'cargo'    => 'Comercial',
            ],
            [
                'id_transportadora' => 1,
                'nome'     => 'Bruno Ferreira',
                'email'    => 'bruno.ferreira@transportesrapido.com.br',
                'telefone' => '(11) 99001-2222',
                'cargo'    => 'Operacional',
            ],
            [
                'id_transportadora' => 2,
                'nome'     => 'Carla Mendes',
                'email'    => 'carla.mendes@cargasdosul.com.br',
                'telefone' => '(41) 99002-3333',
                'cargo'    => 'Financeiro',
            ],
            [
                'id_transportadora' => 3,
                'nome'     => 'Diego Santos',
                'email'    => 'diego.santos@logisticanorte.com.br',
                'telefone' => null,
                'cargo'    => 'Operacional',
            ],
        ])->saveData();
    }
}
