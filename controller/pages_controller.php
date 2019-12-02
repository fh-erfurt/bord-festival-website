<?php

namespace app\controller;
use app\model\Client;
use app\model\Address;

require_once 'model/User.php';
require_once 'model/Address.php';

class PagesController extends \app\core\Controller
{

	public function actionIndex()
	{
		$title = "Welcome - BORD-Festival";

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
				$mail		= $_POST['email'] ?? null;
				$password1	= $_POST['password_1'] ?? null;
				$password2	= $_POST['password_2'] ?? null;

				$dateofbirth= $_POST['geburtstag'] ?? null;
				$firstname	= $_POST['vorname'] ?? null;
				$lastname	= $_POST['nachname'] ?? null;
				$street		= $_POST['strassehnr'] ?? null;
				$zip		= $_POST['plz'] ?? null;
				$city		= $_POST['ort'] ?? null;

				if($password1 === $password2)
				{
					$user = new Client();

					$address = new Address();
					$address->STREET = $street;
					$address->ZIP = $zip;
					$address->CITY = $city;
					$address->COUNTRY = 'GER';

					$address->save();

					$user->MAIL 		= $mail;
					$user->FIRSTNAME 	= $firstname;
					$user->LASTNAME 	= $lastname;
					$user->DATEOFBIRTH 	= $dateofbirth;
					$user->PASSWORD 	= $password1;
					$user->SALT 		= '34trzgh34g';
					$user->CREATEDAT 	= date("Y-m-d H:i:s");
					$user->UPDATEDAT 	= date("Y-m-d H:i:s");
					$user->ADDRESSID 	= $address->ADDRESSID;
					
					$user->save();
					
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