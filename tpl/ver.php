<?php
//Pega o nome da categoria, e faz a leitura.
$nomePos = $url[1];

$readPost = new read();
$readPost->ExeRead('posts', "WHERE nome = :nome", "nome={$nomePos}");
$resul = $readPost->getResultado()[0];
//Cria uma sessao com id da categoria para ser pego no case 
$_SESSION['postid']['id'] = $resul['id'];

if (!$resul):
    header('Location: ' . BASE . '/404');
else:
    if (!$resul['status'] && !$_SESSION['postid']['id']):;
        header('Location: ' . BASE . '/404');
    else:
        extract($resul);
       
    endif;
endif;
?>
</head>

<!--body -->
<body>

    <?php
    setArq('tpl/sidebars/modais');
    setArq('tpl/sidebars/pgheader');
    ?> 

    <div class="commentbox">
        <h3>Deixe seu comentário:</h3>
        <form name="addcomment" action="" method="post">
            <label>
                <span class="field">Nome:</span>
                <input type="text" name="nome">
            </label>
            <label>
                <span class="field">E-mail:</span>
                <input type="text" name="email">
            </label>
            <label>
                <span class="field">Diga:</span>
                <textarea name="comentario" rows="3"></textarea>
            </label>
            <input type="submit" value="Enviar Comentário" class="btn">
            <img class="imgload" src="<?php setHome(); ?>/tpl/images/loader2.gif" alt="Carregando..." title="Carregando...">
            <a href="#closecomment" class="closecomment" title="Fechar">X Fechar</a>
        </form>
    </div><!-- /commentbox -->

    <!-- BLOCO SITE GERAL HOME -->
    <div id="site">
        <div class="home single">

            <ul class="sidebar">

                <li>
                    <h3>COMPARTILHE:</h3>
                    <div class="content">           
                        <ul class="social">
                            <li class="radius">
                                <div class="fb-like" 
                                     data-href="<?= BASE . '/ver/' . $nome ?>" 
                                     data-send="false" 
                                     data-layout="box_count"
                                     data-show-faces="true">
                                </div>
                            </li>

                            <li class="radius">
                                <a href="http://twitter.com/share" 
                                   class="twitter-share-button" 
                                   data-url="<?= BASE . '/ver/' . $nome ?>" 
                                   data-count="vertical" 
                                   data-via="Conectese">Tweet</a>
                            </li>

                            <li class="radius">
                            <g:plusone size="tall" href="<?= BASE . '/ver/' . $nome ?>"></g:plusone>
                            </li>
                        </ul><!-- /redes -->   
                    </div><!-- /content -->
                </li>
                <li>
                    <h3>RELACIONADOS:</h3>
                    <div class="content">
                        <ul class="related">
                            <?php 
                            $readRelacionados = clone $readPost;
                            $readRelacionados->ExeRead('posts',"WHERE sub_categoria = :sub","sub={$sub_categoria}");
                         
                            foreach ($readRelacionados->getResultado() as $resRela):                 
                            ?>
                                <li <?php if ($i % 2 == 0) echo 'style="float:right;"'; ?>>
                                    <img src="<?= BASE.'/tim.php?src=../uploads/'.$resRela['capa'].'&w=240&h=80&a=t'?>"/>
                                    <a href="<?= BASE.'/ver/'.$resRela['nome']?>"><?= funcoes::limtarTextos($resRela['titulo'], 25); ?></a>
                                    <p><?= funcoes::limtarTextos($resRela['conteudo'], 100); ?></p>s
                                </li>
                            <?php 
                                endforeach;
                            ?>
                        </ul><!--/related -->
                    </div><!-- /content -->
                </li>
                <li>
                    <h3>FACEBOOK:</h3>
                    <div class="content" style="padding-bottom:30px;">
                        <div style="height:373px; width:232px; margin:0 4px; padding-bottom:6px; overflow:hidden;" class="fb-like-box" data-href="http://www.facebook.com/upinside" data-width="234" data-height="388" data-show-faces="true" data-border-color="white" data-stream="false" data-header="false"></div>            
                    </div><!-- /content -->
                </li>

            </ul><!-- /sidebar -->

            <div class="artigo">

                <h1><?= funcoes::limtarTextos($titulo, 80) ?></h1>
                <?php
                if($video):
                   $video = strchr($video,'=');
                   $nvideo = str_replace('=','',$video);
                   echo'<iframe width="700" height="394" src="https://www.youtube.com.br/embed/'.$nvideo.'" frameborder="0" allowfullscreen></iframe>';
                else:
                    echo '<img src="'.BASE. '/tim.php?src=uploads/' . $capa . '&w=' . IMAGEW.'">';
                endif;
                ?>
                <div class="content">
                    
                     <?= $conteudo ?>
                    
                    <ul class="gallery">
                        <?php
                        $readGal = clone $readPost;
                        $readGal->ExeRead('imagens',"WHERE id_post = :id","id={$id}");
                        if(!$readGal->getResultado()):
                            else:
                                foreach ($readGal->getResultado() as $resG):
                       
                                $i++;
                                if ($i % 5 == 0): $w = '300';
                                $h = '320';
                                else: $w = '150';
                                    $h = '150';
                                endif;
                                if ($i % 10 == 0): 
                                    $class = '';
                                else:
                                    $class = 'right';
                                endif;

                            echo '<li class="' . $class . '"><a href="' . BASE . '/uploads/'.$resG['imagem'].'" rel="shadowbox['.$resG['id'].']" title="'.$resG['titulo'].'"><img src="' . BASE . '/tim.php?src=../uploads/'.$resG['imagem'].'&w=' . $w . '&h=' . $h . '" alt="" title="'.$resG['titulo'].'"></a></li>';

                                endforeach;
                            endif;
                        ?>       	
                    </ul><!--/gallery-->
                    <div class="clear"></div><!-- /clear -->


                </div><!-- /content -->

                <div class="comments">
                    <h3>Comente isso!   <a class="radius opencomment" href="#comment">Comentar</a></h3>
                    <ul class="commentlist">
                            <?php for ($i = 1; $i <= 2; $i++): ?>
                            <li class="li">
                                <div class="user">
                                    <img class="radius" src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=60&d=monsterid&r=G" title="">
                                    <div class="info"><strong>por</strong> <span>ROBSON VIDALETTI LEITE</span> <strong>em</strong> <span>27/04/2013</span></div><!-- info -->
                                </div><!--/user -->
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc scelerisque est in nunc tristique in varius enim ultricies.</p>
                                <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.  Vivamus pretium congue sapien, eget sodales nibh faucibus at. Sed viverra malesuada volutpat. Suspendisse potenti. Aliquam accumsan auctor urna et facilisis. Etiam consectetur purus in sapien condimentum sit amet fringilla elit ultricies.</p>
                            </li><!--/li-->
                            <?php endfor; ?>


                        <li class="li">
                            <div class="user">
                                <img class="radius" src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=60&d=monsterid&r=G" title="">
                                <div class="info"><strong>por</strong> <span>ROBSON VIDALETTI LEITE</span> <strong>em</strong> <span>27/04/2013</span></div><!-- info -->
                            </div><!--/user -->
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc scelerisque est in nunc tristique in varius enim ultricies.</p>
                            <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.  Vivamus pretium congue sapien, eget sodales nibh faucibus at. Sed viverra malesuada volutpat. Suspendisse potenti. Aliquam accumsan auctor urna et facilisis. Etiam consectetur purus in sapien condimentum sit amet fringilla elit ultricies.</p>
                            <div class="resposta">
                                <div class="user">
                                    <img class="radius" src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=40&d=monsterid&r=G" title="">
                                    <div class="info"><strong>resposta de</strong> <span>ROBSON VIDALETTI LEITE</span> <strong>em</strong> <span>27/04/2013</span></div><!-- info -->
                                </div><!--/user -->
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc scelerisque est in nunc tristique in varius enim ultricies.</p>
                                <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.  Vivamus pretium congue sapien, eget sodales nibh faucibus at. Sed viverra malesuada volutpat. Suspendisse potenti. Aliquam accumsan auctor urna et facilisis. Etiam consectetur purus in sapien condimentum sit amet fringilla elit ultricies.</p>
                            </div><!--/resposta-->
                        </li><!--/li-->


                            <?php for ($i = 1; $i <= 2; $i++): ?>
                            <li class="li">
                                <div class="user">
                                    <img class="radius" src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=60&d=monsterid&r=G" title="">
                                    <div class="info"><strong>por</strong> <span>ROBSON VIDALETTI LEITE</span> <strong>em</strong> <span>27/04/2013</span></div><!-- info -->
                                </div><!--/user -->
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc scelerisque est in nunc tristique in varius enim ultricies.</p>
                                <p>In quis odio sit amet lectus porta blandit non at ante. Nam lobortis tempus odio, faucibus venenatis lorem consequat eget.  Vivamus pretium congue sapien, eget sodales nibh faucibus at. Sed viverra malesuada volutpat. Suspendisse potenti. Aliquam accumsan auctor urna et facilisis. Etiam consectetur purus in sapien condimentum sit amet fringilla elit ultricies.</p>
                            </li><!--/li-->
                            <?php endfor; ?>
                    </ul><!--/commentlist-->
                </div><!--/comments-->

            </div><!-- /artigo -->
            <div class="clear"></div><!-- /clear -->


        </div><!-- /HOME GERAL -->  
    </div><!-- #SITE -->   

    <!-- FOOTER -->    
    <div class="footer">
        <div class="content">
<?php setArq('tpl/sidebars/pgmenu'); ?>                       
        </div><!-- /content -->
    </div><!-- /#FOOTER -->

    <script type="text/javascript" src="<?php setHome(); ?>/tpl/js/facebook.js"></script>
    <script type="text/javascript" src="<?php setHome(); ?>/tpl/js/twitter.js"></script>
    <script type="text/javascript" src="https://apis.google.com/js/plusone.js">{
            lang: 'pt-BR'
        }</script>