$(function(){
    
        //Efeito do sub-menu.
        $('.navtopo li').mouseover(function () {
            $(this).find('.submenu').fadeIn('fast');
        }).mouseleave(function () {
            $(this).find('.submenu').fadeOut('fast');
        });
        
        $('.navtopo .subopen').click(function () {
         return false;
        });
        
        //Paginacao de resultados categoria.
        $('.j_catpag').on('click','.paginator a', function () {
            if($(this).hasClass('atv')){
                return false;
            }else{
                $('.j_catpag .paginator a').removeClass('atv');
                $(this).addClass('atv');
                
                var urlaction = '../j_php/home.php';
                var url = $(this).attr('href');
                var data = url.lastIndexOf('/')+1;
                //Recupera o numero da pagina, passado na utl.
                var data = url.substr(data);

               $('.j_catpag ul').fadeTo(500,0.2);

               $.post(urlaction, {acao: 'cat_paginacao', page: data}, function (res) {
                   $('html, body').delay(700).animate({scrollTop: $('h2').offset().top - 40}, 500);
                   window.setTimeout(function () {
                        $('.j_catpag').html(res);
                        $('.j_catpag ul').fadeTo(500,1);
                   },700);
               });
           }
           return false; 
        });
        
        
        //Pesquisa.
        $('form[name="search"]').submit(function () {
            var word = $(this).find('input[name="s"]').val();
            if(!word){
                myDial('alert','Insira uma palavra a ser pesquisada!');
            }else{
                var compara = $('.j_search');
                //Se estiver na pagina de pesquisa nao envia para o link.
                if(compara.is(':visible')){
                   
                    var t = $(document).attr('title');
                    //Altera o titulo da pagina.
                    $(document).attr('title',t+' | Pesquisa por: ' +word);
                    //Alerta o nome da pesquisa.
                    $('.bloco_um').find('h1').text('Pesquisa:'+word);
                    //Altera no conteudo.
                    $('.bloco_um').find('h2 strong').text(word);
                    
                    $('.j_search ul').fadeTo(500,0.2);
                   
                    $.post('../j_php/home.php', {acao: 'search', word: word}, function (res) {
                        $('html, body').delay(700).animate({scrollTop: $('h2').offset().top - 40}, 500);
                        window.setTimeout(function () {
                            $('.j_search').html(res);
                            $('.j_search ul').fadeTo(500,1);
                         },700);
                    });
                }else{
                   $(location).attr('href','http://localhost/proJquery/projeto/pesquisa/'+word);
                }
            }
            return false;
        });
        
        
	Shadowbox.init();
	
	//Navegacao Geral
	$('.pagecontato').click(function(){
		$('.navtopo li a').removeClass('active');
		$('.navtopo li a[href="#contato"]').addClass('active');
		$('.contato').animate({width: 'toggle'});		
		return false;
	});	
	
	
	//CONTROLA A MODAL
	$('.contato').hide();
	
	$('.closecontato').click(function(){
		$('.contato').animate({width: 'toggle'});
		$('.navtopo li a').removeClass('active');
		return false;	
	});
	
	//CONTROLA O DIAL
	$('.dialog').hide();
	
	$('body').on('click','.closedial',function(){
            $(this).parent().fadeOut("slow",function(){
                $('.dialog').fadeOut("slow");
            });	
            return false;	
	});
	
	function myDial(clase,content){
		var strong = (clase == 'alert' ? 'Opsss:' : (clase == 'accept' ? 'Sucesso:' : (clase == 'error' ? 'Erro:' : 'Olá')));
		$('.dialog').fadeIn("slow",function(){
			$('.dialog').html('<div class="msg '+ clase +'"><strong class="tt">'+ strong +'</strong>'+ content +'<a href="#" class="closedial">X FECHAR</a></div>');	
		});
	}
	
	$('form[name="contato"]').submit(function(){
		myDial('alert','<p>Opss, não foi possivel enviar sua requisição. Entre em contato com o administrador.</p> <p><strong>Obrigado!</strong></p>');
		return false;	
	});
	
	//LIMPA TAMANHO DE ELEMENTOS NA SINGLE CONTENT
	$('.artigo .content img').each(function(){
		$(this).removeAttr('width').removeAttr('height');
	});
	
	$('.artigo .content iframe').each(function(){	
		var url = $(this).attr("src");
		var char = "?";
		if(url.indexOf("?") != -1){
			var char = "&";
		}
		
		var iw = $(this).width();
		var ih = $(this).height();
		var width = '660';
		var height = (width*ih) / iw;		
		$(this).attr({'width':'660px','height':height+'px','src':url+char+'wmode=transparent'});
	});
	
	//CONTROLA A BOX DE COMENTÁRIOS
	$('.commentbox, .commentbox form, .commentbox h3').hide();
	
	$('.opencomment').click(function(){
		$('.commentbox').fadeIn("slow",function(){
			$('.commentbox form, .commentbox h3').fadeIn("slow");
		});
		return false;
	});
	
	$('.closecomment').click(function(){
		$('.commentbox form, .commentbox h3').fadeOut('slow',function(){
			$('.commentbox').fadeOut("slow");	
		});	
		return false;
	});
	
	$('form[name="addcomment"]').submit(function(){
		varname = ($(this).find('input[name="nome"]').val() ? $(this).find('input[name="nome"]').val() : 'Robson V. Leite');
		myDial('accept','<p>Olá <strong>' + varname + '</strong>. Seu comentário foi enviado para o moderador. Assim que aprovado você será informado.</p><p><strong>Obrigado pela interatividade.</strong></p>');
		return false;	
	});
});