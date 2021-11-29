		<?php Site::updateUsuarioOnline(); ?>
		<?php Site::contador(); ?>

		<?php
		$url = explode('/', $_GET['url']);


		$verifica_categoria = MySql::conectar()->prepare("SELECT * FROM `tb_site.categorias` WHERE slug = ?");
		$verifica_categoria->execute(array($url[1]));
		if ($verifica_categoria->rowCount() == 0) {
			Painel::redirect(INCLUDE_PATH . 'noticias');
		}
		$categoria_info = $verifica_categoria->fetch();

		$post = MySql::conectar()->prepare("SELECT * FROM `tb_site.noticias` WHERE slug = ? AND categoria_id = ?");
		$post->execute(array($url[2], $categoria_info['id']));
		if ($post->rowCount() == 0) {
			Painel::redirect(INCLUDE_PATH . 'noticias');
		}

		//É POR QUE MINHA NOTICIA EXISTE
		$post = $post->fetch();

		?>
		<section class="noticia-single">
			<div class="center">
				<header>
					<h1><i class="fa fa-calendar"></i> <?php echo $post['data'] ?> - <?php echo $post['titulo'] ?></h1>
				</header>
				<article>
					<img src="<?php echo INCLUDE_PATH_PAINEL ?>uploads/<?php echo $post['capa']; ?>">
					<?php echo $post['conteudo']; ?>
				</article>
				<a href="" id="facebook-share-btt" rel="nofollow" target="_blank" class="facebook-share-button"><i class="fa fa-facebook"></i> Compartilhar no Facebook</a>
			</div>

		</section>

		<script>
			document.addEventListener("DOMContentLoaded", function() {
				//altera a URL do botão
				document.getElementById("facebook-share-btt").href = "https://www.facebook.com/sharer/sharer.php?u=" + encodeURIComponent(window.location.href);
			}, false);
		</script>