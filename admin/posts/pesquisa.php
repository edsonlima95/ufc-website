<div class="content home">
    <?php
    //Pega a palavra.
    $searchword = filter_input(INPUT_GET,strip_tags(trim('search')), FILTER_DEFAULT);
    ?>
   <h1 class="location">Pesquisa por: <strong><?= $searchword ?></strong> <span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->
    
    <div class="posts">
        <div class="paginator">
            <div class="paginator_form">
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
                <form name="searchpost" action="" method="post">
                <input type="text" name="sposts" title="Pesquisar Post"  class="j_placeholder"  />
                <input type="submit" name="search" value="Buscar" class="btn" />
            </form>
            </div>
        </div><!-- /paginator -->

        <ul class="content">
            <?php
            //Busca.
            $search = filter_input_array(INPUT_POST,FILTER_DEFAULT);
            if(isset($search['search'])):
                unset($search['search']);
               $pesquisa = urlencode($search['sposts']);
               header('Location: dashboard.php?exe=posts/pesquisa&search='.$pesquisa);
            endif;

            //Paginacao.
            $pagina = new paginacao('dashboard.php?exe=posts/pesquisa&search='.urldecode($searchword).'&atual=');
            $atual = filter_input(INPUT_GET, 'atual', FILTER_VALIDATE_INT);
            $pagina->pagina($atual, 5);
            
            //Ler os posts.
            $readPosts = new read();
            $readPosts->ExeRead('posts', "WHERE nome LIKE '%' :search '%' OR titulo LIKE '%' :search '%' LIMIT  :limit OFFSET :offset","limit={$pagina->getLimit()}&offset={$pagina->getOffset()}&search={$searchword}");

            if (!$readPosts->getResultado()):
                echo '<p style="background: orange; color: #fff; font-weight: bold; width: 980px; margin-bottom: 10px; padding: 10px;">Opaa, sua pesquisa retornou <strong>'.$readPosts->getRowCount().' resultados<p>';
            else:
                foreach ($readPosts->getResultado() as $resPosts):
                    extract($resPosts);

                    //Ler os comentarios do post
                    $readComent = new read();
                    $readComent->ExeRead('comentarios', "WHERE id_post = :id", "id={$id}");
                    $countCom = count($readComent->getResultado());

                    //Ler a categoria para pegar o nome.
                    $readC = new read();
                    $readC->ExeRead('categorias', "WHERE id = :id", "id={$categoria}");
                    $countC = $readC->getResultado()[0];
                    ?>
                    <li class="li" id="j_<?= $id ?>" <?php if ($status == 0): echo 'style="background: #ccc"';endif; ?>>
                        <img src="../tim.php?src=../uploads/<?php if (empty($capa)): echo 'padrao.png';else: echo $capa;endif; ?>&w=200&h=120" />
                        <div class="info">
                            <p class="title"><?= funcoes::limtarTextos($titulo, 180); ?></p>
                            <p class="resumo"><?= funcoes::limtarTextos($conteudo, 180); ?></p>
                            <p class="categoria"><a href="<?= BASE . '/categoria/' . $countC['url'] ?>"><?= $countC['nome'] ?></a> &nbsp;&nbsp;/&nbsp;&nbsp; <?= date('d/m/Y H:i:s ', strtotime($data_creacao)) ?></p>
                            <span>
                                <a title="Excluir" class="delete j_delposts" id="<?= $id ?>" href="#">Excluir</a> 
                                <a title="Compartilhar" class="share j_compartilha" href="<?= BASE . '/ver/' . $nome ?>">Compartilhar</a>  
                                <a title="Editar" class="edit j_editar" id="<?= $id ?>" href="dashboard.php?exe=posts/edit&idpost=<?= $id ?>">Editar</a>  
                                <a title="Ver" class="ver" href="<?= BASE . '/ver/' . $nome ?>">Ver</a>                    
                            </span>
                        </div><!--/info-->
                        <ul class="sub">
                            <li><strong><?= $visitas ?></strong> visitas</li>
                            <li><strong><?= $countCom ?></strong> comentários</li>';
                        </ul>
                    </li>
                    <?php
                endforeach;
            endif;
            ?>
        </ul><!--/content-->

        <div class="paginator">
            <?php
            $pagina->paginacao('posts');
            echo $pagina->paginator();
            ?>
        </div><!-- /paginator -->
    </div><!--/posts -->

    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->