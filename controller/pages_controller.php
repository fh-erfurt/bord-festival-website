<?php

namespace app\controller;
use Client;
use Address;
use Ticket;
use Cart;
use Cartitem;

require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/ticket.class.php';
require_once 'model/cart.class.php';
require_once 'model/cartitem.class.php';

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
					//$user = new Client();

					$addressdata = [
						'STREET' 	=> $street,
						'ZIP' 		=> $zip,
						'CITY' 		=> $city,
						'COUNTRY' 	=> 'GER'						
					];

					$address = new Address($addressdata);
					// $address->STREET = $street;
					// $address->ZIP = $zip;
					// $address->CITY = $city;
					// $address->COUNTRY = 'GER';

					$address->save();

					$hashedpassword = password_hash($password1 , PASSWORD_BCRYPT);

					$clientdata = [						
						'MAIL' 			=> $mail,
						'FIRSTNAME'		=> $firstname,
						'LASTNAME' 		=> $lastname,
						'DATEOFBIRTH'	=> $dateofbirth,
						'PASSWORD' 		=> $hashedpassword,
						'CREATEDAT' 	=> date("Y-m-d H:i:s"),
						'UPDATEDAT' 	=> date("Y-m-d H:i:s"),
						'ADDRESSID' 	=> $address->schema['ADDRESSID']
					];
					$user = new Client($clientdata);
					$user->save();
					
					$_SESSION['loggedIn'] = true;
					$_SESSION['client_mail'] = $mail;
					$_SESSION['client_id'] = $user->schema['CLIENTID'];

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
					$where = 'MAIL = "'.$mail.'"';

					$user = Client::find($where);
					
					if(isset($user))
					{						
							$userdata = $user[0];

							if(password_verify($password, $userdata['PASSWORD']))
							{
								$_SESSION['loggedIn'] = true;
								$_SESSION['client_mail'] = $mail;
								$_SESSION['client_id'] = $userdata['CLIENTID'];
								header('Location: index.php');

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
			$_SESSION['client_mail'] = null;
			$_SESSION['client_id'] = null;
		}

		header('Location: index.php');
		exit();
	}


	public function actionProfile()
	{

	}

	public function actionCart()
	{
		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];
			$cart = Cart::find('CLIENTID = '.$clientid);
			$sum = 0;

			if(empty($cart))
			{
				
			}
			else
			{

				$cartid = $cart[0]['CARTID'];

				$cartitems = Cart::find('CARTID ='.$cartid);

				$carttotalprice = $cart[0]['TOTALPRICE'];

				$cartitemcount = Cartitem::count('CARTID = '.$cartid);
				$this->_params['carttotalprice'] = $carttotalprice;
				$this->_params['cartitemcount'] = $cartitemcount;
			}

		}
	}

	public function actionTicketshop()
	{
		$title = "Tickets - BORD-Festival";
		$this->_params['title'] = $title;

		if(isset($_POST['addtickettocart']))
		{
			if(isset($_SESSION['client_id']))
			{
				$clientid = $_SESSION['client_id'];
				$ticketid = $_POST['ticketid'] ?? null;
				$ticketcount = $_POST['ticketcount'] ?? null;
	
				$success = false;
	
				if($ticketid !== null && $ticketcount !== null)
				{
					$cart = Cart::find('CLIENTID = '.$clientid);
					$cartid = 0;
					$oldtotalprice = 0;

					if(empty($cart))
					{
						$cartdata = [
							'TOTALPRICE'	=> null,
							'LASTUPDATED'	=> date("Y-m-d H:i:s"),
							'CLIENTID' 		=> $clientid

						];

						$cart = new Cart($cartdata);
						$cart->save();

						$cartid = $cart->schema['CARTID'];
					}
					else
					{
						$cartid = $cart[0]['CARTID'];
						$oldtotalprice = $cart[0]['TOTALPRICE'];
					}

					$ticket = Ticket::find('TICKETID = '.$ticketid);
					$ticketprice = $ticket[0]['PRICE'];

					$addedprice = $ticketprice * $ticketcount;

					$totalprice = $oldtotalprice + $addedprice;
					
					$cartitemdata = [
						'CARTID'		=> $cartid,
						'TICKETID'  	=> $ticketid,
						'QUANTITY' 		=> $ticketcount
					];

					
					$changedcartdata = [
						'CARTID'		=> $cartid,
						'TOTALPRICE'	=> $totalprice,
						'LASTUPDATED'	=> date("Y-m-d H:i:s"),
						'CLIENTID' 		=> $clientid

					];
					$changedcart = new Cart($changedcartdata);
					$changedcart->save();

					$cartitem = new Cartitem($cartitemdata);
					$cartitem->save();

					$this->_params['updatedcartsuccess'] = true;
					$success = true;
				}
				else
				{
					$this->_params['updatedcartsuccess'] = false;
					$success = false;
				}
				// PRG (Post-Redirect-Get) Pattern to allow page reloading after using a form
				http_response_code( 303 );
				header( "Location: {$_SERVER['REQUEST_URI']}&success=".$success ); 
				exit();
			}

		}
		
		$tickets = Ticket::find();
		$ticketdata = $tickets[0];
		$this->_params['tickets'] = $tickets;
	}

	public function actionError404()
	{
		
	}
}