<div class="content home">
    <h1 class="location">Gerenciar Posts <span><?php echo date('d/m/Y H:i');?></span></h1><!--/location-->
        <?php
        //Pega o id do post.
        if($_GET['notfound']):
            echo '<p style="background: orange; color: #fff; font-weight: bold; width: 980px; margin-bottom: 10px; padding: 10px;">Não contem posts cadastrados no momento!<p>';
        endif;
        
        ?>
	<div class="posts">
    	<div class="paginator">
        	<img src="img/loader.gif" alt="Carregando..." title="Carregando..." />
        	<form name="searchpost" action="" method="post">
            	<input type="text" name="sposts" value="Pesquisar Post:" />
                <input type="submit" value="Buscar" class="btn" />
            </form>
        </div><!-- /paginator -->
       
        <ul class="content">
        	<?php
                //Ler os posts.
                $readPosts = new read();
                $readPosts->ExeRead('posts',"ORDER BY data_creacao DESC");
                
                if(!$readPosts->getResultado()):
                    echo '<p style="background: orange; color: #fff; font-weight: bold; width: 980px; margin-bottom: 10px; padding: 10px;">Não contem posts cadastrados no momento!<p>';
                else:
                    foreach ($readPosts->getResultado() as $resPosts):
                    extract($resPosts);
                    
                    //Ler os comentarios do post
                    $readComent = new read();
                    $readComent->ExeRead('comentarios',"WHERE id_post = :id","id={$id}");
                    $countCom = count($readComent->getResultado());
                    
                    //Ler a categoria para pegar o nome.
                    $readC = new read();
                    $readC->ExeRead('categorias',"WHERE id = :id","id={$categoria}");
                    $countC = $readC->getResultado()[0];
                ?>
        	<li class="li" id="j_<?=$id?>" <?php if($status == 0): echo 'style="background: #ccc"'; endif; ?>>
                    <img src="../tim.php?src=../uploads/<?php if(empty($capa)): echo 'padrao.png'; else: echo $capa; endif;?>&w=200&h=120" />
                <div class="info">
               		<p class="title"><?=funcoes::limtarTextos($titulo,180);?></p>
                        <p class="resumo"><?= funcoes::limtarTextos($conteudo,180); ?></p>
                        <p class="categoria"><a href="<?= BASE.'/categoria/'.$countC['url'] ?>"><?= $countC['nome'] ?></a> &nbsp;&nbsp;/&nbsp;&nbsp; <?= date('d/m/Y H:i:s ', strtotime($data_creacao))?></p>
                	<span>
                            <a title="Excluir" class="delete j_delposts" id="<?=$id?>" href="#">Excluir</a> 
                        <a title="Compartilhar" class="share" href="#">Compartilhar</a>  
                        <a title="Editar" class="edit j_editar" id="<?=$id?>" href="dashboard.php?exe=posts/edit&idpost=<?=$id?>">Editar</a>  
                        <a title="Ver" class="ver" href="<?=BASE.'/ver/'.$nome?>">Ver</a>                    
                    </span>
            	</div><!--/info-->
                <ul class="sub">
                    <li><strong><?=$visitas?></strong> visitas</li>
                    <li><strong><?= $countCom ?></strong> comentários</li>';
                </ul>
            </li>
            <?php
                endforeach;
            endif;
            ?>
        </ul><!--/content-->

        <div class="paginator">
            <a href="#">1</a>
            <a href="#">2</a>
            <a href="#">3</a>
            <span class="atv">4</span>
            <a href="#">5</a>
            <a href="#">6</a>
        </div><!-- /paginator -->
	</div><!--/posts -->

<div class="clear"></div><!-- /clear -->
</div><!-- /content -->