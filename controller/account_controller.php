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
                            $this->_params['registererror'] = 'Die Passwörter stimmen nicht überein.';
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
        $title = "Profil - BORD-Festival";

        $this->_params['title'] = $title;

        $clientid = $_SESSION['client_id'];
        $client = Client::find('CLIENTID = ' . $clientid);
        $addressid = $client[0]['ADDRESSID'];
        $address = Address::find('ADDRESSID = ' . $addressid);

        $accdata = [];

        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
        {
            if(!isset($_POST['updateaccount']))
            {
                $accdata['E-Mail']          = $client[0]['MAIL'];
                $accdata['Vorname']         = $client[0]['FIRSTNAME'];
                $accdata['Nachname']        = $client[0]['LASTNAME'];
                $accdata['Geburtsdatum']    = $client[0]['DATEOFBIRTH'];
                $accdata['Straße']          = $address[0]['STREET'];
                $accdata['Postleitzahl']    = $address[0]['ZIP'];
                $accdata['Stadt']           = $address[0]['CITY'];
                $accdata['Land']            = $address[0]['COUNTRY'];    
            }
            else
            {
                $mail = $_POST['E-Mail'] ?? null;
                $password = $_POST['password'] ?? null;
                $firstname = $_POST['Vorname']  ?? null;
                $lastname = $_POST['Nachname']  ?? null;
                $dateofbirth = $_POST['Geburtsdatum']  ?? null;
                $street = $_POST['Straße']  ?? null;
                $zip = $_POST['Postleitzahl']  ?? null;
                $city = $_POST['Stadt']  ?? null;
                $country = $_POST['Land']  ?? null;

                if($mail != null && $firstname != null && $lastname != null && $dateofbirth != null &&
                   $street != null && $zip != null && $city != null && $country != null)
                {                  
                    $clientdata = $client[0];

                    if(password_verify($password, $clientdata['PASSWORD']))
                    {
                        $updatedaddressdata = [
                            'ADDRESSID' => $addressid,
                            'STREET'    => $street,
                            'ZIP'       => $zip,
                            'CITY'      => $city,
                            'COUNTRY'   => $country
                        ];
                        
                        $updatedaddress = new Address($updatedaddressdata);
                        $updatedaddress->save();

                        $hashedpassword = $clientdata['PASSWORD'];
                        $createdat = $clientdata['CREATEDAT'];

                        $updatedclientdata = [
                            'CLIENTID'      => $clientid,
                            'MAIL'          => $mail,
                            'FIRSTNAME'     => $firstname,
                            'LASTNAME'      => $lastname,
                            'DATEOFBIRTH'   => $dateofbirth,
                            'CREATEDAT'     => $createdat,
                            'UPDATEDAT'     => date("Y-m-d H:i:s"),
                            'ADRESSID'      => $addressid
                        ];
                        
                        $updatedclient = new Client($updatedclientdata);
                        $updatedclient->save(); 
                                                                
                        $accdata['E-Mail']          = $mail;
                        $accdata['Vorname']         = $firstname;
                        $accdata['Nachname']        = $lastname;
                        $accdata['Geburtsdatum']    = $dateofbirth;
                        $accdata['Straße']          = $street;
                        $accdata['Postleitzahl']    = $zip;
                        $accdata['Stadt']           = $city;
                        $accdata['Land']            = $country;
                    }
                    else
                    {
                        $accdata['E-Mail']          = $mail;
                        $accdata['Vorname']         = $firstname;
                        $accdata['Nachname']        = $lastname;
                        $accdata['Geburtsdatum']    = $dateofbirth;
                        $accdata['Straße']          = $street;
                        $accdata['Postleitzahl']    = $zip;
                        $accdata['Stadt']           = $city;
                        $accdata['Land']            = $country;

                        $this->_params['updateerror'] = "Passwort nicht korrekt!";
                    }
                }
                else
                {
                    $accdata['E-Mail']          = ltrim($mail);
                    $accdata['Vorname']         = ltrim($firstname);
                    $accdata['Nachname']        = ltrim($lastname);
                    $accdata['Geburtsdatum']    = ltrim($dateofbirth);
                    $accdata['Straße']          = ltrim($street);
                    $accdata['Postleitzahl']    = ltrim($zip);
                    $accdata['Stadt']           = ltrim($city);
                    $accdata['Land']            = ltrim($country);

                    $missingInformation = [];

                    $missingInformation['E-Mail'] 		= $mail != null ? false : true;
                    $missingInformation['Vorname'] 	    = $firstname != null ? false : true;
                    $missingInformation['Nachname'] 	= $lastname != null ? false : true;
                    $missingInformation['Geburtsdatum'] = $dateofbirth != null ? false : true;
                    $missingInformation['Straße']		= $street != null ? false : true;
                    $missingInformation['Postleitzahl'] = $zip != null ? false : true;
                    $missingInformation['Stadt'] 		= $city != null ? false : true;
                    $missingInformation['Land'] 		= $country != null ? false : true;
                    
                    $this->_params['missing'] = $missingInformation;

                    $this->_params['updateerror'] = "Bitte alle fehlenden Felder ausfüllen!";
                }
            }

            $this->_params['accdata'] = $accdata;

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
                        $imageurl = $item[0]['IMAGEURL'];
    
                        $iteminfo[] = [
                            'NAME'          =>  $itemname,
                            'DESCRIPTION'   =>  $itemdescription,
                            'ITEMPRICE'     =>  $price,
                            'QUANTITY'      =>  $quantity,
                            'IMAGEURL'      =>  $imageurl
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

        if(isset($_POST['updateaccount']))
        {
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