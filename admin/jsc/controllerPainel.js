//Carrega toda a pagina e depois retira o fundo preto, com o carregando.
$(window).ready(function () {
    $('.loadsistema').fadeOut('slow', function () {
        $('.dialog').fadeOut('fast');
    });
});

$(function () {
    
    
    /***********************************
     *CONFIGURAÇÕES DO SITE
     ***********************************/
    
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

    //CONFIGURACAO DO EMAIL-SERVER.
    $('form[name="config_email"]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=mailserver_atualiza';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                if (res == 'branco') {
                    msg('branco_campos_mailserver', 'alert', 'Preencha todos os campos antes de atualizar os dados!');
                } else if (res == 'ermail') {
                    msg('tipo_email_mailserver', 'error', 'Insira um email valido!');
                } else {
                    msg('sucesso_mailserver', 'accept', 'Dados atualizados com sucesso!');
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }

        });
        return false;
    });

    //Email Testa envio.
    $('.j_config_email_teste').click(function () {
        //Encapsula o formulario e os dados.
        var form = $('form[name="config_email"]');

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: 'acao=mailserver_testa',
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                //Verifica a existencia da palavra error.
                if (res) {
                    msg('testa_enviado_mailserver', 'accept', 'E-mail enviado com sucesso, verifique seu email' + res);
                } else if (res == 2) {
                    msg('testa_error_mailserver', 'error', 'Error ao enviar o email, por favot verifique os dados do formulario');
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }

        });
        return false;
    });

    //CONFIGURAÇÃO DE SEO DO SITE.
    $('form[name=config_seo]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=atualiza_seo';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                if (res == 'branco') {
                    msg('branco_campos_mailserver', 'alert', 'Preencha todos os campos antes de atualizar os dados!');
                } else {
                    msg('sucesso_mailserver', 'accept', 'Dados atualizados com sucesso!');
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }

        });
        return false;
    });

    //CONFIGURACÕES DE ENDEREÇO.
    $('form[name="config_endereco"]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=atualiza_endereco';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                if (res == 'branco') {
                    msg('branco_campos_endereco', 'alert', 'Preencha todos os campos antes de atualizar os dados!');
                } else {
                    msg('sucesso_endereco', 'accept', 'Dados atualizados com sucesso!');
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }

        });
        return false;
    });

    /*************************************************
     *CONFIGURAÇÕES DE USUARIOS, DO SITE
     *************************************************/

    //Abri a modal de cadastro de usuarios.
    $('.j_adduser').click(function () {
        $('.dialog').fadeIn('slow', function () {
            $('.newuser').fadeIn('fast');
        });
        return false;
    });

    //FECHA AS MENSAGEM DIALOG, Essas duas mensagens estao se repetindo,
    //apenas para tirar o fundo preto que ja vem com a abertura do modal de cadastro do usuario
    $('.ajaxmsg').on('click', '.j_ajaxdial', function () {
        var iddomodal = $(this).attr('id');
        $('.' + iddomodal).fadeOut('slow', function () {
            //Reseta a clase.
            $(this).attr('class', 'ajaxmsg msg');
        });
        return false;
    });

    //ABRIR AS MSG
    /*Ao executar essa funcao o id nunca pode ser o mesmo nome.
     *  OBS: ao ser executada ele não abri o fundo preto pois sera usado no editar q ja vem o fundo preto.*/
    function msgDial(id, tipo, conteudo) {
        //Ternaria para validar o tipo de msg.
        var titulo = (tipo == 'accept' ? 'Sucesso' : (tipo == 'error' ? 'Opssss' : (tipo == 'alert' ? 'Atenção' : 'null')));
        if (titulo == 'null') {
            alert('As mensagens devem ser do tipo accept | error | alert');
        } else {
            //Apos abrir o fundo.
            $('.ajaxmsg').addClass(id).addClass(tipo).html(
                    '<strong class="tt">' + tipo + '</strong>' +
                    '<p>' + conteudo + '</p>' +
                    '<a href="#" class="closedial j_ajaxdial" id="' + id + '">X FECHAR</a>'
                    ).fadeIn('slow');
        }
    }
    
    //ABRIR AS MSG
    /*Ao executar essa funcao o id nunca pode ser o mesmo nome.
     * OBS: ao ser executada ele abri o fundo preto.*/
    function msg(id, tipo, conteudo) {
        //Ternaria para validar o tipo de msg.
        var titulo = (tipo == 'accept' ? 'Sucesso' : (tipo == 'error' ? 'Opssss' : (tipo == 'alert' ? 'Atenção' : 'null')));
        if (titulo == 'null') {
            alert('As mensagens devem ser do tipo accept | error | alert');
        } else {
            //Abri o fundo  predo da pagina.
            $('.dialog').fadeIn('fast', function () {
                //Apos abrir o fundo.
                $('.ajaxmsg').addClass(id).addClass(tipo).html(
                        '<strong class="tt">' + tipo + '</strong>' +
                        '<p>' + conteudo + '</p>' +
                        '<a href="#" class="closedial j_ajaxclose" id="' + id + '">X FECHAR</a>'
                        ).fadeIn('slow');
            });
        }
    }

    //Cadastro de usuarios.
    $('form[name=cadnewuser]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=usuario_manager&exe=cadastro';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                if (res == 'campos_branco') {
                    msgDial('branco_campos_mailserver', 'alert', 'Preencha todos os campos antes de atualizar os dados!');
                } else if (res == 'ermail') {
                    msgDial('email_invalido', 'error', 'Insira um email valido!');
                } else if (res == 'userexiste') {
                    msgDial('usuario_existe', 'error', 'Senha ou usuario já estão cadastrados!');
                } else {
                    msgDial('sucesso_usuarios', 'accept', 'Dados atualizados com sucesso!');
                    //Ao fechar a modal usuarios, da um refresh. o id vem da funcao de msg.
                    $('#sucesso_usuarios').click(function () {
                        window.location.reload();
                        return false;
                    });
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        return false;
    });
    
    //Faz consulta do usuario para edicao.
    $('.j_edit').click(function () {
        var iduser = $(this).attr('id');
        var dados = '&acao=usuarios_consulta&userid='+iduser;
         //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            success: function (res) {
                //Abri a tela preta.
                $('.dialog').fadeIn('fast', function () {
                    //Recebe o modal vindo do php.
                    $('.editnewuser').html(res).fadeIn('slow');
                });
            }
        });
        return false;
    });
    
    //fecha o modal de edicao.
    $('.editnewuser').on('click','.j_closemodaledit', function () {
        $('.editnewuser').fadeOut("slow", function () {
            $('.dialog').fadeOut('fast');
        });
        return false;
    });
    
    //Envia os dados para a atualizaçao
    $('.editnewuser').on('submit','form[name=atualizanewuser]', function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=usuario_manager&exe=atualiza';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                if (res == 'campos_branco') {
                    msgDial('branco_campos_mailserver', 'alert', 'Preencha todos os campos antes de atualizar os dados!');
                } else if (res == 'ermail') {
                    msgDial('email_invalido', 'error', 'Insira um email valido!');
                } else if (res == 'userexiste') {
                    msgDial('usuario_existe', 'error', 'Usuario já está cadastrado!');
                } else {
                    msgDial('sucesso_usuarios', 'accept', 'Dados atualizados com sucesso!');
                    //Ao fechar a modal usuarios, da um refresh. o id vem da funcao de msg.
                    $('#sucesso_usuarios').click(function () {
                        window.location.reload();
                        return false;
                    });
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        return false;
    });
    
    //Deleta usuarios.
    $('.j_delete').click(function () {
        var iddelete = $(this).attr('id');
         //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=usuarios_delete&deluser='+iddelete;

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            success: function (res) {
                if (res == 'prorioPerfil') {
                    msg('proprio_perfil', 'error', 'Você não pode deletar seu próprio perfil!');
                }else if (res == 'superuser'){
                    msg('superuser_perfil', 'error', 'Você não pode deletar um super usuario!');
                }else{
                    msg('sucesso_del_usuarios', 'accept', 'Dados deletados com sucesso!');
                     $('.usuarios .users li[id='+iddelete+']').fadeOut('slow');     
                }
            }
        }); 
        return false;
    });
    
    /*************************************************
     *CONFIGURAÇÕES DE CATEGORIAS, DO SITE
     *************************************************/
    
    
    //Cadastro de categorias.
    $('form[name=cadnewcat]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=cadastro_categoria';

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            beforeSend: function () {
                //Pego o load apenas deste formulario especifico, pois todos os form tem o mesmo load.
                form.find('.load').fadeIn('fast');
            },
            success: function (res) {
                
                if (res == 'campos_branco') {
                    msgDial('error_campos', 'alert', 'O campo categoria não pode ficar em branco!');
                } else if (res == 'catexiste') {
                    msgDial('categoria_existe', 'error', 'A categoria que você tentou cadastrar, já esta cadastrada!');
                } else {
                    msgDial('sucesso_categoria', 'accept', 'Dados atualizados com sucesso!');
                    //Redireciona.
                    window.setTimeout(function () {
                        $(location).attr('href','dashboard.php?exe=categorias/edit&idcat='+res);
                    },2000);
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        return false;
    });
});
