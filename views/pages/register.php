<div class="row">
	<div class="col-lg-6 col-md-10 col-sm-10 center clear-fix">
		<section>
			<h1 class="float-left clear-fix">Registrierung</h1>

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
			<form method="post">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
						<div class="input-group">
							<label class="form-for" for="InputEmail">E-Mail</label>
							<input id="InputEmail" class="form-control <?php echo($missing['mail'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="mail" placeholder="E-Mail">
							<?php if($missing['mail'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihre E-Mail an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputPassword">Passwort</label>
							<input id="InputPassword" class="form-control <?php echo($missing['password1'] === false) ? '' : 'text-validate-red' ?>"
							       type="text" name="password1" placeholder="Passwort">
							<?php if($missing['password1'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie ein Passwort an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputPassword2">Passwort wiederholen</label>
							<input id="InputPassword2" class="form-control <?php echo($missing['password2'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="password2" placeholder="Passwort wiederholen">
							<?php if($missing['password2'] === true) : ?>
								<div class="validation-helptext">Bitte bestätigen Sie das Passwort</div>
							<?php endif; ?>
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12 float-left">
						<div class="input-group">
							<label class="form-for" for="InputFirstname">Vorname</label>
							<input id="InputFirstname" class="form-control <?php echo($missing['firstname'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="firstname" placeholder="Vorname">
							<?php if($missing['firstname'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihren Vornamen an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputLastname">Nachname</label>
							<input id="InputLastname" class="form-control <?php echo($missing['lastname'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="lastname" placeholder="Nachname">
							<?php if($missing['lastname'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihren Nachnamen an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputBirthday">Geburtsdatum</label>
							<input id="InputBirthday" class="form-control <?php echo($missing['dateofbirth'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="dateofbirth" placeholder="Geburtsdatum">
							<?php if($missing['dateofbirth'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihr Geburtsdatum an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputStreet">Straße und Hausnummer</label>
							<input id="InputStreet" class="form-control <?php echo($missing['street'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="street" placeholder="Straße / Hausnummer">
							<?php if($missing['street'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihre Straße und Hausnummer an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputZip">PLZ</label>
							<input id="InputZip" class="form-control <?php echo($missing['zip'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="zip" placeholder="PLZ">
							<?php if($missing['zip'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihre Postleitzahl an</div>
							<?php endif; ?>
						</div>
						<div class="input-group">
							<label class="form-for" for="InputCity">Ort</label>
							<input id="InputCity" class="form-control <?php echo($missing['city'] === false) ? '' : 'text-validate-red' ?>"
								   type="text" name="city" placeholder="Ort">
							<?php if($missing['city'] === true) : ?>
								<div class="validation-helptext">Bitte geben Sie Ihren Ort an</div>
							<?php endif; ?>
						</div>
					</div>
				</div>
				<div class="row">		
					<div class="col-lg-12 col-md-12 col-sm-12 col clearfix clear-left">
						<div class="input-group">
							<button type="submit" class="btn btn-primary float-left" name="reg_user">Registrieren</button>
						</div>
					</div>
				</div>
			</form>
		</section>
	</div>
</div>