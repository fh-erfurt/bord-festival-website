<h1>Registrierung</h1>
<?php
if(!empty($registererror))
{
	?>
	<div class="alert alert-danger">
		<?php echo $registererror; ?>
	</div>
	<?php
}
?>

<form method="post">
	<div class="col-lg-6 col-sm-12">
		<div class="input-group">
			<label for="InputEmail">E-Mail</label>
			<input id="InputEmail" class="form-control"type="email" name="email">
		</div>
		<div class="input-group">
			<label for="InputPassword">Passwort</label>
			<input id="InputPassword" class="form-control" type="password" name="password_1">
		</div>
		<div class="input-group">
			<label for="InputPassword2">Passwort wiederholen</label>
			<input id="InputPassword2" class="form-control" type="password" name="password_2">
		</div>
	</div>
	
	<div class="col-lg-6 col-sm-12 clear-fix">
		<div class="input-group">
			<label for="InputFirstname">Vorname</label>
			<input id="InputFirstname" class="form-control" type="text" name="vorname">
		</div>
		<div class="input-group">
			<label for="InputLastname">Nachname</label>
			<input id="InputLastname" class="form-control" type="text" name="nachname">
		</div>
		<div class="input-group">
			<label for="InputBirthday">Geburtstag</label>
			<input id="InputBirthday" class="form-control" type="date" name="geburtstag">
		</div>
		<div class="input-group">
			<label for="InputStreet">Straße und Hausnummer</label>
			<input id="InputStreet" class="form-control" type="text" name="strassehnr">
		</div>
		<div class="input-group">
			<label for="InputZip">PLZ</label>
			<input id="InputZip" class="form-control" type="text" name="plz">
		</div>
		<div class="input-group">
			<label for="InputCity">Ort</label>
			<input id="InputCity" class="form-control" type="text" name="ort">
		</div>
	</div>
	<div class="col-lg-12 clearfix clear-left">
		<div class="input-group">
			<button type="submit" class="btn btn-primary" name="reg_user">Registrieren</button>
		</div>
	</div>
      

  </form>