<?php

namespace App\Controllers;

use App\Database;

class ContatoController
{
    public static function index(array $params): void
    {
        $db = Database::connection();

        $stmt = $db->prepare('SELECT * FROM transportadoras WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$params['id']]);
        if (!$stmt->fetch()) {
            json(['erro' => 'Transportadora não encontrada'], 404);
        }

        $stmt = $db->query('SELECT * FROM contatos_transportadora ORDER BY nome ASC');
        $rows = $stmt->fetchAll();

        json(array_map([self::class, 'format'], $rows));
    }

    public static function show(array $params): void
    {
        $db = Database::connection();

        $stmt = $db->prepare('SELECT * FROM transportadoras WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$params['id']]);
        if (!$stmt->fetch()) {
            json(['erro' => 'Transportadora não encontrada'], 404);
        }

        $stmt = $db->prepare('SELECT * FROM contatos_transportadora WHERE id = ? AND id_transportadora = ?');
        $stmt->execute([$params['cid'], $params['id']]);
        $row = $stmt->fetch();

        if (!$row) {
            json(['erro' => 'Contato não encontrado'], 404);
        }

        json(self::format($row));
    }

    private static function format(array $row): array
    {
        return [
            'id'       => (int) $row['id'],
            'nome'     => $row['nome'],
            'email'    => $row['email'],
            'telefone' => $row['telefone'],
            'cargo'    => $row['cargo'],
        ];
    }
}
