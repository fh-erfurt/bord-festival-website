<?php

namespace app\controller;
use Client;
use Address;
use Cart;
use Purchase;
use Purchaseitem;
use Item;
require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/cart.class.php';
require_once 'model/purchase.class.php';
require_once 'model/purchaseitem.class.php';
require_once 'model/item.class.php';

class AccountController extends \app\core\Controller
{
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
                $mail    = $_POST['mail'] ?? null;
                $password = $_POST['password'] ?? null;

                if($mail != null && $password != null)
                {
                    $where = 'MAIL = "'.$mail.'"';

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
                    $missingInformation = [];

                    $missingInformation['mail'] = $mail != null ? false : true;
                    $missingInformation['password'] = $password != null ? false : true;

                    $this->_params['missing'] = $missingInformation;
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

            $purchases = Purchase::find('CLIENTID = '.$clientid);

            if(!empty($purchases))
            {
                $purchasehistory = [];

                foreach($purchases as $purchase)
                {
                    $purchaseid = $purchase['PURCHASEID'];
                    $purchasedat = $purchase['PURCHASEDAT'];
                    
                    $purchaseitems = Purchaseitem::find('PURCHASEID = '.$purchaseid);
    
                    $iteminfo = [];
                    $totalprice = 0;
    
                    foreach($purchaseitems as $purchaseitem)
                    {
                        $itemid = $purchaseitem['ITEMID'];
                        $item = Item::find('ITEMID = '.$itemid);
    
                        $itemname = $item[0]['NAME'];
                        $itemdescription = $item[0]['DESCRIPTION'];
                        $quantity = $purchaseitem['QUANTITY'];
                        $price = $purchaseitem['PRICE'];
    
                        $iteminfo[] = [
                            'NAME'          =>  $itemname,
                            'DESCRIPTION'   =>  $itemdescription,
                            'ITEMPRICE'     =>  $price,
                            'QUANTITY'      =>  $quantity
                        ];
                        $totalprice += $price * $quantity;

                    }

                    $purchasehistory[] = [
                        'PURCHASEDAT'   =>  $purchasedat,
                        'TOTALPRICE'    =>  $totalprice,
                        'ITEMINFO'      =>  $iteminfo
                    ];

                }
                //die(var_dump($purchasehistory));

                $this->_params['purchasehistory'] = $purchasehistory;
            }
        }
        else
        {
            header('Location: index.php?c=pages&a=error404');
        }
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
}