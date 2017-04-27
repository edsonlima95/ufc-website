<!--MODAL DE LOADS DE POSTS.-->
<div class="loadmodal j_edit_posts">
    <p class="title">
        <img src="img/loader.gif" alt="Carregando" title="Carregando" />
        ATUALIZANDO POST!
        <span>Aguarde enquanto todos os dados são processados.</span>
    </p>
    <div class="content">
        <div class="progress">
            <div class="bar">0%</div>
        </div>

        <p class="accept">
            <strong>Parabéns</strong>. Seu post foi atualizado com sucesso!
            <a href="#" class="j_closeloadposts">FECHAR</a>
        </p>            
    </div><!--/CONTENT-->
</div><!--/LOADMODAL-->

<div class="dialog">

    <!--MODAL DAS ESTATISTICAS.-->
    <div class="boxleft trafego modaltrafego">
        <h3>Tráfego por mês: <a href="#" class="j_closetrafic">Fechar</a></h3>
        <div class="content">    

            <form name="geradados" action="" method="post">
                <span class="title">Consultar Estatísticas:</span>
                <label>
                    <span>de:</span>
                    <input type="text" class="formDate2" name="inicio" />
                </label>

                <label>
                    <span>à:</span>
                    <input type="text" class="formDate2" name="final" value="<?php echo date('d/m/Y'); ?>" />
                </label>

                <img src="img/loader.gif" alt="Carregando" style="display: none" class="load" title="Carregando" />
                <input type="submit" class="btn" value="Gerar Relatório" />      

            </form>

            <ul class="relatorio j_relatorio">
                <li class="title">
                    <span class="date">Dia</span>
                    <span class="views">Visitas</span>
                    <span class="users">Usuários</span>
                    <span class="pages">PageViews</span>
                </li>
                <?php
                $readEstatisticas = new read();
                $readEstatisticas->ExeRead('siteviews', "ORDER BY data DESC LIMIT 7");
                if ($readEstatisticas->getResultado()):
                    foreach ($readEstatisticas->getResultado() as $resEst):
                        $i++;
                        $resC = ($resEst['pageviews'] / $resEst['usuarios'])
                        ?>
                        <li<?php if ($i % 2 == 0) echo ' class="color"'; ?>>
                            <span class="date"><strong><?= date('d-m-Y', strtotime($resEst['data'])) ?></strong></span>
                            <span class="views"><?= $resEst['visitas'] ?></span>
                            <span class="users"><?= $resEst['usuarios'] ?></span>
                            <span class="pages"><?= ceil($resC) ?></span>
                        </li>
                        <?php
                        //Somo os valores direto no loop, apenos dos sete primeiros.
                        $resVisitas += $resEst['visitas'];
                        $resUsusarios += $resEst['usuarios'];
                        $resPage += $resEst['pageviews'];
                    endforeach;
                    $pages = ($resPage / $resUsusarios);
                endif;
                ?>

                <li class="title">
                    <span class="date">TOTAL</span>
                    <span class="views">Visitas</span>
                    <span class="users">Usuários</span>
                    <span class="pages">PageViews</span>
                </li>
                <li>
                    <span class="date"><strong>7 DIAS</strong></span>
                    <span class="views"><?= $resVisitas ?></span>
                    <span class="users"><?= $resUsusarios ?></span>
                    <span class="pages"><?= ceil($pages) ?></span>
                </li>

            </ul><!--/relatorio-->

        </div><!--/content-->
    </div><!--/modaltrafego-->
    
    <!--img de load.-->
    <div class="loadsistema">
        <img src="img/loader.gif" title="Carregando..." alt="Carregando">
    </div>
    
    <!-- msg -->    
    <div class="ajaxmsg msg"></div><!-- msg -->

    <!-- NEW POST -->
    <div class="modal newpost">
        <h2>NOVO POST:</h2>
        <div class="content">
            <form name="cadnewpost" action="" method="post">
                <label>
                    <span>Selecione a categoria:</span>
                    <select name="sub_categoria"></select>
                </label>
                <label>
                    <span>Titulo do post:</span>
                    <input type="text" name="titulo" />
                </label>

                <input type="submit" value="Cadastrar" class="btn" />
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
            </form>

        </div><!--/content-->
        <a href="#" class="closemodal" id="newpost">X FECHAR</a>
    </div><!--/newpost-->


    <!-- NEW CAT -->
    <div class="modal newcat">
        <h2>NOVA CATEGORIA:</h2>
        <div class="content">
            <form name="cadnewcat" action="" method="post">
                <label>
                    <span>Sessão:</span>
                    <select name="cat_pai">
                        <!--Alimentado pelo ajax.-->
                    </select>
                </label>
                <label>
                    <span>Categoria:</span>
                    <input type="text" name="nome" />
                </label>

                <input type="submit" value="Cadastrar" class="btn" />
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
            </form>

        </div><!--/content-->
        <a href="#" class="closemodal" id="newcat">X FECHAR</a>
    </div><!--/newcat-->


    <!-- NEW USER -->
    <div class="modal newuser">
        <h2>CADASTAR USUÁRIO:</h2>
        <div class="content">
            <form name="cadnewuser" action="" method="post">
                <label>
                    <span>Nível:</span>
                    <select name="nivel">
                        <option value="2">Admin</option>
                        <option value="1">Super Admin</option>
                    </select>
                </label>
                <label>
                    <span>Nome:</span>
                    <input type="text" name="nome" />
                </label>

                <label>
                    <span>E-mail:</span>
                    <input type="email" name="email" />
                </label>

                <label>
                    <span>Senha:</span>
                    <input type="password" name="senha" />
                </label>

                <input type="submit" value="Cadastrar" class="btn" />
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
            </form>

        </div><!--/content-->
        <a href="#" class="closemodal j_closenewuser" id="newuser">X FECHAR</a>
    </div><!--/newuser-->

    <!--Modal para a edicao dos dados, sera passado pelo ajax.-->
    <div class="modal editnewuser" style="display: none"></div>
</div><!-- /dialog -->