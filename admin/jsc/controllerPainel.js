//Ler todo o documento e depois retira o fundo preto, com o carregando.
$(window).ready(function () {
    $('.loadsistema').fadeOut('slow', function () {
        $('.dialog').fadeOut('fast');
    });
});

$(function () {
    //CUSTOM
    /*$('.controle .li').mouseenter(function () {
     $(this).find('.submenu').slideDown("fast");
     }).mouseleave(function () {
     $(this).find('.submenu').slideUp("fast");
     });
     
     $('.dialog').hide();
     $('.dialog .msg').hide();
     $('.dialog .modal').hide();
     
     $('.closemodal, .closedial').click(function () {
     $('.dialog').find('div').fadeOut("slow", function () {
     $('.dialog').fadeOut("slow");
     });
     
     return false;
     });
     
     
     $('.posts .content .li span').hide();
     $('.posts .content .li').each(function () {
     $(this).mouseover(function () {
     $(this).find('span').fadeIn("fast");
     }).mouseleave(function () {
     $(this).find('span').fadeOut("fast");
     });
     });
     
     $('.j_addpost').click(function () {
     $('.dialog').fadeIn("fast", function () {
     $('.newpost').find('div').fadeIn("fast").find('img').hide(0, function () {
     $('.newpost').fadeIn("fast");
     });
     });
     return false;
     });
     
     $('form[name="cadnewpost"]').submit(function () {
     $('.newpost').find('img').fadeIn('fast', function () {
     var id = '22';
     window.setTimeout(function () {
     $(location).attr('href', 'dashboard.php?exe=posts/edit&id=' + id);
     }, 2000);
     });
     return false;
     });
     
     $('.j_send').click(function () {
     $('.j_capa').one('click', function () {
     $(this).click();
     }).change(function () {
     $('.viewcapa').fadeOut("slow", function () {
     $('.j_false').text($('.j_capa').val().replace('C:\\fakepath\\', ""));
     });
     });
     });
     
     $('.j_gsend').click(function () {
     $('.j_gallery').one('click', function () {
     $(this).click();
     }).change(function () {
     $('.j_gprogress').animate({width: '880px'}, 500, function () {
     $(this).find('.bar').text('100%').css('max-width', '864px').animate({width: '100%'}, 3500);
     });
     });
     });
     
     $('.formfull .check').click(function () {
     if ($(this).find('input').is(':checked')) {
     $(this).css('background', '#0C0');
     } else {
     $(this).css('background', '#999');
     }
     ;
     });
     if ($('.formfull .check input').is(':checked')) {
     $('.formfull .check').css('background', '#0C0');
     } else {
     $('.formfull .check').css('background', '#999');
     }
     ;
     
     
     $('.j_addcat').click(function () {
     $('.dialog').fadeIn("fast", function () {
     $('.newcat').find('div').fadeIn("fast").find('img').hide(0, function () {
     $('.newcat').fadeIn("fast");
     });
     });
     
     return false;
     });
     
     $('form[name="cadnewcat"]').submit(function () {
     $('.newcat').find('img').fadeIn('fast', function () {
     var id = '18';
     window.setTimeout(function () {
     $(location).attr('href', 'dashboard.php?exe=categorias/edit&id=' + id);
     }, 2000);
     });
     return false;
     });
     
     $('.comentarios .listcom .li .commentitem .actions').hide();
     $('.comentarios .listcom .li').each(function () {
     $(this).mouseover(function () {
     $(this).find('.actions').fadeIn("fast");
     }).mouseleave(function () {
     $(this).find('.actions').fadeOut("fast");
     });
     });
     
     //BACK
     $('a[href="#back"]').each(function () {
     $(this).click(function () {
     window.history.back();
     });
     });
     
     
     $('.j_adduser').click(function () {
     $('.dialog').fadeIn("fast", function () {
     $('.newuser').find('div').fadeIn("fast").find('img').hide(0, function () {
     $('.newuser').fadeIn("fast");
     });
     });
     return false;
     });
     
     $('form[name="cadnewuser"]').submit(function () {
     $('.newuser').find('img').fadeIn('fast', function () {
     
     });
     return false;
     });*/

    //EFEITO DO MENU E SUB-MENU.
    $('.controle .li').mouseover(function () {
        $(this).find('.submenu').slideDown();
    }).mouseleave(function () {
        $(this).find('.submenu').slideUp();
    });

    //EFEITO DOS MODAIS
    //Efeito de abrir a modal de criar post.
    $('.j_addpost').click(function () {
        //Abri o funco escuro.
        $('.dialog').fadeIn('fast', function () {
            $('.newpost').fadeIn('slow');
        });
        return false;
    });

    //FECHA O MODAL.
    //Fecha o modal de acordo com o id, pois tem varios modais diferentes.
    $('.closemodal').click(function () {
        $('.newpost').fadeOut('slow', function () {
            $('.dialog').fadeOut('fast');
        });
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

    //Envio dos form. primeira aba a de manutencao.
    //Remove o evento de submit do form.
    $('form[name="config_manutencao"]').submit(function () {
        return false;
    });

    //O status ja vem ativo, entao ao clicar eu vou desativar por isso so tem uma acao enviada para o case.
    $('.j_config_manutencao_no').click(function () {
        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: "acao=manutencao_desativa",
            beforeSend: function () {
                //Exibe a imagem carregando.
                $('.configs form .main .load').fadeIn('fast');
            },
            complete: function () {
                //Apos a imagem carregando sumir, alterna os botoes.
                $('.configs form .main .load').fadeOut('fast', function () {
                    //Alterna os botoes.
                    $('.j_desativa').fadeOut('slow', function () {
                        $('.j_ativo').fadeIn('slow');
                    });
                });
            }
        });
    });
    //Ativa a manutencao novamente.
    $('.j_config_manutencao_yes').click(function () {
        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: "acao=manutencao_ativa",
            beforeSend: function () {
                //Exibe a imagem carregando.
                $('.configs form .main .load').fadeIn('fast');
            },
            complete: function () {
                //Apos a imagem carregando sumir, alterna os botoes.
                $('.configs form .main .load').fadeOut('fast', function () {
                    //Alterna os botoes.
                    $('.j_ativo').fadeOut('slow', function () {
                        $('.j_desativa').fadeIn('slow');
                    });
                });
            }
        });

    });


});
