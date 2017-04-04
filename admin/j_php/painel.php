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
    case 'manutencao_ativa':
        unset($dados['acao']);
        //Seta o valor como zero ao entra nesse case, significa que estava ativo o status.
        $status = array("manutencao" => 1);
        $update = new update();
        //Se tiver 0 entao altera para 1
        $con = 0;
        $update->ExeUpdate('config_manutencao', $status, "WHERE manutencao = :m", "m={$con}");
        break;
    case 'mailserver_atualiza':
        unset($dados['acao']);
        if (in_array('', $dados)):
            echo 'branco';
        elseif (!filter_var($dados['email'], FILTER_VALIDATE_EMAIL)):
            echo 'ermail';
        else:
            $id = 1;
            $updateEmailServer = new update();
            $updateEmailServer->ExeUpdate('config_emailserver',$dados,"WHERE id = :id","id=".$id."");
        endif;
        break;
        
    case 'mailserver_testa':
        unset($dados['acao']);
        //Ler os dados do servidor de email no banco.
        $readEmailDados = new read();
        $readEmailDados->ExeRead('config_emailserver');
        $dadosEmail = $readEmailDados->getResultado()[0];
        
        //Seta os dados.
        $dados['assunto'] = "Teste de email server";
        $dados['mensagem_remetente'] = "Seu servidor de email foi configurado com sucesso sorte kkk". date('d/m/Y H:i:s');
        $dados['email_remetente'] = $dadosEmail['email'];
        $dados['nome_remetente'] = SITENAME;
        $dados['nome_destino'] = SITENAME;
        $dados['email_destino'] = $dadosEmail['email'];
        
        $emailSender = new email();
        $emailSender->enviarEmail($dados);
        
        break;
    case 'atualiza_seo':
        unset($dados['acao']);
        
        if(in_array('',$dados)):
            echo 'branco';
        else:
            $id = 1;
            $updateSeo = new update();
            $updateSeo->ExeUpdate('config_seosociais',$dados,"WHERE id = :id","id=".$id."");
        endif;
        break;
    case 'atualiza_endereco':
        unset($dados['acao']);
        
        if(in_array('',$dados)):
            echo 'branco';
        else:
            $id = 1;
            $updateEndereco = new update();
            $updateEndereco->ExeUpdate('config_endereco',$dados,"WHERE id = :id","id=".$id."");
        endif;
        break;
    default:
        echo 'Error';
        break;
}
ob_end_flush();
