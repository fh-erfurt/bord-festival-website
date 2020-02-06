<script type="text/javascript" src="assets/js/validate.js"></script>
<?php
if(!isset($missing))
{
	$missing['mail'] = false;
	$missing['password1'] = false;
	$missing['password2'] = false;
	$missing['firstname'] = false;
	$missing['lastname'] = false;
	$missing['dateofbirth'] = false;
	$missing['street'] = false;
	$missing['zip'] = false;
	$missing['city'] = false;
}
?>

<div class="background-black">
	<div class="row">
		<div class="col-lg-6 col-md-10 col-sm-10 center clear-fix">
			<section>
				<h1 class="page-heading text-left">Registrierung</h1>
				<?php
				if(!empty($registererror))
				{
					?>
				<div class="row">
					<div class="col-lg-12 col-md-12 col-sm-12 clear-fix">
						<div class="alert alert-danger">
							<?php echo $registererror; ?>
						</div>
					</div>
				</div>
				<?php
				}
				?>
				<form method="post" onsubmit="return validateAll();">
					<div class="row">
						<div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
							<div class="input-group">
								<label class="form-for" for="InputEmail">E-Mail</label>
								<input id="InputEmail" class="form-control <?php echo($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
									type="email" name="mail" placeholder="E-Mail" onfocusout="validateInput(this.id, 'mail')">
								<div id="InputEmail-error" class="validation-helptext <?php echo(($missing['mail'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie eine gültige E-Mail an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputPassword">Passwort</label>
								<input id="InputPassword" class="form-control <?php echo($missing['password1'] === false) ? '' : 'text-validate-red' ?>"
									type="password" name="password1" placeholder="Passwort" onfocusout="validateInput(this.id)">
								<div id="InputPassword-error" class="validation-helptext <?php echo(($missing['password1'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie ein Passwort ein</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputPassword2">Passwort wiederholen</label>
								<input id="InputPassword2" class="form-control <?php echo($missing['password2'] === false) ? '' : 'text-validate-red' ?>"
									type="password" name="password2" placeholder="Passwort wiederholen" onfocusout="validateInput(this.id)">
								<div id="InputPassword2-error" class="validation-helptext <?php echo(($missing['password2'] === true) ? 'display-show' : 'display-none'); ?>">Bitte bestätigen Sie das Passwort</div>
							</div>
						</div>
						
						<div class="col-lg-6 col-md-6 col-sm-12 float-left">
							<div class="input-group">
								<label class="form-for" for="InputFirstname">Vorname</label>
								<input id="InputFirstname" class="form-control <?php echo($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
									type="text" name="firstname" placeholder="Vorname" onfocusout="validateInput(this.id)">
								<div id="InputFirstname-error" class="validation-helptext <?php echo(($missing['firstname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Vornamen an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputLastname">Nachname</label>
								<input id="InputLastname" class="form-control <?php echo($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
									type="text" name="lastname" placeholder="Nachname" onfocusout="validateInput(this.id)">
								<div id="InputLastname-error" class="validation-helptext <?php echo(($missing['lastname'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihren Nachnamen an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputBirthday">Geburtsdatum</label>
								<input id="InputBirthday" class="form-control <?php echo($missing['dateofbirth'] === false) ? '' : 'text-validate-red' ?>"
									type="date" name="dateofbirth" placeholder="Geburtsdatum" onfocusout="validateInput(this.id)">
								<div id="InputBirthday-error" class="validation-helptext <?php echo(($missing['dateofbirth'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihr Geburtsdatum an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputStreet">Straße und Hausnummer</label>
								<input id="InputStreet" class="form-control <?php echo($missing['street'] === false) ? '' : 'text-validate-red' ?>"
									type="text" name="street" placeholder="Straße / Hausnummer" onfocusout="validateInput(this.id)">
								<div id="InputStreet-error" class="validation-helptext <?php echo(($missing['street'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre Straße und Hausnummer an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputZip">PLZ</label>
								<input id="InputZip" class="form-control <?php echo($missing['zip'] === false) ? '' : 'text-validate-red' ?>"
									type="text" name="zip" placeholder="PLZ" onfocusout="validateInput(this.id)">
								<div id="InputZip-error" class="validation-helptext <?php echo(($missing['zip'] === true) ? 'display-show' : 'display-none'); ?>">Bitte geben Sie Ihre Postleitzahl an</div>
							</div>
							<div class="input-group">
								<label class="form-for" for="InputCity">Ort</label>
								<input id="InputCity" class="form-control <?php echo($missing['city'] === false) ? '' : 'text-validate-red' ?>"
									type="text" name="city" placeholder="Ort" onfocusout="validateInput(this.id)">
								<div id="InputCity-error" class="validation-helptext <?php echo(($missing['city'] === true) ? 'display-show' : 'display-none'); ?>">Bitte bestätigen Sie das Passwort</div>
							</div>
						</div>
					</div>
					<div class="row">		
						<div class="col-lg-12 col-md-12 col-sm-12 col clearfix clear-left">
							<div class="input-group">
								<button id="buttonSubmit" type="submit" class="btn btn-primary float-left" name="reg_user">Registrieren</button>
							</div>
						</div>
					</div>
				</form>
			</section>
		</div>
	</div>
</div>