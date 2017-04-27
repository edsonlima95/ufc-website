<div class="logo">
        <img src="<?php setHome();?>/tpl/images/logotype.png" />
</div><!-- /logo --> 


<div class="left">
    <ul class="navtopo">
        <li><a class="a" href="#home">Home</a></li>
        <li><a class="a" href="#videos">Vídeos</a></li>
        <li><a class="a" href="#artigos">Artigos</a></li>
        <li><a class="subopen" href="#">+</a>
            <?php
            $readCatSubMenu = new read();
            $readCatSubMenu->ExeRead('categorias',"WHERE nome != 'videos' AND nome != 'geral' AND cat_pai IS NOT NULL");
            if($readCatSubMenu->getResultado()):
            echo '<ul class="submenu">';
                foreach ($readCatSubMenu->getResultado() as $resultCatSub):
                     echo '<li><a href="'.BASE.'/categoria/'.$resultCatSub['url'].'">'.$resultCatSub['nome'].'</a></li>';
                endforeach;
            echo '</ul>';
            endif;
            ?>
        </li>
        <li><a class="a" href="#contato">Contato</a></li>
    </ul><!-- /topo -->
</div><!--  left -->