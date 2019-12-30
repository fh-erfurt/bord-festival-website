<div class="col-lg-4 col-md-6 col-sm-12 center clear-fix">
	<h1 class="float-left clear-fix">Login</h1>
</div>
<form method="post">
	<div class="col-lg-4 center">
<?php
if(!empty($loginerror))
{
	?>
	<div class="col-lg-12 alert alert-danger">
		<?php echo $loginerror; ?>
	</div>
	<?php
}
?>
		<label for="InputMail" class="form-for">E-Mail</label>
		<input id="InputMail" class="form-control" type="email" name="email" placeholder="E-Mail" />
		<label for="InputPassword" class="form-for">Passwort</label>
		<input id="InputPassword" class="form-control" type="password" name="password" placeholder="Passwort"/>
		<button class="btn btn-primary float-left" type="submit" name="submit">Einloggen</button>
	</div>
</form>