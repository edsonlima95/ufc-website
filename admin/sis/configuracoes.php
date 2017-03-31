<div class="content home">
    <h1 class="location">Configurações<span><?php echo date('d/m/Y H:i'); ?></span></h1><!--/location-->

    <div class="configs">
        <!--Abas que chama os formularios de acordo com o nome.-->
        <ul class="abas_config">
            <li><a href="config_manutencao" class="active" title="Módulo de Manutenção">Módulo de Manutenção</a></li>
            <li><a href="config_email" title="E-mail de envio">Servidor de e-mail</a></li>
            <li><a href="config_seo" title="Otimizar Home">Otimizar Home</a></li>
            <li><a href="config_endereco" title="Modulo de Endereço">Endereço e Telefone</a></li>
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
                <label class="j_desativa main <?php if($status == 1): echo ' block'; endif;?>">
                    <span class="field">Modo Manutenão: <strong style="color:green">ATIVO</strong></span>
                    <input type="submit" value="DESATIVAR MANUTENÇÃO" class="btn j_config_manutencao_no" /> 
                    <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
                </label>

                <label class="j_ativo main <?php if($status == 0): echo ' block'; endif;?>">
                    <span class="field">Modo Manutenão: <strong style="color:red">INATIVO</strong></span>
                    <input type="submit" value="ATIVAR MANUTENÇÃO" class="btn j_config_manutencao_yes" /> 
                    <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
                </label>
            </fieldset>
        </form>

        <!-- //FORM SERVER MAIL -->
        <form name="config_email" action="" method="post">        
            <fieldset>
                <legend>Email de envio:</legend>
                <label class="label">
                    <span class="field">E-mail:</span>
                    <input type="text" name="email" />                    
                </label>

                <label class="label">
                    <span class="field">Senha:</span>
                    <input type="password" name="senha" />                    
                </label>

                <label class="label">
                    <span class="field">Porta:</span>
                    <input type="text" name="porta" />                    
                </label>

                <label class="label">
                    <span class="field">Server:</span>
                    <input type="text" name="server" />                    
                </label> 

                <input type="submit" value="Testar Envio" class="btn teste j_config_email_teste" />
                <input type="submit" value="Atualizar Dados" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />           
            </fieldset>               
        </form>


        <!-- //FORM CONFIG SEO -->
        <form name="config_seo" action="" method="post">        
            <fieldset>
                <legend>SEO/Social:</legend>
                <label class="label">
                    <span class="field">Titulo:</span>
                    <input type="text" name="title" />                    
                </label>

                <label class="label">
                    <span class="field">Descrição:</span>
                    <textarea name="descricao" rows="5"></textarea>                 
                </label>

                <label class="label">
                    <span class="field">Facebook:</span>
                    <input type="text" name="facebook" />                    
                </label>

                <label class="label">
                    <span class="field">Twitter:</span>
                    <input type="text" name="twitter" />                    
                </label>  

                <input type="submit" value="Otimizar Site" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />          
            </fieldset>     
        </form>       
        
        <!-- //FORM CONFIG SEO -->
        <form name="config_endereco" action="" method="post">        
            <fieldset>
                <legend>Endereço/Telefone:</legend>
                <label class="label">
                    <span class="field">Endereço:</span>
                    <input type="text" name="endereco" />                    
                </label>
                
                <label class="label">
                    <span class="field">Telefone:</span>
                    <input type="text" name="telefone" class="formTel"/>                    
                </label>

                <input type="submit" value="Otimizar Site" class="btn" /> 
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />          
            </fieldset>     
        </form>       

    </div><!--/configs -->

    <div class="clear"></div><!-- /clear -->
</div><!-- /content -->