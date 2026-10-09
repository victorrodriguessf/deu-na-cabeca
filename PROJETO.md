# Deu na Cabeça — resultados PT Rio via widgets

Aplicação Laravel 12 / PHP 8.2, Blade, CSS próprio e JavaScript sem build npm. Usa a logo original fornecida em `logo.png`, paleta verde, amarela e laranja, tipografia sem serifa e tabela interativa dos 25 bichos.

## Fonte e formato

[Documentação do widget gratuito](https://www.eojogodobicho.com/widget.html). Os endereços estão em `config/bicho.php`:

```text
https://www.eojogodobicho.com/widget/rio?format=table&theme=light&accent=005629
https://www.eojogodobicho.com/widget/rio?theme=light&accent=005629
```

O primeiro formato exibe os prêmios da extração indicada pelo fornecedor. O segundo apresenta o primeiro prêmio de cada extração publicada para o Rio. A aplicação não escolhe a extração dentro do widget nem promete que a tabela detalhada seja a mais recente. Nos testes de 09/10/2026, a tabela mostrava PPT e o resumo incluía PT, PTM e PPT, todos com a data visível.

O fornecedor anuncia atualização a cada minuto e uso gratuito sem conta ou chave, exigindo a manutenção do crédito da fonte. A atribuição original permanece dentro dos widgets e também há um link visível em cada cartão. Se o próximo sorteio ainda não foi publicado, o fornecedor pode manter a última extração disponível.

A apresentação dos números, a quantidade de posições, os nomes, o horário e a formatação são controlados pelo fornecedor. Não há acesso do código da aplicação ao conteúdo interno dos iframes, por serem de outro domínio. Não há API JSON própria de resultados, consultas do backend, números de demonstração, cache de resultados ou agendamento de sincronização nesta versão.

## Incorporação e interface

Os dois iframes carregam diretamente do domínio da fonte. Consultas diretas por curl podem receber HTTP 403, pois o fornecedor diferencia navegação comum de incorporação em iframe; a validação deve ser feita em um navegador com a página incorporadora aberta. Não é usado proxy nem simulação de cabeçalhos para contornar essa restrição.

O JavaScript escuta as mensagens `ejbWidget` de altura. Valida a origem, a janela exata do iframe, a banca `rio` e um número finito dentro de limites antes de ajustar a altura. Não adiciona margem ao valor: o fornecedor mede `scrollHeight`, que já inclui a altura do viewport, e acrescentar margem geraria crescimento a cada aviso. O botão de recarregar preserva as URLs documentadas.

O formato detalhado e o resumo ficam lado a lado em desktop e empilhados em celular. A página mantém um link direto para os resultados caso a fonte externa ou um bloqueador impeça o carregamento. A busca e os favoritos atuam somente na tabela local dos bichos. Filtros de datas e extrações da integração anterior foram retirados por não serem oferecidos pelo widget.

## Verificação

4 testes PHP passaram, com 16 assertions, incluindo incorporação dos dois widgets, créditos, ausência de consultas externas do Laravel, retirada da rota `/api/resultados` e ausência de tarefas de sincronização. Blade compila e o JavaScript passa pela verificação de sintaxe.

Os dois widgets reais foram abertos no Edge em desktop e celular. Verificados: data, Rio de Janeiro, atribuição, recarregamento, busca por bicho, favoritos, diálogo, recusa de mensagem de origem diferente e ausência de rolagem horizontal. Capturas e script de inspeção ficam em `.qa/`, ignorado pelo Git.

Os cinco primeiros prêmios da PPT de 09/10/2026 exibidos no widget coincidiram com os publicados em [Deu no Poste RJ](https://deunoposterj.com/) e [Sorte Sim](https://sortesim.com.br/jogo-do-bicho-de-hoje-atualizado/). Isso verifica aquela extração consultada; não constitui auditoria contínua de todos os resultados. A precisão e o prazo de publicação dependem da fonte externa.

## Executar e publicar

Use o iniciador descrito no [README](README.md) ou `php artisan serve`. O agendador anterior deixou de ser necessário. Não editar dependências em `vendor/`.

Para produção, hospede em PHP/Laravel servindo exclusivamente `public/`, use HTTPS e `APP_DEBUG=false`. Se a hospedagem configurar uma Content-Security-Policy, permita `https://www.eojogodobicho.com` em `frame-src`. O navegador de cada visitante precisa acessar esse domínio.
