# Teste Técnico — Estágio em Desenvolvimento PHP

## Contexto

Você está iniciando seu estágio em uma empresa de **TMS (Transportation Management System)** — um sistema que gerencia o transporte de cargas.

No seu primeiro dia, o time te passou duas tarefas: um bug reportado pelo time de operações e um novo endpoint para implementar.

---

## Prazo

**5 dias corridos** a partir do recebimento deste desafio.

---

## Stack

PHP 8.1+ · PDO · MySQL 8+ · [Phinx](https://phinx.org) (migrations e seeds)

---

## Como rodar

```bash
# 1. Configure o ambiente
cp .env.example .env
# Edite .env com as credenciais do seu banco MySQL

# 2. Instale as dependências
composer install

# 3. Crie as tabelas
vendor/bin/phinx migrate

# 4. Popule os dados iniciais
vendor/bin/phinx seed:run

# 5. Suba o servidor
php -S localhost:8000 public/index.php
```

---

## Sistema atual

O sistema gerencia transportadoras e seus contatos (responsáveis de cada empresa).

**Endpoints disponíveis:**

```
GET /transportadoras                         → lista transportadoras ativas
GET /transportadoras/{id}                    → detalhe de uma transportadora
GET /transportadoras/{id}/contatos           → lista contatos da transportadora
GET /transportadoras/{id}/contatos/{cid}     → detalhe de um contato
```

**Dados disponíveis após o seed:**
- 3 transportadoras (2 ativas, 1 inativa)
- 4 contatos distribuídos entre elas

---

## Suas tarefas

### Tarefa 1 — Corrigir o bug

Leia o arquivo [`BUG_REPORT.md`](./BUG_REPORT.md), reproduza o problema, corrija e preencha o [`BUGFIX.md`](./BUGFIX.md).

### Tarefa 2 — Novo endpoint

O time precisa conseguir **cadastrar novos contatos** para uma transportadora.

Implemente:

```
POST /transportadoras/{id}/contatos
```

**Body esperado:**
```json
{
  "nome": "João Costa",
  "email": "joao.costa@exemplo.com.br",
  "telefone": "(11) 99999-0000",
  "cargo": "Comercial"
}
```

**Regras:**
- `nome` e `email` são obrigatórios
- `telefone` e `cargo` são opcionais
- O `email` deve conter `@`
- A transportadora deve existir (e estar ativa)
- Retornar o contato criado com status `201`

---

## Commits esperados

Não entregue tudo em um commit só — queremos ver as etapas:

```
fix:   corrigir listagem de contatos por transportadora
feat:  implementar POST /transportadoras/{id}/contatos
docs:  preencher BUGFIX.md
```

---

## Bônus

- `DELETE /transportadoras/{id}/contatos/{cid}` — remover um contato
- Validar se o e-mail já está cadastrado para a mesma transportadora

---

## Critérios de avaliação

| O que avaliamos | Peso |
|-----------------|------|
| Bug corrigido e funcionando | Alto |
| BUGFIX.md preenchido (técnico + resposta para Camila) | Alto |
| Endpoint POST funcionando com validações | Alto |
| Código organizado e legível | Médio |
| HTTP status codes corretos | Médio |
| Commits separados por etapa | Médio |

---

## Entrega

1. Suba em repositório **público** no GitHub (sem BRUDAM no nome)
2. README do seu projeto com: como rodar, exemplos de requisição, decisões técnicas
3. Envie ao recrutador: nome completo · link do repo · LinkedIn

---

## Dúvidas

Se algo estiver ambíguo, documente sua interpretação e siga. Decisão sob incerteza também é avaliada.
