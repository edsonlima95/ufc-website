$(function(){
    
        var url = 'http://localhost/proJquery/projeto/j_php/home.php';
    
        //Efeito destaqus.
        $('.j_destaq').click(function () {
        var manipula = $('.bloco_dois .arts');
        
        //Muda as cor
        $(this).css('background-color','rgb(120,56,74)');
        $('.navbldois .j_deolho').css('background-color','rgba(14,60,73,0.7)');
        
        //Da um efeito transparente, e envia para a consulta.
        manipula.fadeTo(500,0.2, function () {
                $.post(url,{acao: 'destaques'}, function (res) {
                   manipula.html(res);
                    //Coloca na fila, pois o html nao tem callback.
                    manipula.queue(function () {
                         manipula.fadeTo(500,1);
                    });
                     manipula.dequeue();
                });
           });
        });
        
        //Efeito de olho
        $('.j_deolho').click(function () {
        var manipula = $('.bloco_dois .arts'); 
        //Muda as cor
        $(this).css('background-color','rgb(14,60,73)');
        $('.navbldois .j_destaq').css('background-color','rgba(120,56,74,0.7)');
       
        //Da um efeito transparente.
        manipula.fadeTo(500,0.2, function () {
                $.post(url,{acao: 'deolho'}, function (res) {
                    manipula.html(res);
                    //Coloca na fila, pois o html nao tem callback.
                    manipula.queue(function () {
                         manipula.fadeTo(500,1);
                    });
                     manipula.dequeue();
                });
            });
        });
        
        //Esconde o Footer
	$('#footer').hide();
	
	//height da box
	$('.bloco').each(function(){
		var altura = $(window).height();
		altura = altura - 110;
		$(this).css('min-height',altura);
	});
    
	//slide
	$('.slidequery img').hide();
	$('.slidequery').cycle({ 
		fx:      'fade', 
		speed:    1000, 
		timeout:  3000 ,
		pager:  '.slidequerynav'
	});
	
	//navegacao
	$('.navtopo li a').click(function(){
		var goto = $(this).attr("href");
		
		//CONTATO MODIFY
		if(goto != '#contato'){
			var gooo = $(goto).offset().top;
			$('html, body').animate({scrollTop:gooo},1000);
			
		}else{
			$('.navtopo li a').removeClass('active');
			$('.navtopo li a[href="#contato"]').addClass('active');
			$('.contato').animate({width: 'toggle'});
		}		
		return false;
	});	
	
	//marcando atual
	var menuid = $('.navtopo li');
	var menuit = menuid.find('.a');
	
	var navit = menuit.map(function(){
		var cadait = $($(this).attr("href"));
		if(cadait.length) { return cadait; }
	});
	
	$('.navtopo li a:first').addClass('active');
	
    //FOOTER EFEITO.
        $(window).scroll(function(){
		var menuh = menuid.height();
		var dotopo = $(this).scrollTop()+menuh;
		
		var atual = navit.map(function(){
			var posicao = $(this).position().top;
			if(posicao < dotopo){
				return this;	
			}
		});
		
		atual = atual[atual.length-1];
		var este = atual && atual.length ? atual[0].id : "";
		
		if(menuid != este){
			menuid.find('a').removeClass('active');
			menuid.find('a[href="#'+este+'"]').addClass('active');	
		}
		
		//ACRESENTA HOVER FOOTER
		if(este != 'home'){
			$('#footer').slideDown("slow");	
		}else{
			$('#footer').slideUp("slow");	
		}
	});
});

$(window).ready(function(){
	$('.slidequery li').each(function(){
		var img = $(this).find('img').attr("src");
		var pix = $(window).width();
			
		$(this).find('img').attr("src",'tim.php?src='+img+'&w='+pix+'&h=350&a=c');
		$('.slidequery img').fadeIn();
	});
});