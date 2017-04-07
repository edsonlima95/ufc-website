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
    //Cadastro de usuarios.
    case 'usuario_manager':
        unset($dados['acao']);
    
        if (in_array('', $dados)):
            echo 'campos_branco';
        elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)):
            echo 'ermail';
        else:
            $exe = $dados['exe'];//Recebe a acao
            //Verifica se o tipo e cadastro.
            if ($exe == 'cadastro'):
                unset($dados['exe']);
                //Verifica se ja existe um usuario com o mesmo email e senha.
                $readUser = new read();
                $readUser->ExeRead('users', 'WHERE email = :email OR senha = :senha', "email={$dados['email']}&senha={$dados['senha']}");
                $user = $readUser->getResultado()[0];
                if($user):
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
                if($user2):
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
        $readUserDelete->ExeRead('users',"WHERE id = :id","id={$iduserdel}");
        $nivel = $readUserDelete->getResultado()[0]['nivel'];
        
        if($_SESSION['user']['id'] == $iduserdel):
            echo 'prorioPerfil';
        elseif ($nivel == 1):
            echo 'superuser';
        else:
        //Deleta
        $delete = new delete();
        $delete->ExeDelete('users',"WHERE id = :id","id={$iduserdel}");
        
        endif;
        
        break;
        case 'cadastro_categoria':
        unset($dados['acao']);
            
        //Nome da categoria.
        $nome = $dados['nome'];
    
        if (empty($dados['nome'])):
            echo 'campos_branco';
        else:
            $readCatExiste = new read();
            $readCatExiste->ExeRead('categorias',"WHERE nome = :nome","nome={$nome}");
            if($readCatExiste->getResultado()):
                echo 'catexiste';
            else:
                //Se tiver o id sera uma categoria se não sera uma sub.
                $dados['cat_pai'] = (!empty($dados['cat_pai']) ? $dados['cat_pai'] : null);
                
                //Seta dada
                $dados['data_creacao'] = date('Y-m-d H:i:s');
                $dados['url'] = funcoes::Name($nome);
                
                //Cadastra no banco.
                $createCat = new create();
                $createCat->ExeCreate('categorias',$dados);
                
                //Retorna ultimo id inserido.
                echo $createCat->getResultado();
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