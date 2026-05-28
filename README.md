# Teste Técnico — Estágio em Desenvolvimento PHP

## Ambiente
O ambiente utilizado foi o laragon, que fornece o servidor, o php e o mysql, assim como as extensões pdomysql e curl.

## Versões
PHP 8.4.21
MySQL 8.4.3
Composer 2.9.8
CakePHP 5.3.4
Phinx 0.16.11

---

## Como rodar

```bash
# 1. Configure o ambiente
cp .env.example .env
# Edite .env com as credenciais do seu banco MySQL

# 2. Instale as dependências
composer install

# 3. Crie o banco de dados com o nome brudam_test
CREATE DATABASE brudam_test;

# 4. Crie as tabelas
vendor/bin/phinx migrate

# 5. Popule os dados iniciais
vendor/bin/phinx seed:run

# 6. Suba o servidor
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
**Exemplos:**
- localhost:8000/transportadoras/1 -> para ver os dados da transportadora com o id=1
- localhost:8000/transportadoras/2 -> para ver os dados da transportadora com o id=2
- localhost:8000/transportadoras/1/contatos -> para ver os dados dos contatos da transportadora com o id=1
- localhost:8000/transportadoras/2/contatos -> para ver os dados dos contatos da transportadora com o id=2

**Dados disponíveis após o seed:**
- 3 transportadoras (2 ativas, 1 inativa)
- 4 contatos distribuídos entre elas

---

## Tarefa 1 — Corrigir o bug
Leia o arquivo BUG_REPORT.md, reproduza o problema, corrija e preencha o BUGFIX.md.

## Tarefa 2 — Novo endpoint
O time precisa conseguir cadastrar novos contatos para uma transportadora.

**Body esperado:**

{
  "nome": "João Costa",
  "email": "joao.costa@exemplo.com.br",
  "telefone": "(11) 99999-0000",
  "cargo": "Comercial"
}

**Regras:**

nome e email são obrigatórios
telefone e cargo são opcionais
O email deve conter @
A transportadora deve existir (e estar ativa)
Retornar o contato criado com status 201

---

## Deciões técnicas
Me deparei com situações onde teria que tomar decisões na **tarefa 2**.

Na construção da query de inserção de dados do novo contato, decidi por utilizar a iserção das variáveis por parâmetro,
fazendo uso de ':nomedoatributo' com auxílio de um array com as chaves sendo nomeados com os mesmos nomes dos atributos da tabela.
Assim, caso fossem enviados dados adicionais, além daqueles que a tabela guarda, eles não interfeririam. Assim como, caso fossem enviados fora de ordem, também não causariam problemas. Também optei por, caso o usuário não enviasse os atributos 'telefone' e 'cargo', envia-los como null.

Na hora de executar a consulta, diferente de como estava sendo feito nos outros métodos, optei por lidar com possíveis erros utilizando da ferramenta 'try - catch', pois caso houvesse um erro na inserção dos dados ou na integridade do banco, o programa não interromperia o seu funcionamento.
