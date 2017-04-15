<div class="content home">
    <h1 class="location"><strong>Editar Post:</strong> Shael Sonnen e Anderson Silva Spider se enfrentam no UFC.</h1><!--/location-->
    <?php
    //Pega o id do post.
    $idpost = $_GET['idpost'];
    $readPost = new read();
    $readPost->ExeRead('posts', "WHERE id = :id", "id={$idpost}");

    if (!$readPost->getResultado()[0]):
        header('Location: dashboard.php?exe=posts/index&notfound=true');
    else:
        extract($readPost->getResultado()[0]);
    endif;
    ?>
    <div class="posts">
        <form name="editpost" class="formfull" action="" method="post" enctype="multipart/form-data">

            <label class="label">
                <span class="field">Titulo do post:</span>
                <input type="text" name="titulo" value="<?= $titulo ?>" />
            </label>

            <label class="label">
                <span class="field">Selecione a categoria:</span>
                <select name="sub_categoria">
                    <?php
                    //Ler as categorias pai.
                    $readCatPai = new read();
                    $readCatPai->ExeRead('categorias', "WHERE cat_pai IS NULL");
                    if ($readCatPai->getResultado()):
                        foreach ($readCatPai->getResultado() as $resCatPai):
                            echo '<option disabled="disabled" value="' . $resCatPai['id'] . '">' . $resCatPai['nome'] . '</option>';
                            //Ler as sub-categorias filhas.
                            $readCatSub = new read();
                            $readCatSub->ExeRead('categorias', "WHERE cat_pai = :idcat", "idcat={$resCatPai['id']}");
                            if ($readCatSub->getResultado()):
                                foreach ($readCatSub->getResultado() as $resCatSub):
                                    echo '<option';
                                    if ($sub_categoria == $resCatSub['id'])
                                        echo ' selected';
                                    echo' value="' . $resCatSub['id'] . '">' . $resCatSub['nome'] . '</option>';
                                endforeach;
                            endif;
                        endforeach;
                    endif;
                    ?>
                </select>
            </label>

            <div class="label">
                <span class="field">Imagem de capa:</span>
                <input name="capa" type="file" class="j_capa" accept="image/*" />
                <div class="j_false"></div>
                <img src="img/upload.png" class="j_send" alt="Enviar Capa" title="Enviar Capa" />

                <div class="viewcapa" <?php if (!$capa) echo ' style="display: none"'; ?>>
                    <img src="tim.php?src=../uploads/<?= $capa; ?>&h=42" alt="Capa" title="Capa" />  
                    <a href="../uploads/<?= $capa; ?>" rel="shadowbox" title="Ver Capa">Ver Capa</a>
                </div><!--viewcapa-->                                
            </div>

            <label class="label">
                <span class="field">Vídeo:</span>
                <input type="text" name="video" value="<?= $video ?>" />
            </label>
            
            <label class="label tinymce">
                <span class="field">Conteúdo:</span>
                <textarea class="timeditor" name="conteudo" rows="10"><?= $conteudo ?></textarea>
            </label>

            <label class="label">
                <span class="field">Data:</span>
                <input type="text" class="formDate" name="data_creacao" value="<?php echo date('d/m/Y H:i:s'); ?>" />
            </label>

            <div class="galerry">           	
                <div class="label" style="margin:0;">
                    <span class="field">Galeria:</span>
                    <input type="file" class="j_gallery" name="gb[]" multiple="multiple" accept="image/*" />
                    <div class="j_gfalse">Selecione quantas imagens desejar!</div>
                    <img src="img/upload.png" class="j_gsend" alt="Enviar Capa" title="Enviar Capa" style="margin:0 0 0 10px;" />                              
                </div>
                <ul>
                    <?php
                    $readGaleria = new read();
                    $readGaleria->ExeRead('imagens', "WHERE id_post = :id", "id={$id}");
                    if ($readGaleria->getResultado()):
                        foreach ($readGaleria->getResultado() as $gal):
                    ?>
                    <li class="j_<?=$gal['id']?>">
                            <a href="../uploads/<?=$gal['imagem']?>" rel="shadowbox[gb22]" title="Ver Imagem"><img src="tim.php?src=../uploads/<?=$gal['imagem']?>&w=148&h=90" /></a>
                            <a href="#" class="galerrydel" id="<?=$gal['id']?>" title="Excluir">X</a>
                        </li>
                    <?php
                        endforeach;
                    endif;
                    ?>
                </ul>

            </div><!--/gallery-->

            <input type="hidden" name="id" value="<?= $id ?>">
            <input type="submit" value="Atualizar post" class="btn" />  
            <label class="check"><input type="checkbox" name="status" value="1" <?php if ($status == 1) echo 'checked'; ?> />Publicar Isto</label><!-- /check -->     

        </form>
    </div><!--/posts -->

    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->