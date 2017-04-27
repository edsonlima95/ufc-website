<?php
ob_flush();
session_start();
//Chama o arquivo da pasta dts config.
require '../../dts/configs.php';
//Auto load des classes.
require '../../vendor/autoload.php';

//Recebe os dados do envio post do ajax.
$dados = filter_input_array(INPUT_POST, FILTER_DEFAULT);

//Tipo de acões.
switch ($dados['acao']) {

    /*     * ***************************************
     * GESTÃO DE CONFIGURAÇÕES DO SITE
     * **************************************** */

    //Desativa a manutencao.
    case 'manutencao_desativa':
        unset($dados['acao']);
        //Seta o valor como zero ao entra nesse case, significa que estava ativo o status.
        $status = array("manutencao" => 0);
        $update = new update();
        //Se tiver 1 entao altera para 0
        $con = 1;
        $update->ExeUpdate('config_manutencao', $status, "WHERE manutencao = :m", "m={$con}");
        break;
    //Ativa a manutencao.
    case 'manutencao_ativa':
        unset($dados['acao']);
        //Seta o valor como zero ao entra nesse case, significa que estava ativo o status.
        $status = array("manutencao" => 1);
        $update = new update();
        //Se tiver 0 entao altera para 1
        $con = 0;
        $update->ExeUpdate('config_manutencao', $status, "WHERE manutencao = :m", "m={$con}");
        break;
    //Configuração de email
    case 'mailserver_atualiza':
        unset($dados['acao']);
        if (in_array('', $dados)):
            echo 'branco';
        elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)):
            echo 'ermail';
        else:
            $id = 1;
            $updateEmailServer = new update();
            $updateEmailServer->ExeUpdate('config_emailserver', $dados, "WHERE id = :id", "id=" . $id . "");
        endif;
        break;
    //Configuração de email, envia emails.
    case 'mailserver_testa':
        unset($dados['acao']);
        //Ler os dados do servidor de email no banco.
        $readEmailDados = new read();
        $readEmailDados->ExeRead('config_emailserver');
        $dadosEmail = $readEmailDados->getResultado()[0];

        //Seta os dados.
        $dados['assunto'] = "Teste de email server";
        $dados['mensagem_remetente'] = "Seu servidor de email foi configurado com sucesso sorte kkk" . date('d/m/Y H:i:s');
        $dados['email_remetente'] = $dadosEmail['email'];
        $dados['nome_remetente'] = SITENAME;
        $dados['nome_destino'] = SITENAME;
        $dados['email_destino'] = $dadosEmail['email'];

        $emailSender = new email();
        $emailSender->enviarEmail($dados);

        break;
    //Configuração de seo do site.
    case 'atualiza_seo':
        unset($dados['acao']);

        if (in_array('', $dados)):
            echo 'branco';
        else:
            $id = 1;
            $updateSeo = new update();
            $updateSeo->ExeUpdate('config_seosociais', $dados, "WHERE id = :id", "id=" . $id . "");
        endif;
        break;
    //Configuração de endereco.
    case 'atualiza_endereco':
        unset($dados['acao']);

        if (in_array('', $dados)):
            echo 'branco';
        else:
            $id = 1;
            $updateEndereco = new update();
            $updateEndereco->ExeUpdate('config_endereco', $dados, "WHERE id = :id", "id=" . $id . "");
        endif;
        break;

    /*     * ***************************************
     * GESTÃO DE USUARIOS DO SITE
     * **************************************** */
    case 'usuario_manager':
        unset($dados['acao']);

        if (in_array('', $dados)):
            echo 'campos_branco';
        elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)):
            echo 'ermail';
        else:
            $exe = $dados['exe']; //Recebe a acao
            //Verifica se o tipo e cadastro.
            if ($exe == 'cadastro'):
                unset($dados['exe']);
                //Verifica se ja existe um usuario com o mesmo email e senha.
                $readUser = new read();
                $readUser->ExeRead('users', 'WHERE email = :email OR senha = :senha', "email={$dados['email']}&senha={$dados['senha']}");
                $user = $readUser->getResultado()[0];
                if ($user):
                    echo 'userexiste';
                else:
                    //Seta os dados.
                    $dados['token'] = $dados['senha'];
                    $dados['data_creacao'] = date('Y-m-d H:i:s');

                    $createUser = new create();
                    $createUser->ExeCreate('users', $dados);

                endif;
            elseif ($exe == 'atualiza'):
                unset($dados['exe']);
                //id para ser atualizado, esse id veio do campo hidden do formulario de edição
                $iduser = $dados['id'];
                $readUserEdit = new read();
                //Verifica se o id e diferente, e o email e senha sao iguais a o de outro user.
                $readUserEdit->ExeRead('users', "WHERE id != :id AND (email = :email OR senha = :senha)", "id={$iduser}&email={$dados['email']}&senha={$dados['senha']}");
                $user2 = $readUserEdit->getResultado()[0];
                if ($user2):
                    echo 'userexiste';
                else:
                    //Seta os dados.
                    $dados['token'] = $dados['senha'];
                    $dados['data_creacao'] = date('Y-m-d H:i:s');
                    $updateUser = new update();
                    $updateUser->ExeUpdate('users', $dados, "WHERE id = :id", "id={$iduser}");
                endif;
            endif;
        endif;
        break;
    case 'usuarios_consulta';
        //Faz a consulta e retorna os dados setados no formulario, que sera enviado para o case usuario_manager.
        unset($dados['acao']);
        $iduser = $dados['userid'];
        $consultaUser = new read();
        $consultaUser->ExeRead('users', "WHERE id = :id", "id={$iduser}");
        $res = $consultaUser->getResultado()[0];
        extract($res);
        ?>
        <h2>ATUALIZA USUÁRIO:</h2>
        <div class="content">
            <form name="atualizanewuser" action="" method="post">
                <label>
                    <span>Nível:</span>
                    <select name="nivel">
                        <option value="2" <?php if ($res['nivel'] == 2) echo ' selected="selected"'; ?> >Admin</option>
                        <option value="1" <?php if ($res['nivel'] == 1) echo ' selected="selected"'; ?> >Super Admin</option>
                    </select>
                </label>
                <label>
                    <span>Nome:</span>
                    <input type="text" name="nome" value="<?php if (isset($nome)) echo $nome; ?>" />
                </label>

                <label>
                    <span>E-mail:</span>
                    <input type="email" name="email" value="<?php if (isset($email)) echo $email; ?>" />
                </label>

                <label>
                    <span>Senha:</span>
                    <input type="password" name="senha" value="<?php if (isset($senha)) echo $senha; ?>" />
                </label>
                <input type="hidden" name="id" value="<?= $id ?>">
                <input type="submit" value="Atualizar" class="btn" />
                <img src="img/loader.gif" class="load" alt="Carregando..." title="Carregando..." />
            </form>

        </div><!--/content-->
        <a href="#" class="closemodal j_closemodaledit">X FECHAR</a>
        <?php
        break;
    case 'usuarios_delete';
        unset($dados['acao']);
        //Id para ser deletado.
        $iduserdel = $dados['deluser'];

        //Ler os usuarios.
        $readUserDelete = new read();
        $readUserDelete->ExeRead('users', "WHERE id = :id", "id={$iduserdel}");
        $nivel = $readUserDelete->getResultado()[0]['nivel'];

        if ($_SESSION['user']['id'] == $iduserdel):
            echo 'prorioPerfil';
        elseif ($nivel == 1):
            echo 'superuser';
        else:
            //Deleta
            $delete = new delete();
            $delete->ExeDelete('users', "WHERE id = :id", "id={$iduserdel}");

        endif;

        break;
        
    case 'cadastro_temas';
        unset($dados['acao']);
        if(in_array('',$dados)):
            echo 'campos_branco_tema';
        else:
        //Cadastra os dados.
        $dados['data_creacao'] = date('Y-m-d H:i:s');
        $create = new create();
        $create->ExeCreate('config_tema', $dados);
        endif;
       
    break;
    
    case 'ler_temas';
        unset($dados['acao']);
             //Ler a tabela de configuração de endereço.
            $readTemas = new read();
            $readTemas->ExeRead('config_tema',"ORDER BY data_creacao DESC");
            
            if($readTemas->getResultado()):
                echo '<tr class="titulo">
                          <th>Tema:</th>
                          <th>Pasta:</th>
                          <th>Data:</th>
                          <th>Ação</th>
                    </tr>';
                foreach ($readTemas->getResultado() as $resTema):
                    
                //Pasta
                $pasta = '../../temas/'.$resTema['pasta'];
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
            endif;
    break;
    
    case 'ativa_tema';
        unset($dados['acao']);
        
        $reseta = array("inuse" => 0);
        //Desativa o tea
        $updateTemaUso = new update();
        $updateTemaUso->ExeUpdate('config_tema', $reseta,"WHERE inuse = :uso","uso=1");
        
        //Ativa o tema.
        $ativa = array("inuse" => 1);
        $updateAtiva = clone $updateTemaUso;
        $updateAtiva->ExeUpdate('config_tema', $ativa,"WHERE id = :id","id={$dados['id']}");

        break;
    
    case 'deleta_tema';
        unset($dados['acao']);
            //id tema.
            $idtema = $dados['id'];
            
            //Ler o tema referente ao id.
            $readTema = new read();
            $readTema->ExeRead('config_tema',"WHERE id = :id","id={$idtema}");
            if($readTema->getResultado()):
                if($readTema->getResultado()[0]['inuse']):
                    echo 'erroractive';
                else:
                   $deltema = new delete();
                   $deltema->ExeDelete('config_tema',"WHERE id = :id","id={$idtema}");
                endif;
            endif;
        break;

    /*     * ***************************************
     * GESTÃO DE CATEGORIAS DO SITE
     * **************************************** */
    case 'cadastro_categoria':
        unset($dados['acao']);

        //Nome da categoria.
        $nome = $dados['nome'];

        if (empty($dados['nome'])):
            echo 'campos_branco';
        else:
            $readCatExiste = new read();
            $readCatExiste->ExeRead('categorias', "WHERE nome = :nome", "nome={$nome}");
            if ($readCatExiste->getResultado()):
                echo 'catexiste';
            else:
                //Se tiver o id sera uma categoria se não sera uma sub.
                $dados['cat_pai'] = (!empty($dados['cat_pai']) ? $dados['cat_pai'] : null);

                //Seta dada
                $dados['data_creacao'] = date('Y-m-d H:i:s');
                $dados['url'] = funcoes::Name($nome);

                //Cadastra no banco.
                $createCat = new create();
                $createCat->ExeCreate('categorias', $dados);

                //Retorna ultimo id inserido.
                echo $createCat->getResultado();
            endif;
        endif;

        break;

    case 'select_categoria';
        echo '<option value="" selected></option>';
        //Ler as categorias pai.
        $readCatPai = new read();
        $readCatPai->ExeRead('categorias', "WHERE cat_pai IS NULL");
        if ($readCatPai->getResultado()):
            foreach ($readCatPai->getResultado() as $resCatPai):
                echo '<option value="' . $resCatPai['id'] . '">' . $resCatPai['nome'] . '</option>';
                //Ler as sub-categorias filhas.
                $readCatSub = new read();
                $readCatSub->ExeRead('categorias', "WHERE cat_pai = :idcat", "idcat={$resCatPai['id']}");
                if ($readCatSub->getResultado()):
                    foreach ($readCatSub->getResultado() as $resCatSub):
                        echo '<option disabled value="' . $resCatSub['id'] . '">' . $resCatSub['nome'] . '</option>';
                    endforeach;
                endif;
            endforeach;
        endif;
        break;

    case 'categoria_update';
        unset($dados['acao']);
        $img = ($_FILES['capa']['tmp_name'] ? $_FILES['capa'] : null);

        //Recebe o id pelo campo hidenn.
        $id = $dados['id'];
        
         $dados['data_creacao'] = funcoes::validaData($dados['data_creacao']);
         $dados['url'] = funcoes::Name($dados['nome']);

        if ($img != null):
            //Verifica a se a imagem existe pega o caminho e deleta da pasta.
            $readCapa = new read();
            $readCapa->ExeRead('categorias', "WHERE id = :id", "id={$id}");
            $capa = '../../uploads/' . $readCapa->getResultado()[0]['capa'];

            if (file_exists($capa) && !is_dir($capa)):
                unlink($capa);
            endif;

            //Atualiza a nova imagem.
            $uploadImagem = new files('../../uploads/');
            //esse time(), e pq ao ser atualizada a capa pelo ajax, o cach da antiga imagem continua e a miniatura nao mudava para a nova
            //Com o time ele garante que a img nao sera repetida e o cach sera atualizado, obs: so e preciso se for atualiza pelo ajax.
            $uploadImagem->enviarImagem($img, funcoes::Name($dados['nome'] . '-' . time()),0,'categorias');

            //Retorna o tipo de error, vindo do files.
            echo $uploadImagem->getErro();
        endif;
        //Se enviar a imagen
        if (isset($uploadImagem) && $uploadImagem->getResultado()):
            //Seta o caminho
            $dados['capa'] = funcoes::Name($uploadImagem->getResultado());
           
            //Atualiza os dados.
            $updateCat = new update();
            $updateCat->ExeUpdate('categorias', $dados, "WHERE id = :id", "id={$id}");
            //Retorna o caminho da imagem.
            echo $uploadImagem->getResultado();
        else:
            //Apenas atualiza os dados.
            unset($dados['capa']);
            
            //Atualiza os dados.
            $updateCat = new update();
            $updateCat->ExeUpdate('categorias', $dados, "WHERE id = :id", "id={$id}");
        endif;

        break;

    case 'categoria_delete':
        unset($dados['acao']);

        //id da categoria.
        $idcat = $dados['delcat'];

        $readCat = new read();
        $readCat->ExeRead('categorias', "WHERE cat_pai = :id ", "id={$idcat}");

        $readSubPost = new read();
        $readSubPost->ExeRead('posts', "WHERE sub_categoria = :idsub", "idsub={$idcat}");

        if ($readCat->getResultado()):
            echo 'contemsub';
        elseif ($readSubPost->getRowCount()):
            echo 'contempost';
        else:
            //Verifica a se a imagem existe pega o caminho e deleta da pasta.
            $readCapa = new read();
            $readCapa->ExeRead('categorias', "WHERE id = :id", "id={$idcat}");
            $capa = '../../uploads/' . $readCapa->getResultado()[0]['capa'];
            if (file_exists($capa) && !is_dir($capa)):
                unlink($capa);
            endif;
            $deletcat = new delete();
            $deletcat->ExeDelete('categorias', "WHERE id = :id", "id={$idcat}");
        endif;

        break;

    case 'select_categoria_posts';
        echo '<option value="" selected></option>';
        //Ler as categorias pai.
        $readCatPai = new read();
        $readCatPai->ExeRead('categorias', "WHERE cat_pai IS NULL");
        if ($readCatPai->getResultado()):
            foreach ($readCatPai->getResultado() as $resCatPai):
                echo '<option disabled value="' . $resCatPai['id'] . '">' . $resCatPai['nome'] . '</option>';
                //Ler as sub-categorias filhas.
                $readCatSub = new read();
                $readCatSub->ExeRead('categorias', "WHERE cat_pai = :idcat", "idcat={$resCatPai['id']}");
                if ($readCatSub->getResultado()):
                    foreach ($readCatSub->getResultado() as $resCatSub):
                        echo '<option value="' . $resCatSub['id'] . '">' . $resCatSub['nome'] . '</option>';
                    endforeach;
                endif;
            endforeach;
        endif;
        break;

    /*****************************************
     * GESTÃO DE POSTS DO SITE cadastro_posts
     * **************************************** */

    case 'cadastro_posts':
        unset($dados['acao']);

        if (in_array('', $dados)):
            echo 'campos_branco';
        else:
            //Seta dada
            $dados['data_creacao'] = date('Y-m-d H:i:s');
            $idsub = $dados['sub_categoria'];
            $readCatPost = new read();
            $readCatPost->ExeRead('categorias', "WHERE id = :id", "id={$idsub}");

            //Id da categoria.
            $dados['categoria'] = $readCatPost->getResultado()[0]['cat_pai'];

            //Cadastra no banco.
            $createCat = new create();
            $createCat->ExeCreate('posts', $dados);

            //Retorna ultimo id inserido.
            echo $createCat->getResultado();
        endif;

        break;

    case 'post_update';
        sleep(1); //Ta dando um conflito, progresso do modal load.
        unset($dados['acao']);
      
        //Seta dados
        $dados['status'] = (!empty($dados['status']) ? $dados['status'] : 0);
        //htmlspecialchars_decode, tira todos os caracteris especiais passado pelo tinnymce.
        $dados['conteudo'] = strip_tags(trim(htmlspecialchars_decode($dados['conteudo'])));
        //Seta dada
        $dados['data_creacao'] = funcoes::validaData($dados['data_creacao']);
        //Url 
        $dados['nome'] = funcoes::Name($dados['titulo']);
        //id do post
        $idpost = $dados['id'];

        //Ler a categoria de acordo com a sub.
        $idsub = $dados['sub_categoria'];
        $readCatPost = new read();
        $readCatPost->ExeRead('categorias', "WHERE id = :id", "id={$idsub}");
        //Id da categoria.
        $dados['categoria'] = $readCatPost->getResultado()[0]['cat_pai'];

        //ENVIO DA CAPA
        $img = ($_FILES['capa']['tmp_name'] ? $_FILES['capa'] : '');

        if ($img != ''):
            //Verifica a se a imagem existe pega o caminho e deleta da pasta.
            $readCapa = new read();
            $readCapa->ExeRead('posts', "WHERE id = :id", "id={$idpost}");
            $capa = '../../uploads/' . $readCapa->getResultado()[0]['capa'];

            if (file_exists($capa) && !is_dir($capa)):
                unlink($capa);
            endif;

            //Atualiza a nova imagem.
            $uploadImagem = new files('../../uploads/');
            $uploadImagem->enviarImagem($img, $idpost . '-' . time(), 0, 'posts');

            //Retorna o tipo de error, vindo do files.
            $dados['capa'] = $uploadImagem->getResultado();
        else:
            unset($dados['capa']);
        endif;

        //ENVIO DA GALERIA.
        $gb = ($_FILES['gb']['tmp_name'] ? $_FILES['gb'] : null);

        if (isset($gb['tmp_name'])):
            $galeria = new galeria();
            $galeria->enviarGaleria($gb, $idpost);
        endif;
        unset($dados['gb']);

        //Atualiza os dados.
        $updaPost = new update();
        $updaPost->ExeUpdate('posts', $dados, "WHERE id = :id", "id={$idpost}");
        break;
    case 'post_del_galeri':
        $idgal = $dados['delimg'];
        $galeriaDel = new galeria();
        $galeriaDel->deleteGaleria($idgal);
        break;

    case'post_delete':
        unset($dados['acao']);
        //id do post.        
        $idpostdel = $dados['delpost'];

        //Deleta a galeria.
        $delGaleria = new galeria();
        $delGaleria->deleteGaleria($idpostdel);

        //Deleta a capa do post.
        $readCapa = new read();
        $readCapa->ExeRead('posts', "WHERE id = :id", "id={$idpostdel}");
        $capa = '../../uploads/' . $readCapa->getResultado()[0]['capa'];
        if (file_exists($capa) && !is_dir($capa)):
            unlink($capa);
        endif;

        //Deleta os camentarios.
        $delComents = new delete();
        $delComents->ExeDelete('comentarios', "WHERE id_post = :id", "id={$idpostdel}");

        //Delera o post.
        $delComents = new delete();
        $delComents->ExeDelete('posts', "WHERE id = :id", "id={$idpostdel}");

        break;
        
    case 'relatorio';
        unset($dados['acao']);
        //Data de incio da busca.
        $inicio = explode('/', $dados['inicio']);
        $inicio = $inicio['2'] . '-' . $inicio['1'] . '-' . $inicio['0'];

        //Data de final da busca.
        $final = explode('/', $dados['final']);
        $final = $final['2'] . '-' . $final['1'] . '-' . $final['0'];

        if (in_array('', $dados)):
            echo 'campos_branco';
        else:
            //Faz a leitura.
            $readRelatorio = new read();
            $readRelatorio->ExeRead('siteviews', "WHERE data >= :inicio AND data <= :final", "inicio={$inicio}&final={$final}");
            if ($readRelatorio->getResultado()):
                echo'<li class="title">
                <span class="date">Dia</span>
                <span class="views">Visitas</span>
                <span class="users">Usuários</span>
                <span class="pages">PageViews</span>
            </li>';
                if ($readRelatorio->getResultado()):
                    foreach ($readRelatorio->getResultado() as $resEstH):
                        $i++;
                        $resH = ($resEstH['pageviews'] / $resEstH['usuarios']);
                        /**/
                        echo'<li';
                        if ($i % 2 == 0) echo ' class="color"';
                        echo'>';
                        echo'<span class="date"><strong>' . date('d-m-Y', strtotime($resEstH['data'])) . '</strong></span>';
                        echo'<span class="views">' . $resEstH['visitas'] . '</span>';
                        echo'<span class="users">' . $resEstH['usuarios'] . '</span>';
                        echo'<span class="pages">' . ceil($resH) . '</span>';
                        echo '</li>';

                        //Somo os valores direto no loop, apenos dos sete primeiros.
                        $resVisitasH += $resEstH['visitas'];
                        $resUsusariosH += $resEstH['usuarios'];
                        $resPageH += $resEstH['pageviews'];
                    endforeach;
                    $pagesH = ($resPageH / $resUsusariosH);
                endif;

                echo '<li class="title">
                <span class="date">TOTAL</span>
                    <span class="views">Visitas</span>
                    <span class="users">Usuários</span>
                    <span class="pages">PageViews</span>
                </li>
                <li>
                    <span class="date"><strong>'.$readRelatorio->getRowCount().' DIAS</strong></span>
                    <span class="views">' . $resVisitasH . '</span>
                    <span class="users">' . $resUsusariosH . '</span>
                    <span class="pages">' . ceil($pagesH) . '</span>
                </li>';
            else:
                echo 'notfound';
            endif;
        endif;
        break;

    //Default caso não aja case.
    default:
        echo 'Error';
        break;
}
ob_end_flush();
?>