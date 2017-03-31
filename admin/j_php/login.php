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
    case 'login':
        unset($dados['acao']);
        //Instancia a classe login.
        $login = new Logar();

        //Metodo login, para a verificacao
        $login->login($dados['user'], $dados['pass']);

        //Verifica se existe o usuario, e da um eco no tipo de error retornado pela classe.
        if ($login->getResultado()):
            echo $login->getErro();
        else:
            echo $login->getErro();
        endif;
        break;
    default:
        echo 'Error';
        break;
}
ob_end_flush();
