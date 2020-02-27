<?php
$activeAction = '';
if(isset($_GET['a']))
{
	$activeAction = $_GET['a'];
	if(isset($_GET['t']))
	{
		$activeType = $_GET['t'];
	}
}
    $isJSON = false;
    if(isset($_GET['json']) && $_GET['json'] === "true")
    {
        $isJSON = true;
    }
?>
<?php if($isJSON === true): ?>
<?php else : ?>

<html>
	<head>
		<title><?php echo $title ?? "BORD-Festival" ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/grid.css">
		<link rel="stylesheet" type="text/css" href="assets/css/layout.css">
		<link rel="stylesheet" href="assets/css/print.css"type="text/css" media="print" />
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/bord_logo.ico">
		<?php if(isset($css) && is_array($css)) : ?>
			<?php foreach($css as $index => $file) : ?>
			<link rel="stylesheet" type="text/css" href="assets/css/<?=$file?>.css">
			<?php endforeach; ?>
		<?php endif; ?>
		<meta name="viewport" content="initial-scale=1.0,width=device-width" />
		<noscript>
			<style>
				.hide-js-disabled {display:none;}
			</style>
		</noscript>
	</head>
	<body>
		<div class="content-wrap">
			<header>
				<div class="container-top">
					<nav>
						<div class="content-top">
							<div class="row">
								<div class="col-lg-2 col-md-2 float-left hide-mobile">
									<a class="nav-header" href="?c=pages&a=index">
									<img class="" src="assets/img/bord_logo_negativ.png" alt="BORD-Festival" height="100" width="100">
									</a>
								</div>
								<div class="col-lg-10 col-md-10 col-sm-12 float-left nav-menu">
									<a class="nav-link<?php echo ($activeAction === 'index' || $activeAction === '' ? ' nav-link-active' : ''); ?>" href="?c=pages&a=index">Start<span class="hide-mobile">seite</span></a>
									<div class="dropdown">
										<a href='#' class="nav-link<?php echo ($activeAction === 'shop' ? ' nav-link-active' : ''); ?>">
											<div>Shop <div class="dropdown-icons">
												<span class="dropdown-closed">▸</span> <span class="dropdown-open">▾</span>
												</div>
											</div>
										</a>
										<div class="dropdown-content">
											<a class="<?php echo ($activeAction === 'shop' && $activeType === 'tickets' ? ' dropdown-link-active' : ''); ?>"
											   href="?c=order&a=shop&t=tickets">Tickets</a>
											<a class="<?php echo ($activeAction === 'shop' && $activeType === 'merchandise' ? ' dropdown-link-active' : ''); ?>"
											   href="?c=order&a=shop&t=merchandise">Merchandise</a>
										</div>
									</div>
									<div class="dropdown">
										<a href='#' class="nav-link<?php echo ($activeAction === 'contact' ? ' nav-link-active' : ''); ?>">
										<div>Über<div class="hide-mobile hide-medium-screen"> uns</div> <div class="dropdown-icons"><span class="dropdown-closed">▸</span>
										<span class="dropdown-open">▾</span></div></div>
										</a>
										<div class="dropdown-content">
											<a class="<?php echo ($activeAction === 'contact' ? ' dropdown-link-active' : ''); ?>"
											   href="?c=contact&a=contact">Kontakt</a>
											<a href="?a=anfahrt">Anfahrt</a>
											<a href="dokumentation.html">Dokumentation</a>
											<a class="<?php echo ($activeAction === 'impressum' ? ' dropdown-link-active' : ''); ?>"
											   href="?a=impressum">Impressum</a>
										</div>
									</div>
									<?php
										if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) :
									?>
										<div class="dropdown">
											<a href="?c=account&a=profile" class="nav-link<?php echo ($activeAction === 'profile' ? ' nav-link-active' : ''); ?>">
												<div class="hide-mobile hide-medium-screen">Mein </div>Konto 
												<div class="dropdown-icons">
													<span class="dropdown-closed">▸</span>
													<span class="dropdown-open">▾</span>
												</div>
											</a>
											<div class="dropdown-content">
												<a class="<?php echo ($activeAction === 'profile' ? ' dropdown-link-active' : ''); ?>" href="?c=account&a=profile">Account</a>
												<a href="?c=account&a=logout">Abmelden</a>
											</div>
										</div>
									<?php
										else :
									?>
										<a class="nav-link<?php echo ($activeAction === 'login' ? ' nav-link-active' : ''); ?>" href="?c=account&a=login">Login</a>
										<a class="nav-link<?php echo ($activeAction === 'register' ? ' nav-link-active' : ''); ?>" href="?c=account&a=register">Registrieren</a>
									<?php
										endif;
									?>
									
									<?php 
										if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true && isset($_SESSION['client_id'])) : ?>
										<a class="nav-link<?php echo ($activeAction === 'shoppingcart' ? ' nav-link-active' : ''); ?>"
											href="?c=order&a=shoppingcart"><span class="hide-mobile">Warenkorb</span><img class="show-mobile-inline" src="assets/img/shoppingcart.png">(<span id="carttotalcount" class="display-inline"><?php echo $cartTotalCount ?></span>)<span id="hide-empty-cart" class="<?php echo(empty($cartTotalCount) ? 'display-none' : ''); ?>"><span class="hide-mobile hide-medium-screen display-inline">:
												<span id="carttotalprice" class="display-inline"> <?php echo $cartTotalPrice ?><span> €
											</span></span>
										</a>
									<?php
										endif;
									?>
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
<?php endif ?>