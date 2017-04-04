<div class="content home">
    <h1 class="location">Olá <?= strtoupper($_SESSION['user']['nome']) ?>! <span><?php echo date('d/m/Y H:i');?></span></h1><!--/location-->
    
	<div class="erronotfound">
    	<h2>Apenas Super Admins poderão ter acesso a esta pagina!</h2>
        <span><strong>Erro 403</strong>Restrito!</span>
    </div><!--404-->

<div class="clear"></div><!-- /clear -->
</div><!-- /content -->