<div class="row">
	<div class="col-lg-4 col-md-6 col-sm-12 center clear-fix">
		<h1 class="float-left clear-fix">Login</h1>
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
					<input id="InputMail" class="form-control" type="email" name="email" placeholder="E-Mail" />
					<label for="InputPassword" class="form-for">Passwort</label>
					<input id="InputPassword" class="form-control" type="password" name="password" placeholder="Passwort"/>
					<button class="btn btn-primary float-left" type="submit" name="submit">Einloggen</button>
				</div>
			</div>
		</form>
</div>