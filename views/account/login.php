<script type="text/javascript" src="assets/js/validate.js"></script>
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
				<?php if(!empty($loginError)) : ?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 clear-fix">
						<div class="alert alert-danger">
							<?php echo $loginError; ?>
						</div>
					</div>
				</div>
				<?php endif; ?>
				
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 clear-fix">
						<div class="alert alert-danger hide-js-disabled" id="ajaxerror">
							Bitte alle Felder mit gültigen Werten ausfüllen!
						</div>
					</div>
				</div>
				<form method="post" onsubmit="return validateLogin();">
					<div class="row">
						<div class="col-lg-12 col-md-12 col-sm-12">
							<label for="InputMail" class="form-for">E-Mail</label>
							<input id="InputMail" class="form-control <?php echo($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
								type="email" name="mail" placeholder="E-Mail" onfocusout="validateInput(this.id, 'mail')">
							<div id="InputMail-error" class="validation-helptext <?php echo(($missing['mail'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre E-Mail an</div>

							<label for="InputPassword" class="form-for">Passwort</label>
							<input id="InputPassword" class="form-control <?php echo($missing['password'] === false) ? '' : 'text-validate-red' ?>"
								type="password" name="password" placeholder="Passwort" onfocusout="validateInput(this.id)">
							<div id="InputPassword-error" class="validation-helptext <?php echo(($missing['password'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihr Passwort an</div>

							<div class="row">		
								<div class="col-lg-12 col-md-12 col-sm-12 clearfix clear-left">
									<button id="buttonSubmit" class="btn btn-primary float-left" type="submit" name="submit">Einloggen</button>
								</div>
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</div>