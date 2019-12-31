<div class="row">
	<div class="col-lg-6 col-md-10 col-sm-10 center clear-fix">
		<section>
			<h1 class="float-left clear-fix">Registrierung</h1>

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
			<form method="post">
				<div class="row">
					<div class="col-lg-6 col-md-6 col-sm-12 float-left clear-left">
						<div class="input-group">
							<label class="form-for" for="InputEmail">E-Mail</label>
							<input id="InputEmail" class="form-control"type="email" name="email" placeholder="E-Mail">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputPassword">Passwort</label>
							<input id="InputPassword" class="form-control" type="password" name="password_1" placeholder="Passwort">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputPassword2">Passwort wiederholen</label>
							<input id="InputPassword2" class="form-control" type="password" name="password_2" placeholder="Passwort wiederholen">
						</div>
					</div>
					
					<div class="col-lg-6 col-md-6 col-sm-12 float-left">
						<div class="input-group">
							<label class="form-for" for="InputFirstname">Vorname</label>
							<input id="InputFirstname" class="form-control" type="text" name="vorname" placeholder="Vorname">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputLastname">Nachname</label>
							<input id="InputLastname" class="form-control" type="text" name="nachname" placeholder="Nachname">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputBirthday">Geburtstag</label>
							<input id="InputBirthday" class="form-control" type="date" name="geburtstag">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputStreet">Straße und Hausnummer</label>
							<input id="InputStreet" class="form-control" type="text" name="strassehnr" placeholder="Straße / Hausnummer">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputZip">PLZ</label>
							<input id="InputZip" class="form-control" type="text" name="plz" placeholder="PLZ">
						</div>
						<div class="input-group">
							<label class="form-for" for="InputCity">Ort</label>
							<input id="InputCity" class="form-control" type="text" name="ort" placeholder="Ort">
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