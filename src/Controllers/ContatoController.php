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

        $stmt = $db->prepare('SELECT * FROM contatos_transportadora WHERE id_transportadora = ? ORDER BY nome ASC');
        $stmt->execute([$params['id']]);
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

    public static function add(array $params): void
    {
        $body = body();

        $db = Database::connection();

        $stmt = $db->prepare('SELECT * FROM transportadoras WHERE id = ? AND deleted_at IS NULL');
        $stmt->execute([$params['id']]);
        if (!$stmt->fetch()) {
            json(['erro' => 'Transportadora não encontrada'], 404);
        }

        $erros = [];
        
        if (empty($body['nome'])) {
            $erros['nome_inexistente'] = 'Nome é obrigatório';
        }
        if (empty($body['email'])) {
            $erros['email_inexistente'] = 'Email é obrigatório';
        }
        if(!str_contains($body['email'], '@')) {
            $erros['email_invalido'] = 'Email inválido';
        }

        if (!empty($erros)) {
            json([
                'erros' => $erros
            ], 400);
        }

        $sql = "
            INSERT INTO contatos_transportadora 
            (id_transportadora, nome, email, telefone, cargo) 
            VALUES
            (:id_transportadora, :nome, :email, :telefone, :cargo)
        ";

        $data = [
            'id_transportadora' => $params['id'],
            'nome' => $body['nome'],
            'email' => $body['email'],
            'telefone' => $body['telefone'] ?? null,
            'cargo' => $body['cargo'] ?? null
        ];

        $stmt = $db->prepare($sql);

        try {
            $stmt->execute($data);
            $data['id'] = (int) $db->lastInsertId();
            json(self::format($data), 201);
        } catch (PDOException $e) {
            json([
                'erro' => 'Erro ao criar contato'
            ], 500);
        }
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
