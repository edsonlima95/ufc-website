<?php
ob_start();
session_start();
require '../vendor/autoload.php';

$login = new Logar();

//Se não existir a sessao, retorna para o login.
if(!$login->checkSession()):
    unset($_SESSION['user']);
    header('Location: index.php');
endif;

require_once('inc/header.php');
   
    echo '<div id="site">';
        //Recebe o arquivo da url.
        $exe = filter_input(INPUT_GET,'exe',FILTER_DEFAULT);
        //Front crontol
	funcoes::frontController($exe);
    echo '</div><!-- /site -->';

require_once('inc/footer.php');
ob_end_flush();
?>