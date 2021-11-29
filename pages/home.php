		<?php Site::updateUsuarioOnline(); ?>
		<?php Site::contador(); ?>

		<section class="banner-container">
			<?php
			$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.slides`");
			$sql->execute();
			$slides = $sql->fetchAll();
			foreach ($slides as $key => $value) {
			?>



				<div style="background-image: url('<?php echo INCLUDE_PATH_PAINEL; ?>uploads/<?php echo $value['slide']; ?>');" class="banner-single"></div>

			<?php } ?>
			<!--banner-single-->
			<div class="overlay"></div>
			<!--overlay-->
			<div class="center">
				<form class="ajax-form" method="post">
					<h2>Se não sabes, aprende; se já sabes, ensina. - Confúcio</h2>
				</form>
			</div>
			<!--center-->
			<div class="bullets"></div>
			<!--bullets-->
		</section>
		<!--banner-principal-->

		<section class="descricao-autor">
			<div class="center">
				<div class="w100 left">
					<div class="center">
						<img src="<?php echo INCLUDE_PATH ?>images/logodensino1.png" />
					</div>
					<h2 class="text-center"><?php echo $infoSite['nome_autor']; ?></h2>
					<p><strong>Nós somos o Departamento de Ensino da Zona Urbana do Município de Manacapuru.</strong> <?php echo $infoSite['descricao']; ?></p>
					<div id="img-equipe" class="center">
						<!-- <img src="<?php echo INCLUDE_PATH ?>images/equipe.jpeg" /> -->
					</div>
				</div>
				<!--w50-->

				<div class="clear"></div>
			</div>
			<!--center-->
		</section>
		<!--descricao-autor-->

		<section class="especialidades">

			<div class="center">
				<h2 class="title">Especialidades</h2>
				<div class="w33 left box-especialidade">
					<h3><i class="<?php echo $infoSite['icone1']; ?>" aria-hidden="true"></i></h3>
					<h4><strong>Inovação</strong></h4>
					<p><?php echo $infoSite['descricao1']; ?></p>
				</div>
				<!--box-especialidade-->
				<div class="w33 left box-especialidade">
					<h3><i class="<?php echo $infoSite['icone2']; ?>" aria-hidden="true"></i></h3>
					<h4><strong>Educação</strong></h4>
					<p><?php echo $infoSite['descricao2']; ?></p>
				</div>
				<!--box-especialidade-->
				<div class="w33 left box-especialidade">
					<h3><i class="<?php echo $infoSite['icone3']; ?>" aria-hidden="true"></i></h3>
					<h4>
						<strong>Orientações</strong>
					</h4>
					<p><?php echo $infoSite['descricao3']; ?></p>
				</div>
				<!--box-especialidade-->

				<div class="clear"></div>
			</div>
			<!--center-->

		</section>
		<!--especialidades-->

		<section class="extras">

			<div class="center">
				<div id="mensagens" class="w50 left depoimentos-container">
					<h2 class="title">Mensagens do DENSINO&#128156;</h2>
					<?php
					$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.depoimentos` ORDER BY order_id ASC LIMIT 3");
					$sql->execute();
					$depoimentos = $sql->fetchAll();
					foreach ($depoimentos as $key => $value) {
					?>
						<div class="depoimento-single">
							<p class="depoimento-descricao">"<?php echo $value['depoimento']; ?>"</p>
							<p class="nome-autor"><?php echo $value['nome']; ?> - <?php echo $value['data']; ?></p>
						</div>
						<!--depoimento-single-->
					<?php } ?>
				</div>
				<!--w50-->
				<div id="servicos" class="w50 left servicos-container">
					<h2 class="title">Serviços</h2>
					<div class="servicos">
						<ul>
							<?php
							$sql = MySql::conectar()->prepare("SELECT * FROM `tb_site.servicos` ORDER BY order_id ASC LIMIT 7");
							$sql->execute();
							$servicos = $sql->fetchAll();
							foreach ($servicos as $key => $value) {
							?>
								<li><?php echo $value['servico']; ?></li>
							<?php } ?>
						</ul>
					</div>
					<!--servicos-->
				</div>
				<!--w50-->
				<div class="clear"></div>
			</div>
			<!--center-->
		</section>
		<!--extras-->