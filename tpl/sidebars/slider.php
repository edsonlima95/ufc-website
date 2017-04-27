<!-- SLIDE HOME TOPO -->
<div id="home" class="homeslide">
<ul class="slidequery">
    <?php
    $readSlide = new read();
    $readSlide->ExeRead('posts',"WHERE status = 1 ORDER BY data_creacao DESC LIMIT 3");
    foreach ($readSlide->getResultado() as $resSlide):
        extract($resSlide);
    ?>
    <li>
        <img src="<?php setHome();?>/uploads/<?=$capa?>" />
        <div class="info">
            <div class="content">
                <div class="texto">
                    <h2><a href="<?= setHome().'/ver/'.$nome?>"><?= funcoes::limtarTextos($titulo,50)?></a></h2>
                    <p><?= funcoes::limtarTextos($conteudo,250)?></p>  
                </div><!-- /texto -->
                <div class="slidequerynav"></div><!-- /.slidequerynav -->
            <div class="clear"></div><!-- /clear -->   
            </div><!-- /content -->                     
        </div><!-- /info -->                   	
    </li>
    <?php
    endforeach;
    ?>
</ul>
</div><!-- /homeslide -->