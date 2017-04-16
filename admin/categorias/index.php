<div class="content home">
    <h1 class="location">Gerenciar Categorias <span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->
    <?php
    //Categorias.
    if (isset($_GET['catnotfound'])):
        echo 'Não a categorias cadastradas';
    endif;
    ?>
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

                //Conta quantas sub categorias o post tem.
                $readCatCount = new read();
                $readCatCount->ExeRead('categorias', "WHERE cat_pai = :id", "id={$id}");
                $countSub = count($readCatCount->getResultado());
             ?>
                <li class="li" id="<?=$id?>">
                   <?php
                   //Verifica na pasta, se nao tiver nao exibe a img
                   if(file_exists('../uploads/'.$capa) && !is_dir('../uploads/'.$capa)):                       
                        echo '<img src="../tim.php?src=../uploads/'.$capa.'&w=120&h=120" />';
                   endif;
                   ?>
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
                        <li><strong><?= $countSub ?></strong> subcategorias</li>
                    </ul>
                </li>
                <?php
                $readSub = new read();
                $readSub->ExeRead('categorias', "WHERE cat_pai = :idpai ORDER BY nome DESC", "idpai={$id}");
                foreach ($readSub->getResultado() as $resultSub):
                    
                $readPostCount = new read();
                $readPostCount->ExeRead('posts', "WHERE sub_categoria =:sub", "sub={$resultSub['id']}");
                $countPost = count($readPostCount->getResultado());
                ?>
                    <li class="li subli" id="<?=$resultSub['id']?>">
                        <?php
                        //Verifica na pasta, se nao tiver nao exibe a img
                        if(file_exists('../uploads/'.$resultSub['capa']) && !is_dir('../uploads/'.$resultSub['capa'])):                       
                             echo '<img src="../tim.php?src=../uploads/'.$resultSub['capa'].'&w=120&h=120" />';
                        endif;
                        ?>
                        <div class="info" style="width:636px;">
                            <p class="title"><?= $resultSub['nome']; ?></p>
                            <p class="resumo"><?= $resultSub['descricao']; ?></p>
                            <p class="categoria">04-05-2013 16:28</p>
                            <span>
                                <?php
                                    if($countPost == 0):
                                        echo '<a title="Excluir" class="delete j_deletarcat" id="'.$resultSub['id'].'" href="#">Excluir</a>';
                                    endif;
                                ?>
                                 <a title="Editar" class="edit" href="dashboard.php?exe=categorias/edit&edita=<?=$resultSub['id']?>" >Editar</a>  
                                <a title="Ver" class="ver" href="../categorias/<?= $nome ?>">Ver</a>                    
                            </span>
                        </div><!--/info-->
                        <ul class="sub">
                            <li><strong><?=$countPost?></strong> artigos</li>
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