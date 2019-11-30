<?php

namespace app\controller;

require_once 'model/User.php';

class PagesController extends \app\core\Controller
{

	public function actionIndex()
	{
		$myValue = 4 * 4;

		$title = "Welcome - BORD-Festival";

		$this->_params['myValue'] = $myValue;
		$this->_params['title'] = $title;
	}

	public function actionRegister()
	{
		$title = "Registrierung - BORD-Festival";

		$this->_params['title'] = $title;

		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['reg_user']))
			{
				$email		= $_POST['email'] ?? null;
				$password1	= $_POST['password_1'] ?? null;
				$password2	= $_POST['password_2'] ?? null;

				$geburtstag	= $_POST['geburtstag'] ?? null;
				$vorname	= $_POST['vorname'] ?? null;
				$nachname	= $_POST['nachname'] ?? null;
				$strassehnr	= $_POST['strassehnr'] ?? null;
				$plz		= $_POST['plz'] ?? null;
				$ort		= $_POST['ort'] ?? null;

				if($password1 === $password2)
				{
					$_SESSION['loggedIn'] = true;
					header('Location: index.php');
				}
				else
				{
					$_SESSION['loggedIn'] = false;
					// ERROR: passwort nicht gleich
				}
			}
		}
		else
		{
			header('Location: index.php');
		}
	}

	public function actionLogin()
	{
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['submit']))
			{
				$email    = $_POST['email'] ?? null;
				$password = $_POST['password'] ?? null;

				if($email === 'max@fh-erfurt.de' && $password === '12345678')
				{
					$_SESSION['loggedIn'] = true;
					header('Location: index.php');
				}
				else
				{
					$_SESSION['loggedIn'] = false;
				}
			}
		}
		else
		{
			header('Location: index.php');
		}
	}

	public function actionLogout()
	{
		if($_SESSION['loggedIn'] === true)
		{
			$_SESSION['loggedIn'] = false;
		}

		header('Location: index.php');
		exit();
	}


	public function actionProfile()
	{
		if($_SESSION['loggedIn'] === true)
		{

		}
		else
		{
			header('Location: index.php');
		}
	}

	public function actionError404()
	{
		
	}
}