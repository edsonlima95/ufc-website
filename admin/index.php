<?php
ob_flush(); //Abri o fluxo.
require '../vendor/autoload.php';
//Inclue os arquivos.
require '../dts/configs.php';

?>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <title>LOGIN | Curso Pro jQuery - Criando Interfaces</title>
        <meta name="robots" content="noindex, nofollow" />

        <link rel="stylesheet" type="text/css" href="css/login.css" />
        <link href='http://fonts.googleapis.com/css?family=Dosis:200;400,600,800' rel='stylesheet' type='text/css'>
            <link rel="icon" type="image/png" href="../tpl/images/upico.png"/>
            <script type="text/javascript" src="../jsc/jquery.js"></script>
            <script type="text/javascript" src="jsc/login.js"></script>
    </head>
    <body>
        <?php
        //Verifica se a sessao existe se sim sempre ira redirecionar para o painel.
        $login = new Logar();
        if ($login->checkSession()):
            header('Location: dashboard.php');
        endif;
        ?>
        <div class="loginbox" style="display: none">
            <h1>Efetuar Login: <img src="img/loader.gif" alt="Carregando" title="Carregando" /></h1>
            <form name="login" action="" method="post">
                <label class="label">
                    <span class="field">Usuário:</span>
                    <input type="text" name="user" />
                </label>

                <div class="label">
                    <span class="field">Senha:</span>
                    <input type="password" name="pass" class="pass" />
                    <input type="submit" value="Logar-se" class="btn" />
                </div>        
            </form>

            <?php
            //Verifica se é um logoff do sistema ou se o usuario nao tem permissão
            if (isset($_GET['action']) == 'sair'):
                echo '<div class="msg" style="display:block"><p class="sucesso"><strong>Você deslogou com sucesso!</strong></p></div>';
            elseif (isset($_GET['exe']) == 'restrito'):
                echo '<div class="msg" style="display:block"><p class="erro"><strong>Painel restrito!</strong></p></div>';
            endif;
            ?>
            <div class="msg"></div><!--/msg-->
        </div><!--/login-box-->
        <a class="backsite" href="../" title="Voltar ao site">voltar ao site</a>
    </body>
</html>
<?php
ob_end_flush();
?>