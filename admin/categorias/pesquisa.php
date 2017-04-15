<?php
    //Pega a palavra.
    $searchword = filter_input(INPUT_GET,strip_tags(trim('search')), FILTER_DEFAULT);
?>
<div class="content home">
    <h1 class="location">Pesquisa por: <strong><?= $searchword ?></strong> <span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->

    <div class="posts">
        <div class="paginator">
            <div class="paginator_form">
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
            <form name="searchpost" action="" method="post">
                <input type="text" name="sposts" title="Pesquisar Categorias"  class="j_placeholder"  />
                <input type="submit" name="search" value="Buscar" class="btn" />
            </form>
            </div>
        </div><!-- /paginator -->

        <?php
        //Busca.
        $search = filter_input_array(INPUT_POST,FILTER_DEFAULT);
        if(isset($search['search'])):
            unset($search['search']);
           $pesquisa = urlencode($search['sposts']);
           header('Location: dashboard.php?exe=categorias/pesquisa&search='.$pesquisa);
        endif;
        
        //Paginacao.
        $pagina = new paginacao('dashboard.php?exe=categorias/pesquisa&search='.urldecode($searchword).'&atual=');
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pagina->pagina($atual, 1);
        
        //Leitura dos dados.
        $readPesquisa = new read();
        $readPesquisa->ExeRead('categorias', "WHERE nome LIKE '%' :search '%' OR descricao LIKE '%' :search '%' LIMIT :limit OFFSET :offset", "limit={$pagina->getLimit()}&offset={$pagina->getOffset()}&search={$searchword}");
        if (!$readPesquisa->getResultado()):
            echo "Opaa, sua pesquisa retornou <strong>".$readPesquisa->getRowCount()." </strong> resultados";
        else:
            echo '<ul class="content catli">';
            foreach ($readPesquisa->getResultado() as $resultPesq):
                extract($resultPesq);
            
                $tipo = ($cat_pai != '' ? 'Sub-Categoria' : 'Categoria');
                
                //Conta quantas sub categorias o post tem.
                $readCatCount = new read();
                $readCatCount->ExeRead('categorias', "WHERE cat_pai = :id", "id={$id}");
                $countSub = count($readCatCount->getResultado());
             ?>
                <li class="li">
                    <img src="../tim.php?src=tpl/_gbt/1.jpg&w=120&h=120" />
                    <div class="info" style="width:636px;">
                        <p class="title"><?= $nome ?></p>
                        <p class="resumo"><?= $descricao ?></p>
                        <p class="categoria"><?= date('d/m/Y H:i', strtotime($dada_creacao)); ?></p>
                        <span>
                          <?php
                              if($countSub == 0):
                                    echo '<a title="Excluir" class="delete j_deletarcat" id="'.$id.'" href="#">Excluir</a>'; 
                              endif;
                            ?>
                             <a title="Editar" class="edit" href="dashboard.php?exe=categorias/edit&edita=<?=$id?>" >Editar</a>  
                            <a title="Ver" class="ver" href="../categorias/<?= $nome ?>" target="_blank">Ver</a>                  
                        </span>
                    </div><!--/info-->
                    <ul class="sub">
                        <li><strong><?= $countSub ?></strong><?= $tipo ?></li>
                    </ul>
                </li>
            <?php
            endforeach;//Fim do foreach categorias.
            echo '</ul>';
            echo '<div class="paginator">'.
            $pagina->paginacao('categorias', "WHERE cat_pai IS NULL"); echo $pagina->paginator() 
                  .'</div>';
        endif;
            ?>
    </div><!--/posts -->
    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->