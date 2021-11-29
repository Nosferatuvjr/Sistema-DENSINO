<?php include('config.php'); ?>
<?php Site::updateUsuarioOnline(); ?>
<?php Site::contador(); ?>
<?php
$infoSite = MySql::conectar()->prepare("SELECT * FROM `tb_site.config`");
$infoSite->execute();
$infoSite = $infoSite->fetch();
?>
<!DOCTYPE html>
<html>

<head>
	<title><?php echo $infoSite['titulo']; ?></title>
	<link rel="stylesheet" href="<?php echo INCLUDE_PATH; ?>estilo/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700" rel="stylesheet">
	<link href="<?php echo INCLUDE_PATH; ?>estilo/style.css" rel="stylesheet" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="author" content="Vivaldo Chagas" />
	<meta name="keywords" content="">
	<meta name="description" content="">
	<link rel="icon" href="<?php echo INCLUDE_PATH; ?>favicon.ico" type="image/x-icon" />
	<meta charset="utf-8" />
</head>

<body>
	<base base="<?php echo INCLUDE_PATH; ?>" />
	<?php
	$url = isset($_GET['url']) ? $_GET['url'] : 'home';
	switch ($url) {
		case 'mensagens':
			echo '<target target="mensagens" />';
			break;

		case 'servicos':
			echo '<target target="servicos" />';
			break;
	}
	?>
	<div class="sucesso"><i class="fa fa-check"></i> Formulário enviado com sucesso!</div>
	<div class="overlay-loading">
		<img src="<?php echo INCLUDE_PATH ?>images/ajax-loader.gif" />
	</div>
	<!--overlay-loading-->

	<header>
		<div class="center">
			<div class="logo left"><a href="<?php echo INCLUDE_PATH; ?>"><img src="<?php echo INCLUDE_PATH; ?>images/logodensino.jpeg" alt=""></a></div>
			<!--logo-->
			<nav class="desktop right">
				<ul>
					<li><a title="Home" href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
					<li><a title="Mensagens" href="<?php echo INCLUDE_PATH; ?>mensagens">Mensagens</a></li>
					<li><a title="Serviços" href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>equipe">Equipe</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>materiais">Materiais</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
				</ul>
			</nav>
			<nav class="mobile right">
				<div class="botao-menu-mobile">
					<i class="fa fa-bars" aria-hidden="true"></i>
				</div>
				<ul>
					<li><a href="<?php echo INCLUDE_PATH; ?>">Home</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>mensagens">Mensagens</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>servicos">Serviços</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>equipe">Equipe</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>materiais">Materiais</a></li>
					<li><a href="<?php echo INCLUDE_PATH; ?>noticias">Notícias</a></li>
				</ul>
			</nav>
			<div class="clear"></div>
			<!--clear-->
		</div>
		<!--center-->
	</header>


	<div class="container-principal">
		<?php

		if (file_exists('pages/' . $url . '.php')) {
			include('pages/' . $url . '.php');
		} else {
			//Podemos fazer o que quiser, pois a página não existe.
			if ($url != 'mensagens' && $url != 'servicos') {
				$urlPar = explode('/', $url)[0];
				if ($urlPar != 'noticias') {
					$pagina404 = true;
					include('pages/404.php');
				} else {
					include('pages/noticias.php');
				}
			} else {
				include('pages/home.php');
			}
		}

		?>

	</div>
	<!--container-principal-->

	<?php 
		$rodape = "&copy; Todos os direitos reservados. Amazonas Desenvolvimento";
	?>

	<footer <?php if (isset($pagina404) && $pagina404 == true) echo 'class="fixed"'; ?>>
		<div class="center">
			<p><?php echo $rodape; ?></p>
		</div>
		<!--center-->
	</footer>

	<script src="<?php echo INCLUDE_PATH; ?>js/jquery.js"></script>
	<script src="<?php echo INCLUDE_PATH; ?>js/constants.js"></script>
	<script src='https://maps.googleapis.com/maps/api/js?v=3.exp&key=AIzaSyDHPNQxozOzQSZ-djvWGOBUsHkBUoT_qH4'></script>
	<script src="<?php echo INCLUDE_PATH; ?>js/scripts.js"></script>

	<script src="<?php echo INCLUDE_PATH; ?>js/slider.js"></script>

	<?php

	if (is_array($url) && strstr($url[0], 'noticias') !== false) {
	?>
		<script>
			$(function() {
				$('select').change(function() {
					location.href = include_path + "noticias/" + $(this).val();
				})
			})
		</script>
	<?php
	}
	?>

	<?php
	if ($url == 'contato') {
	?>
	<?php } ?>
	<!--<script src="<?php echo INCLUDE_PATH; ?>js/exemplo.js"></script>-->
	<script src="<?php echo INCLUDE_PATH; ?>js/formularios.js"></script>
</body>

</html>