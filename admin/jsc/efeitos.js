$(function () {

    //EFEITO DO MENU E SUB-MENU.
    $('.controle .li').mouseover(function () {
        $(this).find('.submenu').slideDown();
    }).mouseleave(function () {
        $(this).find('.submenu').slideUp();
    });

    //EFEITO DE PLACEHOLDER.
    $('.j_placeholder').each(function () {
        var placeh = $(this).attr('title');
        $(this).val(placeh).focus(function () {
            if ($(this).val() == placeh) {
                $(this).val('');
            }
        }).blur(function () {
            if ($(this).val() == '') {
                $(this).val(placeh);
            }
        });
    });

    //EFEITO DOS MODAIS
    //Efeito de abrir a modal de criar categorias.
    $('.j_addcat').click(function () {
        //Abri o funco escuro.
        $('.dialog').fadeIn('fast', function () {
            $('.newcat').fadeIn('slow');
        });
        return false;
    });

    //Efeito de abrir a modal de criar post.
    $('.j_addpost').click(function () {
        //Abri o funco escuro.
        $('.dialog').fadeIn('fast', function () {
            $('.newpost').fadeIn('slow');
        });
        return false;
    });

    //FECHA OS MODAIS.
    //Recebe o valor do id que esta no fecha e fecha o modal de acordo com a classe que tiver o mesmo nome do id.
    $('.closemodal').click(function () {
        var iddomodal = $(this).attr('id');
        $('.' + iddomodal).fadeOut('slow', function () {
            $('.dialog').fadeOut('fast');
        });
        return false;
    });

    //FECHA AS MENSAGEM.
    $('.ajaxmsg').on('click', '.j_ajaxclose', function () {
        var iddomodal = $(this).attr('id');
        $('.' + iddomodal).fadeOut('slow', function () {
            $('.dialog').fadeOut('fast');
            //Reseta a clase.
            $(this).attr('class', 'ajaxmsg msg');
        });
        return false;
    });

    //EFEITO DOS FORMS EM CONFIGURAÇÕES.
    //Configurações, apresentações dos formularios navegação em abas.
    $('.configs .abas_config li a').click(function () {
        //Adiciona a class active primeiro tem que remover antes de adicionar.
        $('.configs .abas_config li a').removeClass('active');
        $(this).addClass('active');

        //Pega o valor do atributo href, para identificar qual form sera exibido.
        var formgo = $(this).attr('href');
        //Esconde todos os formularios com nome diferente da variavel e depois mostra o clicado
        //O formulario manutencao sempre sera visivel mais ao clicar em outro ele sera oculto.
        $('.configs form[name!=' + formgo + ']').fadeOut('slow', function () {
            //Agora mostra o form clicado, ou seja que o name dele seja igual o da varivel.
            $('.configs form[name=' + formgo + ']').fadeIn('slow');
        });
        return false;
    });

});