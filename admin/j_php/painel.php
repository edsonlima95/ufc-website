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
    default:
        echo '';
        break;
}
ob_end_flush();
