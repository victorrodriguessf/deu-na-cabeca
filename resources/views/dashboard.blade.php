<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#005629">
    <meta name="description" content="Resultados do jogo do bicho do Rio de Janeiro, com quadros atualizados pelo eojogodobicho.com e uma tabela dos 25 bichos.">
    <title>Deu na Cabeça — resultados do PT Rio</title>
    <link rel="icon" href="{{ asset('images/crown.svg') }}" type="image/svg+xml">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}?v={{ filemtime(public_path('css/app.css')) }}">
    <script>window.Bicho = {{ Illuminate\Support\Js::from(['animals' => $animals]) }};</script>
    <script src="{{ asset('js/app.js') }}?v={{ filemtime(public_path('js/app.js')) }}" defer></script>
</head>
<body>
<a class="skip" href="#resultados">Pular para os resultados</a>
<header class="site-header wrap">
    <a class="brand" href="/" aria-label="Deu na Cabeça, início">@if($logo)<img class="brand-logo" src="{{ asset($logo) }}" alt="" width="76" height="76">@else<img class="brand-symbol" src="{{ asset('images/crown.svg') }}" alt="" width="38" height="38">@endif<span class="brand-name"><span>DEU NA</span><strong>CABEÇA</strong></span></a>
    <nav aria-label="Menu principal"><a class="nav-active" href="#resultados">Resultados</a><a href="#bichos">Os 25 bichos</a><a href="#sobre">Como funciona</a></nav>
    <a class="header-link" href="#bichos" id="favorite-link">♡ <span>Meus bichos</span></a>
</header>
<main>
    <section class="hero wrap brand-hero" aria-labelledby="hero-title">
        <div class="hero-copy">
            <span class="eyebrow"><span class="small-star">✳</span> RESULTADOS DO PT RIO</span>
            <h1 id="hero-title">Deu no poste.<br><em>Deu na cabeça.</em></h1>
            <p>Acompanhe os resultados do Rio de Janeiro.<br>Os números na tela. Todos os bichos por perto.</p>
            <a class="button button-orange" href="#resultados">Conferir resultados <span aria-hidden="true">↗</span></a>
            <div class="hero-note"><span class="mini-paw" aria-hidden="true">✳</span> Sua consulta de resultados, com a cara do Brasil.</div>
        </div>
        <div class="hero-brand-panel">
            @if($logo)
                <img class="hero-logo" src="{{ asset($logo) }}" alt="Logo Deu na Cabeça com leão, elefante, arara, tucano, onça e paisagem tropical do Rio de Janeiro" width="1254" height="1254" fetchpriority="high">
            @else
                <div class="hero-wordmark" aria-label="Deu na Cabeça"><img src="{{ asset('images/crown.svg') }}" alt="" width="90" height="90"><span>DEU NA</span><strong>CABEÇA</strong></div>
            @endif
        </div>
    </section>
    <div class="ticker" aria-hidden="true"><div>✳ DEU NA CABEÇA &nbsp; · &nbsp; RESULTADOS DO PT RIO &nbsp; · &nbsp; OS 25 BICHOS &nbsp; · &nbsp; ✳ DEU NA CABEÇA &nbsp; · &nbsp; RESULTADOS DO PT RIO &nbsp; · &nbsp; OS 25 BICHOS</div></div>
    <section class="results-section wrap" id="resultados" aria-labelledby="results-title">
        <div class="section-top"><div><span class="eyebrow section-eyebrow">OLHO NOS NÚMEROS</span><h2 id="results-title">O Rio em resultados<span class="orange">.</span></h2></div><span class="region-badge">PT RIO · RJ</span></div>
        <div class="widget-toolbar"><p>Os quadros consultam o fornecedor a cada minuto. Confira a data da extração dentro de cada quadro.</p><button class="refresh-button" id="reload-widgets" type="button" hidden><span aria-hidden="true">↻</span> Recarregar quadros</button></div>
        <div class="widget-grid">
            <article class="widget-card"><div class="widget-heading"><span class="widget-kicker">PRÊMIO POR PRÊMIO</span><h3>Quadro detalhado</h3><p>Milhares, grupos e bichos da extração indicada no quadro.</p></div><iframe class="results-widget" id="widget-latest" src="{{ $widget['table_url'] }}" width="100%" height="420" title="Prêmios da extração indicada do jogo do bicho do Rio de Janeiro" referrerpolicy="strict-origin-when-cross-origin"></iframe><p class="widget-credit">Fonte: <a href="{{ $widget['source_url'] }}" target="_blank" rel="noopener noreferrer">eojogodobicho.com</a></p></article>
            <article class="widget-card"><div class="widget-heading"><span class="widget-kicker">UM OLHAR SOBRE O DIA</span><h3>Extrações publicadas</h3><p>O primeiro prêmio de cada extração disponível na fonte.</p></div><iframe class="results-widget" id="widget-day" src="{{ $widget['day_url'] }}" width="100%" height="240" title="Resumo das extrações do jogo do bicho do Rio de Janeiro" referrerpolicy="strict-origin-when-cross-origin"></iframe><p class="widget-credit">Fonte: <a href="{{ $widget['source_url'] }}" target="_blank" rel="noopener noreferrer">eojogodobicho.com</a></p></article>
        </div>
        <p class="widget-help">Se os quadros não aparecerem, <a href="{{ $widget['source_url'] }}" target="_blank" rel="noopener noreferrer">abra os resultados diretamente na fonte ↗</a>. Enquanto uma nova extração não for publicada, o quadro pode mostrar a última disponível.</p>
        <noscript><p>Os quadros acima são incorporados diretamente. Para consultar com o JavaScript desativado, <a href="{{ $widget['source_url'] }}">abra o site da fonte</a>.</p></noscript>
    </section>
    <section class="animals-section" id="bichos" aria-labelledby="animals-title"><div class="wrap">
        <div class="section-top"><div><span class="eyebrow section-eyebrow">UM PEQUENO BESTIÁRIO BRASILEIRO</span><h2 id="animals-title">Cada bicho tem seu número.</h2><p>Conheça os 25 grupos e encontre suas dezenas.</p></div><span class="animals-mark" aria-hidden="true">✳</span></div>
        <div class="animal-tools"><label class="search"><span aria-hidden="true">⌕</span><span class="sr-only">Buscar na tabela de bichos</span><input id="animal-search" type="search" placeholder="Qual bicho você procura?"></label><button id="favorites-only" aria-pressed="false" type="button">♡ Meus favoritos</button></div>
        <div class="animal-grid" id="animal-grid"></div>
        <p id="animal-empty" class="empty" hidden>Nenhum bicho encontrado. Experimente outra busca ou marque seus favoritos.</p>
    </div></section>
    <section class="about wrap" id="sobre"><span class="about-icon" aria-hidden="true">↗</span><div><span class="eyebrow section-eyebrow">CLAREZA EM PRIMEIRO LUGAR</span><h2>Informação, sem complicação.</h2><p>Os quadros mostram os resultados do Rio de Janeiro publicados pelo <a href="{{ $widget['source_url'] }}" target="_blank" rel="noopener noreferrer">eojogodobicho.com</a>. A data e a extração aparecem no próprio quadro. Novos números entram conforme a publicação da fonte.</p><p>Na nossa tabela, cada grupo reúne quatro dezenas — de 01 a 00. Toque no coração para guardar seus bichos neste navegador e consulte os detalhes de cada grupo.</p></div></section>
</main>
<footer class="wrap"><a class="brand footer-brand" href="/" aria-label="Deu na Cabeça, início"><img src="{{ asset('images/crown.svg') }}" alt="" width="32" height="32"><span class="brand-name"><span>DEU NA</span><strong>CABEÇA</strong></span></a><span>Os resultados do Rio, com a cara do Brasil.</span><span>Portal de consulta · {{ now()->year }}</span></footer>
<dialog id="animal-dialog" aria-label="Detalhes do bicho"><button id="close-dialog" class="dialog-close" aria-label="Fechar detalhes" type="button">×</button><div id="dialog-content"></div></dialog>
</body>
</html>
