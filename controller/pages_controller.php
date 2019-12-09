<?php

namespace app\controller;
use app\model\Client;
use app\model\Address;
use app\model\Ticket;

require_once 'model/User.php';
require_once 'model/Address.php';
require_once 'model/Ticket.php';

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

					$hashedpassword = password_hash($password1 , PASSWORD_BCRYPT);

					$user->MAIL 		= $mail;
					$user->FIRSTNAME 	= $firstname;
					$user->LASTNAME 	= $lastname;
					$user->DATEOFBIRTH 	= $dateofbirth;
					$user->PASSWORD 	= $hashedpassword;
					$user->CREATEDAT 	= date("Y-m-d H:i:s");
					$user->UPDATEDAT 	= date("Y-m-d H:i:s");
					$user->ADDRESSID 	= $address->ADDRESSID;

					//Clientsave?
					
					$user->save();
					
					$_SESSION['loggedIn'] = true;
					$_SESSION['client_mail'] = $mail;
					$_SESSION['client_id'] = $user->CLIENTID;
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
		// TODO: else-Zweig für Fehlerbehandlung
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['submit']))
			{
				$mail    = $_POST['email'] ?? null;
				$password = $_POST['password'] ?? null;

				if(isset($mail) && isset($password))
				{
					$filterOptions = [
						'bind' => [':mail' => $mail],
						'criteria' => 'mail = :mail'
					];

					$user = Client::findFirst($filterOptions);
					if(isset($user))
					{
							if(password_verify($password, $user->PASSWORD))
							{
								$_SESSION['loggedIn'] = true;
								$_SESSION['client_mail'] = $mail;
								$_SESSION['client_id'] = $user->CLIENTID;

							}
							else {
								// TODO
							}
					}
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
		
	}

	public function actionTicketshop()
	{
		$tickets = Ticket::findAll();
		$this->_params['tickets'] = $tickets;
	}

	public function actionError404()
	{
		
	}
}