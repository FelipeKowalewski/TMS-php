<?php

namespace App\Controllers;

use App\Database;

class TransportadoraController
{
    public static function index(array $params): void
    {
        $db   = Database::connection();
        $rows = $db->query('SELECT * FROM transportadoras WHERE deleted_at IS NULL ORDER BY nome_fantasia ASC')->fetchAll();

        json(array_map([self::class, 'format'], $rows));
    }

    public static function show(array $params): void
    {
        $db   = Database::connection();
        $stmt = $db->prepare('SELECT * FROM transportadoras WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$params['id']]);
        $row = $stmt->fetch();

        if (!$row) {
            json(['erro' => 'Transportadora não encontrada'], 404);
        }

        json(self::format($row));
    }

    private static function format(array $row): array
    {
        return [
            'id'            => (int) $row['id'],
            'cnpj'          => $row['cnpj'],
            'nome_fantasia'  => $row['nome_fantasia'],
            'created_at'    => $row['created_at'],
        ];
    }
}
