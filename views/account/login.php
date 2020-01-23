<?php
if(!isset($missing))
{
	$missing['mail'] = false;
	$missing['password'] = false;
}
?>

<div class="background-black">
	<div class="row">
		<div class="col-lg-4 col-md-6 col-sm-12 center clear-fix">
			<section>
				<h1 class="page-heading">Login</h1>
				<?php
				if(!empty($loginerror))
				{
				?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 clear-fix">
						<div class="alert alert-danger">
							<?php echo $loginerror; ?>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<form method="post">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<label for="InputMail" class="form-for">E-Mail</label>
							<input id="InputMail" class="form-control <?php echo($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
								type="email" name="mail" placeholder="E-Mail" />
							<?php if($missing['mail'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihre E-Mail an.</div>
							<?php endif; ?>

							<label for="InputPassword" class="form-for">Passwort</label>
							<input id="InputPassword" class="form-control <?php echo($missing['password'] === false) ? '' : 'text-validate-red' ?>"
								type="password" name="password" placeholder="Passwort"/>
							<?php if($missing['password'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihr Passwort an</div>
							<?php endif; ?>

							<button class="btn btn-primary float-left" type="submit" name="submit">Einloggen</button>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</div>