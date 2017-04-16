<div class="content home">
    <h1 class="location">Painel Home <span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->
    <?php
    //SOMA AS ESTATISITCAS
    $usuarios = funcoes::somaTrafico('usuarios','siteviews');
    $visitas = funcoes::somaTrafico('visitas','siteviews');
    $paginas = funcoes::somaTrafico('pageviews','siteviews');
    $pageMedia = ($paginas / $usuarios);
    
    $posts = new read();
    $comentarios = clone($posts);
    $categorias = clone($posts);
    
    $posts->ExeRead('posts');
    $comentarios->ExeRead('comentarios');
    $categorias->ExeRead('categorias');
    
    $post = $posts->getResultado();
    $coments = $comentarios->getResultado();
    $cat = $categorias->getResultado();
    ?>
    <div class="left">

        <div class="boxleft estatisticas">
            <h3>Estatísticas totais:</h3>
            <div class="content">

                <ul class="views">
                    <li class="visitas"><?=$visitas?><small>visitas</small></li><!--/visitas-->
                    <li class="users"><?=$usuarios?><small>usuários</small></li><!--/visitantes-->
                    <li class="media right"><?= ceil($pageMedia)?><small>pageviews</small></li><!--/pageviews-->
                </ul><!--/views-->

                <ul class="conteudo">
                    <li class="topic"><?= count($posts);?><small>posts</small></li><!--/artigos-->
                    <li class="comment"><?= count($coments)?><small>comentários</small></li><!--/comentários-->
                    <li class="cats"><?= count($cat)?><small>categorias</small></li><!--/categorias-->
                </ul><!--/views-->

            </div><!--/content-->
        </div><!--/estatisticas-->


        <div class="boxleft trafego">
            <h3>Tráfego por mês: <a href="#" class="j_abrirelatorio">Tráfego</a></h3>
            <div class="content">
                <ul class="relatorio">
                    <li class="title">
                        <span class="date">Mês/Ano</span>
                        <span class="views">Visitas</span>
                        <span class="users">Usuários</span>
                        <span class="pages">PageViews</span>
                    </li>
                    <?php for ($i = 1; $i <= 6; $i++): ?>
                        <li<?php if ($i % 2 == 0) echo ' class="color"'; ?>>
                            <span class="date"><strong>04/2013</strong></span>
                            <span class="views">1890</span>
                            <span class="users">1190</span>
                            <span class="pages">2.8</span>
                        </li>
                    <?php endfor; ?>
                </ul><!--/relatorio-->
            </div><!--/content-->
        </div><!--/estatisticas-->

    </div><!--/left-->


    <div class="comments boxleft">
        <h3>Comentários: <a title="Comentários" href="dashboard.php?exe=comentarios/home">MODERAR</a></h3>
        <div class="content">
            <ul class="comentarios">
                <?php for ($i = 1; $i <= 3; $i++): ?>
                    <li class="pendente">
                        <img src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=60&d=monsterid&r=G" />
                        <div class="commentitem">
                            <span>De <strong>Robson V. Leite</strong> sobre <strong>Shael Sonnen e Anderson Silva Spider...</strong>.</span>	
                            <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.</p>
                        </div><!--/commentitem-->
                    </li>
                <?php endfor; ?>
                <?php for ($i = 1; $i <= 2; $i++): ?>
                    <li>
                        <img src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=60&d=monsterid&r=G" />
                        <div class="commentitem">
                            <span>De <strong>Robson V. Leite</strong> sobre <strong>Shael Sonnen e Anderson Silva Spider...</strong>.</span>	
                            <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.</p>
                        </div><!--/commentitem-->
                    </li>
                <?php endfor; ?>
            </ul><!--/comentários-->
        </div><!--/content-->
    </div><!--/ comments -->

    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->