$(function () {
    /*****************************************
     * LOGIN DO ADMIN...
     ****************************************/

    $('form').submit(function () {
        //Recebe todos os campos do formulario de login, e concatena com a acao para o case.
        var dados = $(this).serialize() + "&acao=login";

        //Envia os dados.
        $.ajax({
            url: "j_php/login.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Exibe a imagem de carregando.
                $('.loginbox h1 img').fadeIn('fast');
            },
            error: function () {
                alert('Error');
            },
            success: function (res) {
                //Os numeros são de acordo com o tipo de erro que e retornado da classe logar.
                if (res == 1) {
                    $('.msg').empty().html('<p class="erro">Opa amigo você esqueceu algum campo!</p>').fadeIn('slow');
                } else if (res == 2) {
                    $('.msg').empty().html('<p class="aviso">Senha ou email estão incorretos, verifique sua senha ou email!</p>').fadeIn('slow');
                } else if (res == 3) {
                    $('.msg').empty().html('<p class="aviso">Você não tem permissão para logar no painel!</p>').fadeIn('slow');
                } else {
                    //Atrasa um tempo antes de redirecionar.
                    window.setTimeout(function () {
                        //Redireciona para o painel.  
                        $(location).attr('href', 'dashboard.php');
                    }, 1000);
                }
            },
            complete: function () {
                //Exibe a imagem de carregando.
                $('.loginbox h1 img').fadeOut('slow');
            }
        });

        return false;
    });

});