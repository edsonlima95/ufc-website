<?php
//Funcao de verificacao de nivel.
funcoes::superUser();
?>
<div class="content home">
    <h1 class="location">Gerenciar Usuários<span><a href="#novousuario" class="j_adduser" title="voltar">Novo usuário</a></span></h1><!--/location-->
    <div class="usuarios">
    	<ul class="users">
        	<?php 
                //Ler os usuarios cadastrados.
                $readUsers = new read();
                $readUsers->ExeRead('users');
                if($readUsers->getResultado()):
                    foreach ($readUsers->getResultado() as $users):
                        extract($users);
                ?>
            <li id="<?=$id ?>">
            	<img class="avatar" src="http://0.gravatar.com/avatar/4161e253b6b48b7bc34e7fbd5cdc232f?s=180&d=monsterid&r=G" />
                <span class="nome"><?= $nome ?></span>
                <span class="nivel"><?php if($nivel == 1): echo 'Super Admin'; else: echo 'Admin';  endif?></span>
                <span class="data">Cadastrado em: <?= date('d/m/Y H:i', strtotime($data_creacao));?></span>
                <div class="manage">
                    <a class="edit j_edit" id="<?= $id ?>" href="#editar">Editar</a>
                    <a class="dell j_delete" id="<?= $id ?>" href="#excluir">Excluir</a>
                </div><!--/manage-->
            </li>
            <?php
              endforeach;
            endif;
            ?> 
        </ul><!--/users-->
    </div><!--/usuarios -->
<div class="clear"></div><!-- /clear -->
</div><!-- /content -->