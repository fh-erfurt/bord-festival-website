<?php

namespace app\controller;
use Client;
use Address;
use Ticket;
use Cart;
use Cartitem;
use Support_mail;
use Purchase;
use Purchaseitem;


require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/ticket.class.php';
require_once 'model/cart.class.php';
require_once 'model/cartitem.class.php';
require_once 'model/support_mail.class.php';
require_once 'model/purchase.class.php';
require_once 'model/purchaseitem.class.php';


class PagesController extends \app\core\Controller
{

	public function actionIndex()
	{
		$title = "Welcome - BORD-Festival";
		$this->_params['title'] = $title;

		$this->_params['title'];
		$title;

		$date1 = new \DateTime("2020-07-31 18:00:00");
		$date2 = new \DateTime();
		$diff = $date1->getTimestamp() - $date2->getTimestamp();

		$days = floor($diff / (60 * 60 * 24));
		$hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
		$festivalstart = "31.07.2020 18:00";
		$festivalende = "02.08.2020 20:00";

		if($hours <> 1)
		{
			$hourstext = strval($hours).' Stunden';
		}
		else
		{
			$hourstext = strval($hours).' Stunde';
		}
		$this->_params['days'] = $days;
		$this->_params['hourstext'] = $hourstext;
		$this->_params['festivalstart'] = $festivalstart;
		$this->_params['festivalende'] = $festivalende;

	}

	public function actionRegister()
	{
		$title = "Registrierung - BORD-Festival";

		$this->_params['title'] = $title;

		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['reg_user']))
			{
				$mail		= $_POST['mail'] ?? null;
				$password1	= $_POST['password1'] ?? null;
				$password2	= $_POST['password2'] ?? null;

				$dateofbirth= $_POST['dateofbirth'] ?? null;
				$firstname	= $_POST['firstname'] ?? null;
				$lastname	= $_POST['lastname'] ?? null;
				$street		= $_POST['street'] ?? null;
				$zip		= $_POST['zip'] ?? null;
				$city		= $_POST['city'] ?? null;

				if($mail != null && $password1 != null && $password2 != null && $dateofbirth != null && $firstname != null &&
				   $lastname != null && $street != null && $zip != null && $city != null)
				{
					$where = 'MAIL = "'.$mail.'"';

					$client = Client::find($where);

					if(empty($client))
					{
						if($password1 === $password2)
						{
							$addressdata = [
								'STREET' 	=> $street,
								'ZIP' 		=> $zip,
								'CITY' 		=> $city,
								'COUNTRY' 	=> 'GER'						
							];
		
							$address = new Address($addressdata);
		
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
					else
					{
						$this->_params['registererror'] = 'Diese E-Mail-Adresse ist bereits registriert.
						Du kannst dich <a href="index.php?a=login" class="link">hier</a> einloggen.';
						
					}
				}
				else
				{
					$missingInformation = [];

					$missingInformation['mail'] 		= $_POST['mail'] != null ? false : true;
					$missingInformation['password1'] 	= $_POST['password1'] != null ? false : true;
					$missingInformation['password2']	= $_POST['password2'] != null ? false : true;
					$missingInformation['dateofbirth'] 	= $_POST['dateofbirth'] != null ? false : true;
					$missingInformation['firstname'] 	= $_POST['firstname'] != null ? false : true;
					$missingInformation['lastname'] 	= $_POST['lastname'] != null ? false : true;
					$missingInformation['street']		= $_POST['street'] != null ? false : true;
					$missingInformation['zip'] 			= $_POST['zip'] != null ? false : true;
					$missingInformation['city'] 		= $_POST['city'] != null ? false : true;
					
					$this->_params['missing'] = $missingInformation;

					$this->_params['registererror'] = "Bitte alle fehlenden Felder ausfüllen!";
				}
			}
		}
		else
		{
			header('Location: index.php?a=error404');
		}
	}

	public function actionLogin()
	{
		$title = "Login - BORD-Festival";

		$this->_params['title'] = $title;
		
		if(!isset($_SESSION['loggedIn']) || $_SESSION['loggedIn'] === false)
		{
			if(isset($_POST['submit']))
			{
				$mail    = $_POST['email'] ?? null;
				$password = $_POST['password'] ?? null;

				if(isset($mail) && isset($password))
				{
					$where = 'MAIL = '.$mail;

					$user = Client::find($where);
					
					if(!empty($user))
					{						
						$userdata = $user[0];

						if(password_verify($password, $userdata['PASSWORD']))
						{
							$_SESSION['loggedIn'] = true;
							$_SESSION['client_mail'] = $mail;
							$_SESSION['client_id'] = $userdata['CLIENTID'];

							header('Location: index.php');

						}
						else 
						{
							$this->_params['loginerror'] = 'E-Mail und Passwort stimmen nicht überein';
						}
					}
					else
					{
						$this->_params['loginerror'] = 'E-Mail und Passwort stimmen nicht überein';
					}
				}
				else
				{
					$this->_params['loginerror'] = 'Bitte E-Mail und Passwort eingeben!';
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
		$title = "Profil";

		$this->_params['title'] = $title;

		if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
		{
			$clientid = $_SESSION['client_id'];
			$client = Client::find('CLIENTID = ' . $clientid);
			$addressID = $client[0]['ADDRESSID'];
			$address = Address::find('ADDRESSID = ' . $addressID);

			$this->_params['mail'] = $client[0]['MAIL'];
			$this->_params['firstname'] = $client[0]['FIRSTNAME'];
			$this->_params['lastname'] = $client[0]['LASTNAME'];
			$this->_params['dateofbirth'] = $client[0]['DATEOFBIRTH'];

			$this->_params['street'] = $address[0]['STREET'];
			$this->_params['zip'] = $address[0]['ZIP'];
			$this->_params['city'] = $address[0]['CITY'];
			$this->_params['country'] = $address[0]['COUNTRY'];

			$purchase = Purchase::find('CLIENTID = '.$clientid);

			if(!empty($purchase))
			{
				$purchaseid = $purchase[0]['PURCHASEID'];
				
				$purchaseitems = Purchaseitem::find('PURCHASEID = '.$purchaseid);				
				$this->_params['purchaseitems'] = $purchaseitems;

				$purchasehistory = [];

				foreach($purchaseitems as $item)
				{
					$ticketid = $item['TICKETID'];
					$ticket = Ticket::find('TICKETID = '.$ticketid);

					$ticketname = $ticket[0]['NAME'];
					$ticketdescription = $ticket[0]['DESCRIPTION'];
					$quantity = $item['QUANTITY'];
					$price = $item['PRICE'];

					$iteminfo = [
						$ticketname,
						$ticketdescription,
						$price,
						$quantity
					];

					$purchasehistory[] = $iteminfo;
				}	

				$this->_params['purchasehistory'] = $purchasehistory;
			}
		}
		else
		{
			header('Location: index.php?c=pages&a=error404');
		}
	}

	public function actionConfirmorder()
	{
		$title = "Bestätigen";

		$this->_params['title'] = $title;

		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];
			$client = Client::find('CLIENTID = ' . $clientid);
			$cart = Cart::find('CLIENTID = ' . $clientid);
			$addressID = $client[0]['ADDRESSID'];
			$address = Address::find('ADDRESSID = ' . $addressID);

			if($cart[0]['TOTALCOUNT'] !== '0')
			{
				$this->_params['price'] = $cart[0]['TOTALPRICE'];
			
				$this->_params['street'] = $address[0]['STREET'];
				$this->_params['zip'] = $address[0]['ZIP'];
				$this->_params['city'] = $address[0]['CITY'];
				$this->_params['country'] = $address[0]['COUNTRY'];

				if(isset($_POST['deletewholecart']))
				{
					$purchase = Purchase::find('CLIENTID = ' . $clientid);

					$purchaseid = 0;

					if(empty($purchase))
					{
						$purchasedata = [
							'PURCHASEDAT'	=> date("Y-m-d H:i:s"),
							'CLIENTID' 		=> $clientid				
						];
				
						$tmppurchase = new Purchase($purchasedata);
						$tmppurchase->save();
				
						$purchaseid = $tmppurchase->schema['PURCHASEID'];
					}
					else
					{
						$purchaseid = $purchase[0]['PURCHASEID'];
					}

					$cartitems = Cartitem::find('CARTID = ' . $cart[0]['CARTID']);

					foreach($cartitems as $item)
					{
						$ticketid = $item['TICKETID'];
						$ticket = Ticket::find('TICKETID = '.$ticketid);
						$ticketprice = $ticket[0]['PRICE'];
						
						$purchaseitemdata = [
							'PURCHASEID'	=> $purchaseid,
							'TICKETID'  	=> $item['TICKETID'],
							'QUANTITY' 		=> $item['QUANTITY'],
							'PRICE'	        => $ticketprice
						];

						$purchaseitem = new Purchaseitem($purchaseitemdata);
						$purchaseitem->save();
					}

					self::deletewholecart($clientid);
					header('Location: index.php?c=pages&a=index');
				}
			}
			else
			{
				header('Location: index.php?c=pages&a=error404');
			}
		}
		else
		{
			header('Location: index.php?c=pages&a=error404');
		}
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
			
			self::CalculateCart($clientid);
		}
		else
		{
			header('Location: index.php?c=pages&a=error404');
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
			self::CalculateCart($clientid);
		}
	}

	private function CalculateCart($clientid)
	{
		$cart = Cart::find('CLIENTID = '.$clientid);

		if(empty($cart))
		{
			$this->_params['carttotalprice'] = 0;
			$this->_params['carttotalcount'] = 0;
			
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
	
				$success = 0;
				if($ticketcount !== '0')
				{
					if($ticketid !== null && $ticketcount !== null)
					{
						$cart = Cart::find('CLIENTID = '.$clientid);
						$cartid = 0;
						$oldtotalprice = 0;

						if(empty($cart))
						{
							$tmpcart = self::intizialiseCart($clientid);
							$cartid = $tmpcart->schema['CARTID'];
							$oldtotalprice = $tmpcart->schema['TOTALPRICE'];
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
						$success = 1;
					}
					else
					{
						$this->_params['updatedcartsuccess'] = false;
						$success = 0;
					}
				}
				else
				{
					$this->_params['updatedcartsuccess'] = false;
					$success = 2;
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
			$this->_params['tickets'] = $tickets;
		}
	}

	private function intizialiseCart($clientid)
	{
		$result = null;
		if(!empty($clientid))
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
			$result = $cart;
		}

		return $result;
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

	public function actionContact()
	{
		$title = "Kontakt";

		$this->_params['title'] = $title;

		if(isset($_POST['inputContact']))
		{
			$firstname = $_POST['firstname'] ?? null;
			$lastname = $_POST['lastname'] ?? null;
			$mail = $_POST['mail'] ?? null;

			$inputProblem = $_POST['problem'] ?? null;
			$inputInformation = $_POST['information'] ?? null;
			
			if($firstname != null && $lastname != null && $mail != null && $inputProblem != null && $inputInformation != null)
			{	
				$this->_params['success'] = 1;
				
				$maildata = [
					'FIRSTNAME'		=> $firstname,
					'LASTNAME'		=> $lastname,
					'MAIL'			=> $mail,
					'PROBLEM'		=> $inputProblem,
					'INFORMATION'	=> $inputInformation,
					'CREATEDAT' 	=> date("Y-m-d H:i:s")
				];

				$newSupportMail = new Support_mail($maildata);
				$newSupportMail->save();

				header('Location: index.php?a=confirmcontact');
			}
			else
			{
				$this->_params['success'] = 0;
				
				// Array containing information about which inputs are missing
				$missingInformation = [];

				$missingInformation['firstname'] 	= $_POST['firstname'] != null ? false : true;
				$missingInformation['lastname'] 	= $_POST['lastname'] != null ? false : true;
				$missingInformation['mail']			= $_POST['mail'] != null ? false : true;
				$missingInformation['problem'] 		= $_POST['problem'] != null ? false : true;
				$missingInformation['information'] 	= $_POST['information'] != null ? false : true;

				$this->_params['missing'] = $missingInformation;
			}
		}
	}

	public function actionConfirmcontact()
	{
		$title = "Kontakt";

		$this->_params['title'] = $title;
	}
}