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

    <div class="loadsistema">
        <img src="img/loader.gif" title="Carregando..." alt="Carregando">
    </div><!-- msg -->

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