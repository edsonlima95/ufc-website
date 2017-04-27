<?php
ob_flush();
session_start();

require '../vendor/autoload.php';

$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);
$read = new read();
switch ($dados['acao']):
    case 'destaques';
        unset($dados['acao']);
        //Ler os posts. 
        $readPostDetalhe = clone $read;
        //Faz um join nas duas tabelas, soma os comentarios de acordo com o id do post e retornas os mais comentados.
        $readPostDetalhe->executeQuery("SELECT posts.*,(SELECT COUNT(comentarios.id) FROM comentarios WHERE comentarios.id_post = posts.id)"
                . "AS total_comentarios FROM posts ORDER BY total_comentarios DESC LIMIT 4");

        foreach ($readPostDetalhe->getResultado() as $resPostsDestaques):
            $i++;
            ?>
            <li <?php if ($i % 2 == 0) echo 'style="float:right;"'; ?>>
                <img src="<?= 'http://localhost/proJquery/projeto/tim.php?src=uploads/' . $resPostsDestaques['capa'] ?>&w=100&h=100" alt="<?= $resPostsDestaques['titulo'] ?>"/>
                <a title="<?= $resPostsDestaques['titulo'] ?>" href="<?= 'http://localhost/proJquery/projeto/ver/' . $resPostsDestaques['nome'] ?>"><?= funcoes::limtarTextos($resPostsDestaques['titulo'], 40) ?></a>
                <p><?= funcoes::limtarTextos($resPostsDestaques['conteudo'], 60) ?></p>
            </li>
            <?php
        endforeach;
        break;

    case 'deolho';
        unset($dados['acao']);

        //Ler os posts. 
        $readPostOlho = clone $read;
        $readPostOlho->ExeRead('posts', "WHERE status = 1 ORDER BY visitas DESC, data_creacao DESC LIMIT 4");
        foreach ($readPostOlho->getResultado() as $resPostsOlho):
            $i++;
            ?>
            <li <?php if ($i % 2 == 0) echo 'style="float:right;"'; ?>>
                <img src="<?= 'http://localhost/proJquery/projeto/tim.php?src=uploads/' . $resPostsOlho['capa'] ?>&w=100&h=100" alt="<?= $resPostsOlho['titulo'] ?>"/>
                <a title="<?= $resPostsOlho['titulo'] ?>" href="<?= 'http://localhost/proJquery/projeto/ver/' . $resPostsOlho['nome'] ?>"><?= funcoes::limtarTextos($resPostsOlho['titulo'], 40) ?></a>
                <p><?= funcoes::limtarTextos($resPostsOlho['conteudo'], 60) ?></p>
            </li>
            <?php
        endforeach;
        break;
    case 'cat_paginacao';
        unset($dados['acao']);

        //Paginacao.
        $idcategoria = $_SESSION['catid']['id'];
        $url = $_SESSION['catid']['url'];
        $page = $dados['page'];
        $paginacao = new paginacao('http://localhost/proJquery/projeto/categoria/' . $url . '/');
        $paginacao->pagina($page, 5);

        $readPostCat = new read();
        $readPostCat->ExeRead('posts', "WHERE sub_categoria = :idcat LIMIT :limit OFFSET :offset", "idcat={$idcategoria}&limit={$paginacao->getLimit()}&offset={$paginacao->getOffset()}");
        if ($readPostCat->getResultado()):
            echo '<ul>';
            foreach ($readPostCat->getResultado() as $resPost):
                extract($resPost);
                $i++;
                ?>
                <li<?php if ($i % 4 == 0) echo ' style="float:right; margin-right:0"'; ?>>
                    <img src="<?= 'http://localhost/proJquery/projeto/tim.php?src=uploads/' . $capa . '' ?>&w=220&h=150" />
                    <div class="licontent">
                        <a href="<?= 'http://localhost/proJquery/projeto/ver/' . $nome . '' ?>"><?= $titulo ?></a>
                    </div><!-- /content -->
                </li>
                <?php
            endforeach;
            echo '</ul>';
        else:
            $paginacao->retornaPagina();
        endif;

        echo '<div class="clear"></div>';
        echo '<div class="paginator">';
        $paginacao->paginacao('posts', "WHERE sub_categoria = :idcat", "idcat={$idcategoria}");
        echo $paginacao->paginator();
        echo '</div>';
        break;

    case 'search';
        unset($dados['acao']);

        $page = $dados['page'];
        $palavra = $dados['word'];

        //Paginacao.
        $page = (isset($url[2]) ? $url[2] : 1);
        $paginacao = new paginacao('http://localhost/proJquery/projeto/pesquisa/' . $palavra . '/');
        $paginacao->pagina($page, 4);

        $readPostCat = new read();
        $readPostCat->ExeRead('posts', "WHERE status = '1' AND (titulo LIKE '%' :search '%') ORDER BY data_creacao DESC LIMIT 4", "search={$palavra}");

        echo '<ul>';
        foreach ($readPostCat->getResultado() as $resPost):
            extract($resPost);
            $i++;
            ?>
            <li<?php if ($i % 4 == 0) echo ' style="float:right; margin-right:0"'; ?>>
                <img src="<?= 'http://localhost/proJquery/projeto/tim.php?src=../uploads/' . $capa . '' ?>&w=220&h=150" />
                <div class="licontent">
                    <a href="<?= 'http://localhost/proJquery/projeto/ver/' . $nome . '' ?>"><?= funcoes::limtarTextos($titulo, 40) ?></a>
                </div><!-- /content -->
            </li>
            <?php
        endforeach;
        echo '</ul>';

        echo '<div class="clear"></div>';

        echo '<div class="paginator">';

        $paginacao->paginacao('posts', "WHERE status = '1' AND (titulo LIKE '%' :search '%') ORDER BY data_creacao DESC", "search={$palavra}");
        echo $paginacao->paginator();

        echo '</div>';
        break;

endswitch;
ob_end_flush();
