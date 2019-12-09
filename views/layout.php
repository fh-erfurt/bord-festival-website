<html>
	<head>
		<title><?php echo $title ?? "BORD-Festival" ?></title>
		<link rel="stylesheet" type="text/css" href="assets/css/layout.css">
		<link rel="shortcut icon" type="image/x-icon" href="assets/img/favicon.png">
		<?php if(isset($css) && is_array($css)) : ?>
			<?php foreach($css as $index => $file) : ?>
			<link rel="stylesheet" type="text/css" href="assets/css/<?=$file?>.css">
			<?php endforeach; ?>
		<?php endif; ?>
	</head>
	<body>
		<div class="content-wrap">
			<header>
				<div class="container">
				<nav>
					<ul>
						<li><a href="?a=index">Start</a></li>
						<li><a href="?a=ticketshop">Ticketshop</a></li>
						<?php if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true) : ?>
						<li><a href="?a=profile">Profile</a></li>
						<li><a href="?a=logout">Abmelden</a></li>
						<?php else : ?>
						<li><a href="?a=login">Login</a></li>
						<li><a href="?a=register">Registrieren</a></li>
						<?php endif; ?>
					</ul>
				</nav>
				<div class="center">
					<p class="festival-logo">BORD-Festival</p>
				</div>
				</div>
			</header>
			<main>
				<div class="container">
					<div class="content">
					<?php echo $body ?>
					</div>
				</div>
			</main>
		</div>
		<footer>
			&copy; Daniel Depta, Raphael Freybe - FH Erfurt
		</footer>
	</body>
</html>