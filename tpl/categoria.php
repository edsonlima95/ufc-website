</head>

<!--body -->
<body>

<?php 
    setArq('tpl/sidebars/pgheader');	
    
    //Pega o nome da categoria, e faz a leitura.
    $nomeCat = $url[1];
    
    $readCategoria = new read();
    $readCategoria->ExeRead('categorias',"WHERE url = :url","url={$nomeCat}");
    $resul = $readCategoria->getResultado()[0];
    //Cria uma sessao com id da categoria para ser pego no case 
    $_SESSION['catid']['id'] = $resul['id'];
    $_SESSION['catid']['url'] = $resul['url'];
?> 
  
<!-- BLOCO SITE GERAL HOME -->
<div id="site">
<div class="home">

<!-- BLOCO UM - h1. h2. Img Topo -->
<div class="bloco_um">

    <h1><?= ucfirst($resul['nome']) ?></h1>
    <h2><?= $resul['descricao']?></h2>

    <div class="capa">
       	<img src="<?= setHome().'/tim.php?src=uploads/'.$resul['capa'].''?>&w=200&h=200" />
    </div><!-- /capa -->
        
</div><!-- /BLOCO UM -->
<div class="clear"></div><!-- /clear -->

<div class="categorias j_catpag">
        <?php 
         
        //Paginacao.
        $page = (isset($url[2]) ? $url[2] : 1);
        $paginacao = new paginacao('http://localhost/proJquery/projeto/categoria/'.$resul['url'].'/');
        $paginacao->pagina($page, 5);
        
        $readPostCat = clone $readCategoria;
        $readPostCat->ExeRead('posts',"WHERE sub_categoria = :idcat LIMIT :limit OFFSET :offset","idcat={$resul['id']}&limit={$paginacao->getLimit()}&offset={$paginacao->getOffset()}");
        if($readPostCat->getResultado()):
        echo '<ul>';
        foreach ($readPostCat->getResultado() as $resPost):
            extract($resPost);
        $i++;
        ?>
        <li<?php if($i%4==0) echo ' style="float:right; margin-right:0"';?>>
            	<img src="<?= setHome().'/tim.php?src=uploads/'.$capa.''?>&w=220&h=150" />
                <div class="licontent">
                <a href="<?= setHome().'/ver/'.$nome.''?>"><?=$titulo?></a>
            </div><!-- /content -->
        </li>
        <?php 
        endforeach;
        echo '</ul>';
        else:
            $paginacao->retornaPagina();
        endif;
    
        ?>   
    
    <div class="clear"></div><!-- /clear -->
    
    <div class="paginator">
        <?php
        $paginacao->paginacao('posts',"WHERE sub_categoria = :idcat","idcat={$resul['id']}");
        echo $paginacao->paginator();
        ?>
    </div><!-- /paginator -->
    
</div><!--/categorias-->

<div class="clear"></div><!--/clear-->
</div><!-- /HOME GERAL -->  
</div><!-- #SITE -->   
  
<!-- FOOTER -->    
<div class="footer">
    <div class="content">
        <?php setArq('tpl/sidebars/pgmenu');?>                       
    </div><!-- /content -->
</div><!-- /#FOOTER -->