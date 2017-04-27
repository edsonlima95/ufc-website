</head>

<!--body -->
<body>

<?php 
    setArq('tpl/sidebars/pgheader');	
    //Pega o nome e faz a leitura.
    $nomeCat = urldecode($url[1]);
?> 
  
<!-- BLOCO SITE GERAL HOME -->
<div id="site">
<div class="home">

<!-- BLOCO UM - h1. h2. Img Topo -->
<div class="bloco_um">

    <h1><?='Pesquisa:'.$nomeCat ?></h1>
    <h2>Você pesquisou por: <strong><?= $nomeCat ?> </strong>confira abaixo os resultados!</h2>

    <div class="capa">
       	<img src="<?= setHome().'/tim.php?src=../uploads/padrao.png'?>&w=200&h=200" />
    </div><!-- /capa -->
        
</div><!-- /BLOCO UM -->
<div class="clear"></div><!-- /clear -->

<div class="categorias j_search">
        <?php 
         
        //Paginacao.
        $page = (isset($url[2]) ? $url[2] : 1);
        $paginacao = new paginacao('http://localhost/proJquery/projeto/pesquisa/'.$nomeCat.'/');
        $paginacao->pagina($page, 8);
        
        $readPostCat = new read();
        $readPostCat->ExeRead('posts', "WHERE status = '1' AND (titulo LIKE '%' :search '%') ORDER BY data_creacao DESC LIMIT :limit OFFSET :offset","limit={$paginacao->getLimit()}&offset={$paginacao->getOffset()}&search={$nomeCat}");
        if($readPostCat->getResultado()):
        echo '<ul>';
        foreach ($readPostCat->getResultado() as $resPost):
            extract($resPost);
        $i++;
        ?>
        <li<?php if($i%4==0) echo ' style="float:right; margin-right:0"';?>>
            	<img src="<?= setHome().'/tim.php?src=../uploads/'.$capa.''?>&w=220&h=150" />
                <div class="licontent">
                <a href="<?php setHome().'/ver/'.$nome.''?>"><?=funcoes::limtarTextos($titulo, 40)?></a>
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
        $paginacao->paginacao('posts',"WHERE status = '1' AND (titulo LIKE '%' :search '%') ORDER BY data_creacao DESC","search={$nomeCat}");
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