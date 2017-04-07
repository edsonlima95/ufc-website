<div class="content home">
    <h1 class="location">Gerenciar Categorias <span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->

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
           header('Location: dashboard.php?exe=categorias/pesquisa&serch='.$pesquisa);
        endif;
        
        //Paginacao.
        $pagina = new paginacao('http://localhost/proJquery/projeto/admin/dashboard.php?exe=categorias/index&atual=');
        $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
        $pagina->pagina($atual, 1);
        
        //Leitura dos dados.
        $readCat = new read();
        $readCat->ExeRead('categorias', "WHERE cat_pai IS NULL ORDER BY nome DESC LIMIT :limit OFFSET :offset", "limit={$pagina->getLimit()}&offset={$pagina->getOffset()}");
        if (!$readCat->getResultado()):
            echo 'Não a results';
        else:
            echo '<ul class="content catli">';
            foreach ($readCat->getResultado() as $resultCat):
                extract($resultCat);

                //Conta quantas sub categorias.
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
                            <a title="Excluir" class="delete" href="#excluir">Excluir</a> 
                            <a title="Editar" class="edit" href="#edit">Editar</a>  
                            <a title="Ver" class="ver" href="../categorias/<?= $nome ?>" target="_blank">Ver</a>                    
                        </span>
                    </div><!--/info-->
                    <ul class="sub">
                        <li><strong><?= $countSub ?></strong> subcategorias</li>
                    </ul>
                </li>
                <?php
                $readSub = new read();
                $readSub->ExeRead('categorias', "WHERE cat_pai = :idpai ORDER BY nome DESC", "idpai={$id}");
                foreach ($readSub->getResultado() as $resultSub):
                ?>
                    <li class="li subli">
                        <img src="../tim.php?src=tpl/_gbt/1.jpg&w=120&h=120" />
                        <div class="info" style="width:636px;">
                            <p class="title"><?= $resultSub['nome']; ?></p>
                            <p class="resumo"><?= $resultSub['descricao']; ?></p>
                            <p class="categoria">04-05-2013 16:28</p>
                            <span>
                                <a title="Excluir" class="delete" href="#excluir">Excluir</a> 
                                <a title="Editar" class="edit" href="#edit">Editar</a>  
                                <a title="Ver" class="ver" href="../categorias/<?= $nome ?>">Ver</a>                    
                            </span>
                        </div><!--/info-->
                        <ul class="sub">
                            <li><strong>1280</strong> artigos</li>
                        </ul>
                    </li>
                <?php
                endforeach; //Fim do foreach sub-categorias.
                ?>
            <?php
            endforeach;//Fim do foreach categorias.
            echo'</ul>';
        endif;
            ?>
        <div class="paginator">
            <?php
            $pagina->paginacao('categorias', "WHERE cat_pai IS NULL");
            echo $pagina->paginator();
            ?>
        </div>
    </div><!--/posts -->
    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->