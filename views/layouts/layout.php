<!DOCTYPE html>
<html>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
	<link rel="stylesheet" href="<?= $template['location'] . 'assets/css/main.css'; ?>" />
	<title><?= $this->config->item('website_name'); ?> - <?= $pagetitle ?></title>
</head>

<body>
	<!-- top nav -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		<div class="container">
			<a class="navbar-brand" href="<?= base_url(); ?>"><?= $this->config->item('website_name'); ?></a>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarSupportedContent">
				<ul class="navbar-nav mr-auto">
					<?php foreach ($this->wowgeneral->getMenu()->result() as $menulist) : ?>
						<?php if ($menulist->main == '2') : ?>
							<li class="nav-item dropdown">
								<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="<?= $menulist->icon ?>"></i> <?= $menulist->name ?> </a>
								<div class="dropdown-menu" aria-labelledby="navbarDropdown">
									<?php foreach ($this->wowgeneral->getMenuChild($menulist->id)->result() as $menuchildlist) : ?>
										<?php if ($menuchildlist->type == '1') : ?>
											<a class="dropdown-item" target="_blank" href="<?= $menuchildlist->url ?>"><i class="<?= $menuchildlist->icon ?>"></i> <?= $menuchildlist->name ?></a>
										<?php elseif ($menuchildlist->type == '2') : ?>
											<a class="dropdown-item" target="_blank" href="<?= $menuchildlist->url ?>"><i class="<?= $menuchildlist->icon ?>"></i> <?= $menuchildlist->name ?></a>
										<?php endif; ?>
									<?php endforeach; ?>
								</div>
							</li>
						<?php endif; ?>
						<?php if ($menulist->main == '1' && $menulist->child == '0') : ?>
							<?php if ($menulist->type == '1') : ?>
								<li class="nav-item">
									<a class="nav-link" href="<?= base_url($menulist->url); ?>"><i class="<?= $menulist->icon ?>"></i> <?= $menulist->name ?></a>
								</li>
							<?php elseif ($menulist->type == '2') : ?>
								<li class="nav-item">
									<a class="nav-link" target="_blank" href="<?= $menulist->url ?>"><i class="<?= $menulist->icon ?>"></i> <?= $menulist->name ?></a>
								</li>
							<?php endif; ?>
						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
				<ul class="navbar-nav ml-auto">
					<!-- If you are not logged in -->
					<?php if (!$this->wowauth->isLogged()) : ?>
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><?= $this->lang->line('tab_account'); ?></a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<!-- If the registration module is enabled -->
								<?php if ($this->wowmodule->getRegisterStatus() == '1') : ?>
									<a class="dropdown-item" href="<?= base_url('register'); ?>"><i class="fas fa-user-plus"></i> <?= $this->lang->line('button_register'); ?></a>
								<?php endif; ?>
								<div class="dropdown-divider"></div>
								<!-- If the login module is enabled -->
								<?php if ($this->wowmodule->getLoginStatus() == '1') : ?>
									<a class="dropdown-item" href="<?= base_url('login'); ?>"><i class="fas fa-sign-in-alt"></i> <?= $this->lang->line('button_login'); ?></a>
								<?php endif; ?>
							</div>
						</li>
						<!-- If you are logged in -->
					<?php else : ?>
						<!-- WIP: Avatar missing -->
						<li class="nav-item dropdown">
							<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-user"></i> <?= $this->session->userdata('blizz_sess_username'); ?></a>
							<div class="dropdown-menu" aria-labelledby="navbarDropdown">
								<?php if ($this->wowmodule->getUCPStatus() == '1') : ?>
									<a class="dropdown-item" href="<?= base_url('panel'); ?>">
										<i class="far fa-user-circle"></i> <?= $this->lang->line('button_user_panel'); ?>
									</a>
									<a class="dropdown-item" href="<?= base_url('settings'); ?>">
										<i class="far fa-user"></i> <?= $this->lang->line('button_account_settings'); ?>
									</a>
								<?php endif; ?>
								<!-- If you are a moderator -->
								<?php if ($this->wowauth->getIsModerator($this->session->userdata('wow_sess_gmlevel'))) : ?>
									<div class="dropdown-divider"></div>
									<a class="dropdown-item" href="<?= base_url('mod'); ?>">
										<i class="fas fa-gavel"></i> <?= $this->lang->line('button_mod_panel'); ?>
									</a>
								<?php endif; ?>
								<!-- If the administration module is enabled -->
								<?php if ($this->wowmodule->getACPStatus() == '1') : ?>
									<!-- If you are an administrator -->
									<?php if ($this->wowauth->getIsAdmin($this->session->userdata('wow_sess_gmlevel'))) : ?>
										<div class="dropdown-divider"></div>
										<a class="dropdown-item" href="<?= base_url('admin'); ?>">
											<i class="fas fa-cog"></i> <?= $this->lang->line('button_admin_panel'); ?>
										</a>
									<?php endif; ?>
								<?php endif; ?>
								<div class="dropdown-divider"></div>
								<a class="dropdown-item" href="<?= base_url('logout'); ?>">
									<i class="fas fa-sign-out-alt"></i> <?= $this->lang->line('button_logout'); ?>
								</a>
							</div>
						</li>
					<?php endif; ?>
				</ul>
			</div>
		</div>
	</nav>
	<?= $template['body']; ?>
	<section class="footer">
		<div class="container">
			<ul class="social-header list-inline text-center">
				<li class="list-inline-item">
					<a href="<?= $this->config->item('social_facebook'); ?>" target="_black">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fab fa-facebook-f fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
				<li class="list-inline-item">
					<a href="<?= $this->config->item('social_twitter'); ?>" target="_black">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fab fa-twitter fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
				<li class="list-inline-item">
					<a href="<?= $this->config->item('social_youtube'); ?>" target="_black">
						<span class="fa-stack fa-lg">
							<i class="fa fa-circle fa-stack-2x"></i>
							<i class="fab fa-youtube fa-stack-1x fa-inverse"></i>
						</span>
					</a>
				</li>
			</ul>
			<p class="text-center">Copyright <i class="far fa-copyright"></i> <?= date('Y'); ?> <span><?= $this->config->item('website_name'); ?></span>. <?= $this->lang->line('footer_rights'); ?></p>
			<p class="text-center">World of Warcraft® and Blizzard Entertainment® are all trademarks or registered trademarks of Blizzard Entertainment in the United States and/or other countries. These terms and all related materials, logos, and images are copyright © Blizzard Entertainment. This site is in no way associated with or endorsed by Blizzard Entertainment®.</p>
			<p class="text-center">Proudly powered by <a target="_blank" href="https://wow-cms.com">BlizzCMS</a></p>
		</div>
	</section>
	<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
	<script src="<?= $template['assets'] . 'core/fontawesome/js/all.js'; ?>"></script>
	<script src="https://www.google.com/recaptcha/api.js"></script>
	<script>
		const whTooltips = {
			colorLinks: false,
			iconizeLinks: false,
			renameLinks: false,
			dropchance: true
		};
	</script>
</body>

</html>
