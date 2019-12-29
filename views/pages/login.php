<h1>Login</h1>
<?php
if(!empty($loginerror))
{
	?>
	<div class="alert alert-danger">
		<?php echo $loginerror; ?>
	</div>
	<?php
}
?>
<form method="post">
	<label for="email">E-Mail</label> <br />
	<input type="email" name="email" id="email" /><br />
	<label for="password">Passwort</label> <br />
	<input type="password" name="password" id="password" /><br />
	<br />
	<input type="submit" name="submit" value="Login now!" /><br />
</form>