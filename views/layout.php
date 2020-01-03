<?php
$activeAction = '';
if(isset($_GET['a']))
{
	$activeAction = $_GET['a'];
}
?>

<html>
	<head>
		<title><?php echo $title ?? "BORD-Festival" ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/grid.css">
		<link rel="stylesheet" type="text/css" href="assets/css/layout.css">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		<?php if(isset($css) && is_array($css)) : ?>
			<?php foreach($css as $index => $file) : ?>
			<link rel="stylesheet" type="text/css" href="assets/css/<?=$file?>.css">
			<?php endforeach; ?>
		<?php endif; ?>
		<meta name="viewport" content="initial-scale=1.0,width=device-width" />
		<noscript>
			<style>
				.no-script {display:none;}
			</style>
		</noscript>
	</head>
	<body>
		<div class="content-wrap">
			<header>
				<div class="container-top">
					<nav class="navbar">
						<div class="content-top">
							<div class="row">
								<div class="col-lg col-md-12 col-sm-12 float-left">
									<p class="festival-logo"><a class="nav-header" href="index.php">BORD-Festival</a></p>
								</div>
								<div class="col-lg-8 col-md-12 col-sm-12 float-left nav-menu">
									<a class="nav-link<?php echo ($activeAction === 'ticketshop' ? ' nav-link-active' : ''); ?>" href="?a=ticketshop">Tickets</a>
									<a class="nav-link<?php echo ($activeAction === 'contact' ? ' nav-link-active' : ''); ?>" href="?a=contact">Kontakt</a>
									<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
									<a class="nav-link<?php echo ($activeAction === 'profile' ? ' nav-link-active' : ''); ?>" href="?a=profile">Account</a>
									<a class="nav-link" href="?a=logout">Abmelden</a>
									<?php else : ?>
									<a class="nav-link<?php echo ($activeAction === 'login' ? ' nav-link-active' : ''); ?>" href="?a=login">Login</a>
									<a class="nav-link<?php echo ($activeAction === 'register' ? ' nav-link-active' : ''); ?>" href="?a=register">Registrieren</a>
									<?php endif; ?>
									
									<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && isset($_SESSION['client_id'])) : ?>
										<?php if(empty($carttotalcount) || empty($carttotalprice)) : ?>
											<a class="nav-link<?php echo ($activeAction === 'shoppingcart' ? ' nav-link-active' : ''); ?>" href="?a=shoppingcart">Warenkorb (<?php echo $carttotalcount ?>)</a>
										<?php else : ?>							
											<a class="nav-link<?php echo ($activeAction === 'shoppingcart' ? ' nav-link-active' : ''); ?>" href="?a=shoppingcart">Warenkorb (<?php echo $carttotalcount ?>): <?php echo $carttotalprice ?> €</a>
										<?php endif; ?>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</nav>
				</div>
			</header>
			<main>
				<div class="container">
					<article>
						<div class="content">
							<?php echo $body ?>
						</div>
					</article>
				</div>
			</main>
		</div>
		<footer class="footer">
			&copy; Daniel Depta, Raphael Freybe - FH Erfurt
		</footer>
	</body>
</html>