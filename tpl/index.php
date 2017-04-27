<script type="text/javascript" src="<?php setHome();?>/tpl/js/jshome.js"></script>

</head>

<!--body -->
<body>
    <div class="dialog"></div><!--Mensagens.-->
    <div class="body"></div><!--Efeitos.-->
<?php 
    setArq('tpl/sidebars/slider');
    setArq('tpl/sidebars/header');	
    $read = new read();
?> 
  
<!-- BLOCO SITE GERAL HOME -->
<div id="site">
<div class="home">
    
<!-- BLOCO UM - h1. h2. Img Topo -->
<div class="bloco_um">
    <h1><?=SITENAME?></h1>
    <h2><?= SITEDESC?></h2>
    <?php
    $read->ExeRead('posts',"WHERE status = 1 ORDER BY visitas DESC LIMIT 1");
    $resViewVisto = $read->getResultado()[0];
    ?>
    <div class="capa">
        <img src="<?php setHome();?>/tim.php?src=uploads/<?=$resViewVisto['capa']?>&w=200&h=200" alt="<?=$resViewVisto['titulo']?>"/>
        <a href="<?= BASE.'/ver/'.$resViewVisto['nome']?>">
            <?= funcoes::limtarTextos($resViewVisto['titulo'],42)?>
            <p><?= funcoes::limtarTextos($resViewVisto['conteudo'],50)?></p>
        </a>
    </div><!-- /capa -->
</div><!-- /BLOCO UM -->


<!-- BLOCO DOIS - Destaques, de olho, feed x 4 -->
<div class="bloco_dois">
    
    <ul class="navbldois">
        <li class="destaq j_destaq">DESTAQUES!</li>
        <li class="deolho j_deolho">DE OLHO!</li>
    </ul>       

    <div class="content"> 
                    
        <ul class="arts">
        <?php 
        //Ler os posts. 
        $readPost = clone $read;
        $readPost->ExeRead('posts',"WHERE status = 1 ORDER BY data_creacao DESC LIMIT 4 OFFSET 4");
        foreach ($readPost->getResultado() as $resPosts):
           $i++;
        ?>
            <li <?php if($i%2==0) echo 'style="float:right;"';?>>
                <img src="<?= BASE.'/tim.php?src=uploads/'.$resPosts['capa']?>&w=100&h=100" alt="<?=$resPosts['titulo']?>"/>
                <a title="<?=$resPosts['titulo']?>" href="<?= BASE.'/ver/'.$resPosts['nome']?>"><?= funcoes::limtarTextos($resPosts['titulo'], 40)?></a>
                <p><?= funcoes::limtarTextos($resPosts['conteudo'], 60)?></p>
            </li>
        <?php
         endforeach;
        ?>
        </ul><!-- /arts -->  
                         
    </div><!-- /content -->                    
</div><!-- /BLOCO DOIS -->


<!-- BLOCO TRES - vídeos -->
<div id="videos" class="bloco_tres">
    <div class="content">
        <h2>Vídeos</h2>
        
        <ul class="videos">
         <?php 
        //Ler a categoria, e pega o id.
        $readCat = clone $read;
        $readCat->ExeRead('categorias',"WHERE nome = :nome","nome=videos");
        $resCatVideos = $readCat->getResultado()[0];
        
        //Ler os posts de acordo com o id categoria 
        $readPosts = clone $read;
        $readPosts->ExeRead('posts',"WHERE sub_categoria = :sub ORDER BY data_creacao DESC LIMIT :limit OFFSET :offset","sub={$resCatVideos['id']}&limit=3&offset=0");
        foreach ($readPosts->getResultado() as $resVideos):
           $i++;
        ?>
            <li<?php if($i%3==0) echo ' style="float:right; margin-right:0"';?>>
                <img src="<?= BASE.'/tim.php?src=uploads/'.$resVideos['capa']?>&w=300&h=150" alt="<?=$resVideos['titulo']?>"/>
                <div class="licontent">
                    <a title="<?=$resVideos['titulo']?>" href="<?= BASE.'/ver/'.$resVideos['nome']?>"><?= funcoes::limtarTextos($resVideos['titulo'],40)?></a>
                    <p><?= funcoes::limtarTextos($resVideos['conteudo'],100)?></p>
                </div><!-- /content -->
            </li>
        <?php endforeach;?>
        <li class="readmore"><a href="<?= BASE.'/categoria/'.$resCatVideos['url']?>" title="Ver <?=$resCatVideos['nome']?>">VEJA +</a></li>
        </ul>
        
    </div><!-- /content -->
</div><!-- /BLOCO TRESs -->


<!-- BLOCO QUATRO - artigos -->
<div id="artigos" class="bloco_quatro">
    <div class="content">
        <h2>Artigos</h2>
        <?php
        //Ler a categoria, e pega o id.
        $readGeral = clone $read;
        $readGeral->ExeRead('categorias',"WHERE nome = :nome","nome=geral");
        $resGeral = $readGeral->getResultado()[0];
        
        $readPosts->setPlaces("sub={$resGeral['id']}&limit=1&offset=0");    
        $resPostGeral = $readPosts->getResultado()[0];
        ?>
        <div class="destaq">
            <img src="<?= BASE.'/tim.php?src=uploads/'.$resPostGeral['capa']?>&w=300&h=300" alt="<?= $resPostGeral['titulo']?>" />
            <a href="<?= BASE.'/ver/'.$resPostGeral['nome']?>"><?= funcoes::limtarTextos($resPostGeral['titulo'], 32)?></a>
            <p><?= funcoes::limtarTextos($resPostGeral['conteudo'], 100)?></p>
        </div>
        
        <ul class="artigos">
        <?php 
        $readPosts->setPlaces("sub={$resGeral['id']}&limit=3&offset=1");    
        foreach ($readPosts->getResultado() as $res):
        ?>
            <li>
                 <img src="<?= BASE.'/tim.php?src=uploads/'.$res['capa']?>&w=100&h=100" alt="<?= $res['titulo']?>" />
                <a href="<?= BASE.'/ver/'.$res['nome']?>"><?= funcoes::limtarTextos($res['titulo'], 32)?></a>
                <p><?= funcoes::limtarTextos($res['conteudo'], 100)?></p>
            </li>
        <?php 
        endforeach;
        ?>
        	 <li class="readmore"><a href="<?= BASE.'/categoria/'.$resGeral['url']?>" title="Ver <?=$resGeral['nome']?>">LEIA +</a></li>
        </ul>
        
    </div><!-- /content -->
</div><!-- /BLOCO QUATRO -->



<div class="clear"></div><!--/clear-->
</div><!-- /HOME GERAL -->  
</div><!-- #SITE -->
    
  
<!-- FOOTER -->    
<div id="footer" class="footer">
    <div class="content">
        <?php setArq('tpl/sidebars/menu');?>                       
    </div><!-- /content -->
</div><!-- /#FOOTER -->