# BUGFIX.md

**Data da correção:** <!-- 27/05/2026 -->
**Corrigido por:** <!-- Felipe Kowalewski -->

---

## O que era o bug

<!-- O problema do código, que gerava o bug nos contatos das transportadoras, era na query feita no método 'index' da classe 'ContatoController' do arquivo '../src/Controllers/ContatoController.php' para consulta do banco de dados. A query não possuía um filtro pela id da transportadora. Na verdade a query não possuía nenhum filtro, apenas retornava todos os contatos das transportadoras ativas da tabela contatos_transportadora. -->

---

## Resposta para a Camila

<!-- O sistema não estava levando em consideração a transportadora que estava sendo acessada na hora de filtrar a busca dos contatos. Após correção, o sistema agora está filtrando por transportadora. -->

---

## Como reproduzir (antes da correção)

1. Após instalação das dependências, configuração do ambiente e subir o servidor, acessar o endpoint das transportadoras a fim de verificar quais estão ativas;
2. Após verificação, pegar o 'id' de duas transportadoras e inseri-los no endereço do endpoint de contatos das transportadoras e comparar os resultados. Exemplo: [localhost](http://localhost:8000/transportadoras/1/contatos/) e comparar com http://localhost:8000/transportadoras/2/contatos/;
3. Após comparação será verificado que os contatos retornados em cada uma das páginas são os mesmos.

## Como verificar que está corrigido

1. Pegar o 'id' de duas transportadoras ativas no endpoint de listagem de transportadoras;
2. Comparar o endpoint de listagem de contatos de cada transportadora e verificar que agora estão diferentes.
