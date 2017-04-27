<?php
funcoes::superUser();
?>
<div class="content home">
    <h1 class="location">Configurações<span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->

    <div class="configs">
        <!--Abas que chama os formularios de acordo com o nome.-->
        <ul class="abas_config">
            <li><a href="config_manutencao" class="active" title="Módulo de Manutenção">Módulo de Manutenção</a></li>
            <li><a href="config_email" title="E-mail de envio">Servidor de e-mail</a></li>
            <li><a href="config_seo" title="Otimizar Home">Otimizar Home</a></li>
            <li><a href="config_endereco" title="Modulo de Endereço">Endereço e Telefone</a></li>
            <li><a href="config_temas" title="Modulo de Temas">Temas</a></li>
        </ul><!--/navega-->

        <!-- //FORM CONFIG MANUTENÇÃO -->
        <form name="config_manutencao" class="first" action="" method="post">        
            <fieldset>
                <?php
                $readStatus = new read();
                $readStatus->ExeRead('config_manutencao');
                $status = $readStatus->getResultado()[0]['manutencao'];
                ?>
                <legend>Acesso ao site:</legend>
                <div class="j_desativa main <?php if($status == 1): echo ' block'; endif;?>">
                    <span class="field">Modo Manutenão: <strong style="color:green">ATIVO</strong></span>
                    <input type="submit" value="DESATIVAR MANUTENÇÃO" class="btn j_config_manutencao_no" /> 
                    <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
                </div>

                <div class="j_ativo main <?php if($status == 0): echo ' block'; endif;?>">
                    <span class="field">Modo Manutenão: <strong style="color:red">INATIVO</strong></span>
                    <input type="submit" value="ATIVAR MANUTENÇÃO" class="btn j_config_manutencao_yes" /> 
                    <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
                </div>
            </fieldset>
        </form>

        <!-- //FORM SERVER MAIL -->
        <form name="config_email" action="" method="post">        
            <?php
            //Ler a tabela de configuração de email.
            $readEmailServer = new read();
            $readEmailServer->ExeRead('config_emailserver');
            $email = $readEmailServer->getResultado()[0];
       
            ?>
            <fieldset>
                <legend>Email de envio:</legend>
                <label class="label">
                    <span class="field">E-mail:</span>
                    <input type="text" name="email" value="<?php if(isset($email['email'])): echo $email['email']; endif; ?>" />                    
                </label>

                <label class="label">
                    <span class="field">Senha:</span>
                    <input type="password" name="senha" value="<?php if(isset($email['senha'])): echo $email['senha']; endif; ?>" />              
                </label>

                <label class="label">
                    <span class="field">Porta:</span>
                    <input type="text" name="porta" value="<?php if(isset($email['porta'])): echo $email['porta']; endif; ?>" />                 
                </label>

                <label class="label">
                    <span class="field">Server:</span>
                    <input type="text" name="server" value="<?php if(isset($email['server'])): echo $email['server']; endif; ?>" />                    
                </label> 

                <input type="submit" value="Atualizar Dados" class="btn" /> 
                <input type="button" value="Testar Envio" class="btn teste j_config_email_teste" />
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />           
            </fieldset>               
        </form>


        <!-- //FORM CONFIG SEO -->
        <form name="config_seo" action="" method="post">        
            <?php
            //Ler a tabela de configuração de seo.
            $readSeo = new read();
            $readSeo->ExeRead('config_seosociais');
            $seo = $readSeo->getResultado()[0];
            ?>
            <fieldset>
                <legend>SEO/Social:</legend>
                <label class="label">
                    <span class="field">Titulo:</span>
                    <input type="text" name="titulo" value="<?php if(isset($seo['titulo'])): echo $seo['titulo']; endif; ?>" />                   
                </label>

                <label class="label">
                    <span class="field">Descrição:</span>
                    <textarea name="descricao" rows="5"><?php if(isset($seo['descricao'])): echo $seo['descricao']; endif; ?></textarea>                 
                </label>

                <label class="label">
                    <span class="field">Facebook:</span>
                    <input type="text" name="facebook" value="<?php if(isset($seo['facebook'])): echo $seo['facebook']; endif; ?>" />                       
                </label>

                <label class="label">
                    <span class="field">Twitter:</span>
                    <input type="text" name="twitter" value="<?php if(isset($seo['twitter'])): echo $seo['twitter']; endif; ?>" />                      
                </label>  

                <input type="submit" value="Otimizar Site" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />          
            </fieldset>     
        </form>       
        
        <!-- //FORM CONFIG ENDERECO -->
        <form name="config_endereco" action="" method="post">      
            <?php
             //Ler a tabela de configuração de endereço.
            $readEndereco = new read();
            $readEndereco->ExeRead('config_endereco');
            $endereco = $readEndereco->getResultado()[0];
            ?>
            <fieldset>
                <legend>Endereço/Telefone:</legend>
                <label class="label">
                    <span class="field">Endereço:</span>
                    <input type="text" name="endereco" value="<?php if(isset($endereco['endereco'])): echo $endereco['endereco']; endif; ?>" />                  
                </label>
                
                <label class="label">
                    <span class="field">Telefone:</span>
                    <input type="text" name="telefone" class="formTel" value="<?php if(isset($endereco['telefone'])): echo $endereco['telefone']; endif; ?>" />                
                </label>

                <input type="submit" value="Otimizar Site" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />          
            </fieldset>     
        </form>     
        
        <!-- //FORM CONFIG TEMAS -->
        <form name="config_temas" action="" method="post">      
            <?php
             //Ler a tabela de configuração de endereço.
            $readTemas = new read();
            $readTemas->ExeRead('config_tema',"ORDER BY data_creacao DESC");
            
            if($readTemas->getResultado()):
            echo '<table class="temas">';
                echo '<tr class="titulo">
                          <th>Tema:</th>
                          <th>Pasta:</th>
                          <th>Data:</th>
                          <th>Ação</th>
                    </tr>';
                foreach ($readTemas->getResultado() as $resTema):
                    
                //Pasta
                $pasta = '../temas/'.$resTema['pasta'];
                //Verifica se existe a pasta.
                $verifica = (file_exists($pasta) && is_dir($pasta) ? 1 : 0);
                $tipo = ($verifica ? '<strong style="color: green">&radic;</strong>' : '<strong style="color: red">&Chi;</strong>'); 
            ?>
            <tr id="<?=$resTema['id']?>" <?php if($resTema['inuse']) echo 'style="background: #09F"';?>>
                <td><?=$resTema['nome']?></td>
                <td><?= $tipo.' - '.$resTema['pasta']?></td>
                <td><?=date('d/m/Y H:i',$resTema['data_creacao']);?></td>
                <?php
                //Se tiber ativo e existir na pasta pode ativar e desativar.
                if(!$resTema['inuse'] && $verifica):
                      echo '<td><a href="#" title="Ativa tema: '.$resTema['nome'].'" id="'.$resTema['id'].'" class="j_ativatema">ATIVA TEMA</a></td>';
                elseif(!$verifica)://Se nao existir a pasta e se nao estiver em uso.
                      echo '<td><a href="#" title="Deletar tema'.$resTema['nome'].'" id="'.$resTema['id'].'" class="j_deletatema">DELETAR TEMA</a></td>';
                else:
                    echo '<td style="font-weight: 600; color: #0011e0;">ATIVO</td>';
                endif;
                ?>
            </tr>       
             <?php
                   endforeach;
                echo '</table>';
            endif;
            ?>
            <fieldset>
                <legend>Endereço/Telefone:</legend>
                <label class="label">
                    <span class="field">Nome:</span>
                    <input type="text" name="nome" />                  
                </label>
                
                <label class="label">
                    <span class="field">Pasta:</span>
                    <input type="text" name="pasta" />                
                </label>

                <input type="submit" value="Otimizar Site" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />          
            </fieldset>     
        </form>    

    </div><!--/configs -->

    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->