<?php

use Phinx\Migration\AbstractMigration;

class CreateContatosTransportadora extends AbstractMigration
{
    public function up(): void
    {
        $this->execute("
            CREATE TABLE contatos_transportadora (
                id                INT UNSIGNED  AUTO_INCREMENT PRIMARY KEY,
                id_transportadora INT UNSIGNED  NOT NULL,
                nome              VARCHAR(100)  NOT NULL,
                email             VARCHAR(150)  NOT NULL,
                telefone          VARCHAR(20)            DEFAULT NULL,
                cargo             VARCHAR(80)            DEFAULT NULL,
                created_at        DATETIME      NOT NULL DEFAULT CURRENT_TIMESTAMP,
                KEY idx_contatos_transportadora (id_transportadora),
                CONSTRAINT fk_contatos_transportadora
                    FOREIGN KEY (id_transportadora) REFERENCES transportadoras (id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
        ");
    }

    public function down(): void
    {
        $this->execute('DROP TABLE IF EXISTS contatos_transportadora');
    }
}
