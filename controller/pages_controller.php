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
		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
		{
			$userID = $_SESSION['client_id'];
			$user = Client::findFirst($userID);
			$addressID = $user->addressID;
			$address = Address::findFirst($addressID);

			$this->_params['MAIL'] = $user->__get('MAIL');
			$this->_params['FIRSTNAME'] = $user->__get('FIRSTNAME');
			$this->_params['LASTNAME'] = $user->__get('LASTNAME');
			$this->_params['DATEOFBIRTH'] = $user->__get('DATEOFBIRTH');

			$this->_params['STREET'] = $address->__get('STREET');
			$this->_params['ZIP'] = $address->__get('ZIP');
			$this->_params['CITY'] = $address->__get('CITY');
			$this->_params['COUNTRY'] = $address->__get('COUNTRY');
		}
		else
		{
			header('Location: index.php?c=pages&a=error404');
		}
	}

	public function actionConfirmorder()
	{

	}

	public function actionShoppingcart()
	{
		$title = "Warenkorb - BORD-Festival";

		$this->_params['title'] = $title;

		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];

			if(isset($_POST['deleteitemfromcart']))
			{
				$cartitemid = $_POST['cartitemid'] ?? null;
				
				$success = false;
				if($cartitemid !== null)
				{
					$cartitem = Cartitem::find('CARTITEMID = '.$cartitemid);
					$cartid = 0;

					if(!empty($cartitem))
					{
						$cartitemdata = [
							'CARTITEMID'	=> $cartitem[0]['CARTITEMID'],
							'CARTID'		=> $cartitem[0]['CARTID'],
							'TICKETID'  	=> $cartitem[0]['TICKETID'],
							'QUANTITY' 		=> $cartitem[0]['QUANTITY'],
						];

						$cartid = $cartitem[0]['CARTID'];
						$newcartitem = new Cartitem($cartitemdata);
						$newcartitem->delete();

						//update total
						self::updateCart($cartid, $clientid);
													
						$success = true;
					}
				}
				
				// PRG (Post-Redirect-Get) Pattern to allow page reloading after using a form
				http_response_code( 303 );
				header( "Location: {$_SERVER['REQUEST_URI']}&success=".$success ); 
				exit();	
			}

			if(isset($_POST['deletewholecart']))
			{
				$success = self::deleteWholecart($clientid);
				http_response_code( 303 );
				header( "Location: {$_SERVER['REQUEST_URI']}&success=".$success ); 
				exit();	
			}

			if(isset($_POST['buycart']))
			{
				header('Location: index.php?a=confirmorder');
			}

			$cart = Cart::find('CLIENTID = '.$clientid);
			$sum = 0;

			if(!empty($cart))
			{
				$cartid = $cart[0]['CARTID'];

				$carttotalprice = $cart[0]['TOTALPRICE'];
				$cartitemcount = Cartitem::count('CARTID = '.$cartid);
				$this->_params['carttotalprice'] = $carttotalprice;
				$this->_params['cartitemcount'] = $cartitemcount;	
				
				$cartitems = Cartitem::find('CARTID = '.$cartid);				
				$this->_params['cartitems'] = $cartitems;

				$shoppingcart = [];

				foreach($cartitems as $item)
				{
					// CartitemId is needed to remove a cartitem-entry, if the Client deletes a ticket in his shoppingcart
					$cartitemid = $item['CARTITEMID'];
					$ticketid = $item['TICKETID'];
					$ticket = Ticket::find('TICKETID = '.$ticketid);

					$ticketname = $ticket[0]['NAME'];
					$ticketdescription = $ticket[0]['DESCRIPTION'];
					$ticketprice = $ticket[0]['PRICE'];
					$quantity = $item['QUANTITY'];

					$iteminfo = [
						$cartitemid,
						$ticketname,
						$ticketdescription,
						$ticketprice,
						$quantity
					];

					$shoppingcart[] = $iteminfo;
				}	

				$this->_params['shoppingcart'] = $shoppingcart;
			}
		}

	}

	private function deleteWholecart($clientid)
	{		
		$cart = Cart::find('CLIENTID = '.$clientid);
		$success = false;

		if(!empty($cart))
		{					
			$cartid = $cart[0]['CARTID'];
			$cartitemdata = Cartitem::find('CARTID = '.$cartid);

			if(!empty($cartitemdata))
			{
				$cartitem = new Cartitem($cartitemdata[0]);
				$where = 'CARTID = '.$cartid;
				$cartitem->delete($where);
				self::updateCart($cartid, $clientid);
				$success = true;
			}			
		}

		return $success;
	}

	public function actionNavbar()
	{
		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];
			$cart = Cart::find('CLIENTID = '.$clientid);

			if(empty($cart))
			{
				$this->_params['carttotalprice'] = 0;
				$this->_params['cartitemcount'] = 0;
				
			}
			else
			{

				$cartid = $cart[0]['CARTID'];

				$cartitems = Cart::find('CARTID ='.$cartid);

				$carttotalprice = $cart[0]['TOTALPRICE'];

				$carttotalcount = $cart[0]['TOTALCOUNT'];
				$this->_params['carttotalprice'] = $carttotalprice;
				$this->_params['carttotalcount'] = $carttotalcount;
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
							'TOTALCOUNT'	=> null,
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

					$cartitem = Cartitem::find('CARTID = '.$cartid.' AND TICKETID = '.$ticketid);

					if(empty($cartitem))
					{
						$cartitemdata = [
							'CARTID'		=> $cartid,
							'TICKETID'  	=> $ticketid,
							'QUANTITY' 		=> $ticketcount
						];
					}
					else
					{
						$oldticketcount = $cartitem[0]['QUANTITY'];
						$newticketcount = $oldticketcount + $ticketcount;
						$cartitemdata = [
							'CARTITEMID'	=> $cartitem[0]['CARTITEMID'],
							'CARTID'		=> $cartid,
							'TICKETID'  	=> $ticketid,
							'QUANTITY' 		=> $newticketcount
						];
						//die(var_dump($cartitemdata));

					}
					$newcartitem = new Cartitem($cartitemdata);
					$newcartitem->save();

					//update total
					self::updateCart($cartid, $clientid);

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
		if(!empty($tickets))
		{
			$ticketdata = $tickets[0];
			$this->_params['tickets'] = $tickets;
		}
	}

	public function actionError404()
	{
		
	}

	private function updateCart($cartid, $clientid)
	{
		$cartitems = Cartitem::find('CARTID = '.$cartid);

		$totalprice = 0;
		$totalcount = 0;

		foreach($cartitems as $item)
		{
			$ticketid = $item['TICKETID'];
			$ticket = Ticket::find('TICKETID = '.$ticketid);
			$ticketprice = $ticket[0]['PRICE'];
			$quantity = $item['QUANTITY'];

			$totalprice += $quantity * $ticketprice;
			$totalcount += $quantity;
		}

		$changedcartdata = [
			'CARTID'		=> $cartid,
			'TOTALPRICE'	=> $totalprice,
			'TOTALCOUNT'	=> $totalcount,
			'LASTUPDATED'	=> date("Y-m-d H:i:s"),
			'CLIENTID' 		=> $clientid
		];

		$changedcart = new Cart($changedcartdata);
		$changedcart->save();

		/*
		$ticket = Ticket::find('TICKETID = '.$ticketid);
		$ticketprice = $ticket[0]['PRICE'];

		$addedprice = $ticketprice * $ticketcount;

		if($operator === '+')
		{
			$totalprice = $oldtotalprice + $addedprice;

		}
		else if($operator === '-')
		{
			$totalprice = $oldtotalprice - $addedprice;
		}
		else
		{

		}

		$changedcartdata = [
			'CARTID'		=> $cartid,
			'TOTALPRICE'	=> $totalprice,
			'LASTUPDATED'	=> date("Y-m-d H:i:s"),
			'CLIENTID' 		=> $clientid
		];

		$changedcart = new Cart($changedcartdata);
		$changedcart->save();
		*/
	}
}