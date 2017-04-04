//Carrega toda a pagina e depois retira o fundo preto, com o carregando.
$(window).ready(function () {
    $('.loadsistema').fadeOut('slow', function () {
        $('.dialog').fadeOut('fast');
    });
});

$(function () {
    //CUSTOM
    
     //Forma geral.
    $('form').submit(function () {
        return false;
    });

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

    //FECHA Os MODAIS.
    //Recebe o valor do id que esta no fecha e fecha o modal de acordo com a classe que tiver o mesmo nome do id.
    $('.closemodal').click(function () {
        var iddomodal = $(this).attr('id');
        $('.'+iddomodal).fadeOut('slow', function () {
            $('.dialog').fadeOut('fast');
        });
    });
    
    //FECHA AS MENSAGEM.
     $('.ajaxmsg').on('click','.j_ajaxclose',function () {
        var iddomodal = $(this).attr('id');
        $('.'+iddomodal).fadeOut('slow', function () {
            $('.dialog').fadeOut('fast');
            //Reseta a clase.
            $(this).attr('class','ajaxmsg msg');
        });
        return false;
    });
    
    //ABRIR AS MSG
    /*Ao executar essa funcao o id nunca pode ser o mesmo nome.*/
    function msg(id, tipo, conteudo) {
        //Ternaria para validar o tipo de msg.
        var titulo = (tipo == 'accept' ? 'Sucesso' : (tipo == 'error' ? 'Opssss' : (tipo == 'alert' ? 'Atenção' : 'null')));
        if(titulo == 'null'){
            alert('As mensagens devem ser do tipo accept | error | alert');
        }else{
            //Abri o fundo  predo da pagina.
            $('.dialog').fadeIn('fast', function () {
                //Apos abrir o fundo.
                $('.ajaxmsg').addClass(id).addClass(tipo).html(
                   '<strong class="tt">'+tipo+'</strong>'+
                   '<p>'+ conteudo+'</p>'+
                   '<a href="#" class="closedial j_ajaxclose" id="'+id+'">X FECHAR</a>'
                ).fadeIn('slow');
            });
        }
    }
    
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
    
    //CONFIGURACAO DO EMAIL-SERVER.
    $('form[name="config_email"]').submit(function () {
        //Encapsula o formulario e os dados.
        var form = $(this);
        var dados = $(this).serialize() +'&acao=mailserver_atualiza';
        
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
               if(res == 'branco'){
                    msg('branco_campos_mailserver','alert','Preencha todos os campos antes de atualizar os dados!');
               }else if(res == 'ermail'){
                   msg('tipo_email_mailserver','error','Insira um email valido!');
               }else {
                   msg('sucesso_mailserver','accept','Dados atualizados com sucesso!');
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
               if(res){
                    msg('testa_enviado_mailserver','accept','E-mail enviado com sucesso, verifique seu email' + res);
               }else if (res == 2) {
                   msg('testa_error_mailserver','error','Error ao enviar o email, por favot verifique os dados do formulario');
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
        var dados = $(this).serialize() +'&acao=atualiza_seo';
        
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
               if(res == 'branco'){
                    msg('branco_campos_mailserver','alert','Preencha todos os campos antes de atualizar os dados!');
               }else {
                   msg('sucesso_mailserver','accept','Dados atualizados com sucesso!');
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
        var dados = $(this).serialize() +'&acao=atualiza_endereco';
        
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
               if(res == 'branco'){
                    msg('branco_campos_endereco','alert','Preencha todos os campos antes de atualizar os dados!');
               }else {
                   msg('sucesso_endereco','accept','Dados atualizados com sucesso!');
               }
            },
            complete: function () {
                form.find('.load').fadeOut('fast');
            }
            
        }); 
        return false;
    });
});
