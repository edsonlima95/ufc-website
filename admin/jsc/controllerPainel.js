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
    
    //CONFIGURAÕES DE TEMAS.
    
     //Ler a tabela apos ser cadastrados os dados.
     function lerTemas(){
        $.post('j_php/painel.php',{acao: 'ler_temas'}, function (res) {
            $('.temas').fadeTo(500,0.2, function () {
                $(this).html(res);
                $(this).queue(function () {
                    $(this).fadeTo(500,1,);
                });
                $(this).dequeue();
            });
        });
    }
    //Cadastra o tema.
    $('form[name=config_temas]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=cadastro_temas';

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
                if (res == 'campos_branco_tema') {
                    msg('branco_campos_tema', 'alert', 'Preencha todos os campos antes de cadastrar os dados!');
                }else{
                    msg('tema_sucesso', 'accept', 'Os dados foram cadastrados com sucesso!');
                    lerTemas();
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        return false;
    });
    
    //Ativa o tema.
    $('.temas').on('click','.j_ativatema',function () {
        var idtema = $(this).attr('id');
        
        $.post('j_php/painel.php',{acao: 'ativa_tema', id: idtema}, function (res) {
            lerTemas();
        });
        
        //Envia os dados.
        return false;
    });
    
    //Deleta o tema.
    $('.temas').on('click','.j_deletatema',function () {
        var idtema = $(this).attr('id');
        
        $.post('j_php/painel.php',{acao: 'deleta_tema', id: idtema}, function (res) {
            if(res == 'erroractive'){
                 msg('tema_branco', 'error', 'Opsss, tema esta em uso, não pode ser deletado!');
            }else{
                $('.temas tr[id='+idtema+']').fadeOut('slow');
            }
        });
        
        //Envia os dados.
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
        var dados = '&acao=usuarios_consulta&userid=' + iduser;
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
    $('.editnewuser').on('click', '.j_closemodaledit', function () {
        $('.editnewuser').fadeOut("slow", function () {
            $('.dialog').fadeOut('fast');
        });
        return false;
    });

    //Envia os dados para a atualizaçao
    $('.editnewuser').on('submit', 'form[name=atualizanewuser]', function () {
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
        var dados = $(this).serialize() + '&acao=usuarios_delete&deluser=' + iddelete;

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            success: function (res) {
                if (res == 'prorioPerfil') {
                    msg('proprio_perfil', 'error', 'Você não pode deletar seu próprio perfil!');
                } else if (res == 'superuser') {
                    msg('superuser_perfil', 'error', 'Você não pode deletar um super usuario!');
                } else {
                    msg('sucesso_del_usuarios', 'accept', 'Dados deletados com sucesso!');
                    $('.usuarios .users li[id=' + iddelete + ']').fadeOut('slow');
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
                    //Mostra a mensagem sem o fechamento.
                    $('.ajaxmsg').addClass('sucesso_categoria accept').html(
                            '<strong class="tt">Sucesso:</strong>' +
                            '<p>Dados atualizados com sucesso!</p>'
                            ).fadeIn('slow');

                    //Redireciona.
                    window.setTimeout(function () {
                        $(location).attr('href', 'dashboard.php?exe=categorias/edit&edita=' + res);
                    }, 2000);
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');

            }
        });
        return false;
    });

    //Botao de enviar a imagem da categoria.
    $('.j_send').click(function () {
        $('.j_capa').click().change(function () {
            $('.j_false').text($(this).val());
        });
        return false;
    });


    //Atualiza categorias.
    $('form[name=editcat]').submit(function () {

        var form = $(this);
        var bar = form.find('.progress');
        var per = form.find('.bar');

        //Envia os dados pelo plugin do formulario.
        form.ajaxSubmit({
            url: 'j_php/painel.php',
            type: 'POST',
            data: {acao: 'categoria_update'},
            uploadProgress: function (evento, posicao, total, porcent) {
                //Mostra a barra de porcentagem, e seta os valores.
                var porcentagem = porcent + '%';
                bar.fadeIn('fast', function () {
                    per.width(porcentagem).text(porcentagem);
                });
            },
            success: function (res) {
                if (res == 1) {
                    msg('cat_error_size', 'alert', 'Porfavor insira um arquivo de até 2MB');
                } else if (res == 2) {
                    msg('cat_error_tipo', 'alert', 'Porfavor verifique o tipo de arquivo');
                } else {
                    $('.viewcapa').fadeOut('slow', function () {
                        //Seta o caminho das imagens nos elementos na edicao.
                        $(this).find('img').attr('src', 'tim.php?src=../uploads/' + res + '&h=42');
                        $(this).find('a').attr('href', '../uploads/' + res);
                        $('.viewcapa').fadeIn('slow');
                    });
                }
            },
            complete: function () {
                //Some com a barra e reset os valores.
                bar.fadeOut('slow', function () {
                    per.width('0%').text('0%');
                    window.location.reload();
                });
            }
        });
        return false;
    });

    //Deleta as categorias.
    $('.j_deletarcat').click(function () {
        //Recupera o id da categoria ou sub.
        var idcat = $(this).attr('id');

        var form = $(this);
        var dados = '&acao=categoria_delete&delcat=' + idcat;

        //Envia os dados.
        $.ajax({
            url: "j_php/painel.php",
            type: 'POST',
            data: dados,
            success: function (res) {

                if (res == 'contemsub') {
                    msg('cat_error', 'error', 'Você não pode deletar a categoria, contem sub-categorias!');
                } else if (res == 'contempost') {
                    msg('subcat_error', 'error', 'Você não pode deletar a sub-categoria, contem posts cadastrados!');
                } else {
                    $('.posts li[id=' + idcat + ']').fadeOut('slow');
                    msg('sucesso_cat', 'accept', 'Deletado com sucesso!');
                    window.setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            }
        });
        return false;
    });

    /*************************************************
     *CONFIGURAÇÕES DE POSTS, DO SITE
     *************************************************/

    //Cadastra os posts
    $('form[name=cadnewpost]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=cadastro_posts';

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
                    msgDial('error_campos_post', 'alert', 'Porfavor preencha todos os campos!');
                } else {
                    //Mostra a mensagem sem o fechamento.
                    $('.ajaxmsg').addClass('sucesso_post accept').html(
                            '<strong class="tt">Sucesso:</strong>' +
                            '<p>Dados atualizados com sucesso!</p>'
                            ).fadeIn('slow');

                    //Redireciona.
                    window.setTimeout(function () {
                        form.find('input[name="titulo"]').val('');
                        $(location).attr('href', 'dashboard.php?exe=posts/edit&idpost=' + res);
                    }, 2000);
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        return false;
    });

    //Efeitos Formulario de atualizacao dos posts.

    //Botao de envio da galeira.
    $('.j_gsend').click(function () {
        $('.j_gallery').click().change(function () {
            var countNumFiles = $(this)[0].files.length;
            $('.j_gfalse').animate({width: '300px'}, 500, function () {
                $(this).html("<strong>" + countNumFiles + "</strong> itens selecionados");
            });
        });
    });

    //Verifica se ta checked primeiro, e adiciona o estilo.
    if ($('form[name=editpost] .check input').is(':checked')) {
        $('form[name=editpost] .check').css('background', '#0C0');
    } else {
        $('form[name=editpost] .check').css('background', '#999');
    }

    //Alterna a cor doc checked.
    $('form[name=editpost] .check').click(function () {
        //Verifica se ta checked.
        if ($(this).find('input').is(':checked')) {
            $(this).css('background', '#0C0');
        } else {
            $(this).css('background', '#999');
        }
    });

    //Atualiza os posts
    $('form[name="editpost"]').submit(function () {
        //Ta dando um atraso no tinny, para corrigir usa o disparo dele.
        tinyMCE.triggerSave();

        //Envia os dados.
        var form = $(this);
        var bar = $('.j_edit_posts .progress');
        var per = $('.j_edit_posts .progress .bar');

        //Envia os dados pelo plugin do formulario.
        form.ajaxSubmit({
            url: 'j_php/painel.php',
            type: 'POST',
            data: {acao: 'post_update'},
            uploadProgress: function (evento, posicao, total, porcent) {
                //Mostra a barra de porcentagem, e seta os valores.
                var porcentagem = porcent + '%';

                //So vou executar o load se existir valor nos campos de imagem.
                var capa = form.find('.j_capa');
                var galeria = form.find('.j_gallery');

                if (capa.val() || galeria.val()) {
                    $('.dialog').fadeIn('fast', function () {
                        //Abri o modal de load dos arquivos.
                        $('.j_edit_posts').fadeIn('slow', function () {
                            //Apresenta a barra de progresso.
                            bar.fadeIn('slow');
                            per.width(porcentagem).text(porcentagem);
                        });
                    });
                }
            },
            success: function(res) {
             
                //Se nao tiver os arquivso mostra so a mensagem sem o load.
               $('.dialog').fadeIn('fast', function () {
                        //Abri o modal de load dos arquivos.
                        $('.j_edit_posts').fadeIn('slow', function () {
                            $('.accept').fadeIn('slow');
                        });
                    });                          
            },
            complete: function () {
                bar.fadeOut('fast', function () {
                    $('.accept').fadeIn('slow');
                });
            }
        });
        return false;
    });
    //Deleta uma imagem da galeria dos postsno form de edicao.
    $('.galerry .galerrydel').click(function () {
        var idimg = $(this).attr('id');
        $('li[class=j_' + idimg + ']').delay('500').fadeOut("slow").css('background', 'red');
        $.ajax({
            url: 'j_php/painel.php',
            type: 'POST',
            data: 'acao=post_del_galeri&delimg='+idimg
        });
        return false;
    });

    //Fecha o modal de load dos arquivos.
    $('.j_closeloadposts').click('slow', function () {
        window.location.reload();
        $('.j_edit_posts').fadeOut('fast', function () {
            $('.dialog').fadeOut('fast');
            $('.accept').fadeOut('fast');
            $('.progress').fadeIn('fast', function () {
                $(this).find('.bar').css({width: '0%'}).text('0%');
            });
        });
        return false;
    });
    
    //Compartilha no facebook.
    $('.j_compartilha').click(function () {
        var link = $(this).attr('href');
        //Abri uma nov ajanela.
        window.open('http://www.facebook.com/sharer.php?u='+link,'Curso jquery','width=500,height=400,location=no');
        return false;
    });
    
    //Deleta os posts.
    $('.j_delposts').click(function () {
        var idpost = $(this).attr('id');
        var url = 'j_php/painel.php';
        var dados = 'acao=post_delete&delpost='+idpost;
        $.post(url,dados, function () {
            window.setTimeout(function () {
            $('li[id=j_'+idpost+']').fadeOut('slow');
        },1000);
        });
        return false;
    });
    
    /*****************************************
     * HOME
     *****************************************/
    $('form[name=geradados]').submit(function () {
        
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() + '&acao=relatorio';

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
                alert(res);
                if (res == 'campos_branco') {
                    msgDial('error_relatorio_branco', 'alert', 'Porfavor preencha todos os campos!');
                }else if (res == 'notfound'){
                    msgDial('not_found', 'alert', 'Não contem registro entre o periodo informado!');
                }else{
                    $('.j_relatorio').html(res);
                }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
        });
        
        return false;
    });
    
});
