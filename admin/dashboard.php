<?php
ob_start();
require '../vendor/autoload.php';
$readSeo = new read();
$readSeo->ExeRead('config_seosociais');

$seo = $readSeo->getResultado()[0];

//Clona  objeto.
$endereco = clone $readSeo;
$endereco->ExeRead('config_endereco');

$ende = $endereco->getResultado()[0];

//Configurações do SEO
define('SITENAME',$seo['titulo']);
define('SITEDESC',$seo['descricao']);
define('SITEFACE',$seo['facebook']);
define('SITETWITTER',$seo['twitter']);
define('ENDERECO',$ende['endereco']);
define('TELEFONE',$ende['telefone']);

$login = new Logar();

//Se não existir a sessao, retorna para o login.
if(!$login->checkSession()):
    unset($_SESSION['user']);
    header('Location: index.php?exe=restrito');
endif;

//Todo conteudo do admin.
require_once('inc/header.php');
   
    echo '<div id="site">';
        //Recebe o arquivo da url.
        $exe = filter_input(INPUT_GET,'exe',FILTER_DEFAULT);
        //Efetua o logoff.
        if($exe == 'logoff'):
             unset($_SESSION['user']);
             header('Location: index.php?action=sair');
        endif;
       
        //Front crontol
	funcoes::frontController($exe);
    echo '</div><!-- /site -->';

require_once('inc/footer.php');
ob_end_flush();
?>