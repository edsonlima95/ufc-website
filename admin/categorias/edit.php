<div class="content home">
    <?php
    $idcat = filter_input(INPUT_GET, 'idcat', FILTER_VALIDATE_INT);
    $readCat = new read();
    $readCat->ExeRead('categorias', 'WHERE id = :id', "id={$idcat}");
    if (!$readCat->getResultado()):
        header('Location: dashboard.php?exe=categorias/index&catnotfound=true');
    else:
        $categoria = $readCat->getResultado()[0];
    endif;
    ?>
    <h1 class="location"><strong>Editar:</strong> <?= $categoria['nome'] ?></span></h1><!--/location-->
    <div class="posts">
        <form name="editcat" class="formfull" action="" method="post" enctype="multipart/form-data">

            <label class="label">
                <?php
                //Verifica se é uma categoria, se existe o cat_pai compara com o id da categoria.
                $readCat->ExeRead('categorias', "WHERE id = :id", "id={$categoria['cat_pai']}");
                if ($readCat->getResultado()):
                    echo '<span class="field" style="font-size:30px; color:#ccc;">Categoria: ' . $readCat->getResultado()[0]['nome'] . '</span>';
                endif;
                ?>
            </label>
            <label class="label">
                <span class="field">Categoria:</span>
                <input type="text" required name="nome" value="<?= $categoria['nome'] ?>" />
            </label>

            <label class="label">
                <span class="field">Descrição:</span>
                <textarea name="descricao" required rows="2" style="resize:none"><?= $categoria['descricao'] ?></textarea>
            </label>                     

            <div class="label">
                <span class="field">Imagem de capa:</span>
                <input type="file" class="j_capa" accept="image/*" name="capa"/>
                <div class="j_false"></div>
                <img src="img/upload.png" class="j_send" alt="Enviar Capa" title="Enviar Capa" />

                <div class="viewcapa" <?php if (!$categoria['capa']) echo 'style="display: none'; ?>">
                    <img src="tim.php?src=../uploads/<?= $categoria['capa'] ?>&h=42" alt="Capa" title="Capa" />
                    <a href="../uploads/<?= $categoria['capa'] ?>" rel="shadowbox" title="Ver Capa">Ver Capa</a>
                </div><!--viewcapa-->                                
            </div>

            <div class="progress" style="display: none"><div class="bar">0%</div></div>

            <label class="label">
                <span class="field">Data:</span>
                <input type="text" class="formDate" name="data_creacao" value="<?php echo date('d/m/Y H:i:s'); ?>" />
            </label>
            <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
            <input type="submit" value="Atualizar Categoria" class="btn" />     
        </form>
    </div><!--/posts -->
    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->