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

        $this->_params['countryList'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

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
                $country    = $_POST['country'] ?? null;

                if($mail != null && $password1 != null && $password2 != null && $dateofbirth != null && $firstname != null &&
                $lastname != null && $street != null && $zip != null && $city != null && $country != null)
                {
                    $where = 'MAIL = "'.$mail.'"';

                    $client = Client::find($where);

                    if(empty($client))
                    {
                        if($password1 === $password2)
                        {
                            $addressdata = [
                                'street' 	=> $street,
                                'zip' 		=> $zip,
                                'city' 		=> $city,
                                'country' 	=> $country						
                            ];
        
                            $address = new Address($addressdata);
        
                            $address->save();
        
                            $hashedpassword = password_hash($password1 , PASSWORD_BCRYPT);
        
                            $clientdata = [						
                                'mail' 			=> $mail,
                                'firstname'		=> $firstname,
                                'lastname' 		=> $lastname,
                                'dateofbirth'	=> $dateofbirth,
                                'password' 		=> $hashedpassword,
                                'createdat' 	=> date("Y-m-d H:i:s"),
                                'updatedat' 	=> date("Y-m-d H:i:s"),
                                'addressid' 	=> $address->schema['addressid']
                            ];

                            $user = new Client($clientdata);
                            $user->save();
                            
                            $_SESSION['loggedIn'] = true;
                            $_SESSION['client_mail'] = $mail;
                            $_SESSION['client_id'] = $user->schema['clientid'];
        
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
                        Du kannst dich <a href="index.php?c=account&a=login" class="link">hier</a> einloggen.';
                        
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
                    $missingInformation['country'] 		= $_POST['country'] != null ? false : true;
                    
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
                    $where = 'mail = "'.$mail.'"';

                    $user = Client::find($where);
                    
                    if(!empty($user))
                    {						
                        $userdata = $user[0];

                        if(password_verify($password, $userdata['password']))
                        {
                            $_SESSION['loggedIn'] = true;
                            $_SESSION['client_mail'] = $mail;
                            $_SESSION['client_id'] = $userdata['clientid'];

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

        $this->_params['countryList'] = array("Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra", "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina", "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan", "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus", "Belgium", "Belize", "Benin", "Bermuda", "Bhutan", "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil", "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi", "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands", "Central African Republic", "Chad", "Chile", "China", "Christmas Island", "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the", "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba", "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica", "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador", "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)", "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan", "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia", "Georgia", "Germany", "Ghana", "Gibraltar", "Greece", "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala", "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands", "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland", "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel", "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan", "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait", "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho", "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg", "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia", "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique", "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of", "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco", "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal", "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua", "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands", "Norway", "Oman", "Pakistan", "Palau", "Panama", "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn", "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion", "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia", "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal", "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia", "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain", "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname", "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic", "Taiwan, Province of China", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo", "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey", "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine", "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay", "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)", "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia", "Zambia", "Zimbabwe");

        $clientid = $_SESSION['client_id'];
        $client = Client::find('clientid = ' . $clientid);
        $addressid = $client[0]['addressid'];
        $address = Address::find('addressid = ' . $addressid);

        if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] === true)
        {
            if(!isset($_POST['updateaccount']))
            {
                $this->_params['mail']          = $client[0]['mail'];
                $this->_params['firstname']     = $client[0]['firstname'];
                $this->_params['lastname']      = $client[0]['lastname'];
                $this->_params['dateofbirth']   = $client[0]['dateofbirth'];
                $this->_params['street']        = $address[0]['street'];
                $this->_params['zip']           = $address[0]['zip'];
                $this->_params['city']          = $address[0]['city'];
                $this->_params['country']       = $address[0]['country'];    
            }
            else
            {
                $mail = $_POST['mail'] ?? null;
                $password = $_POST['password'] ?? null;
                $firstname = $_POST['firstname']  ?? null;
                $lastname = $_POST['lastname']  ?? null;
                $dateofbirth = $_POST['dateofbirth']  ?? null;
                $street = $_POST['street']  ?? null;
                $zip = $_POST['zip']  ?? null;
                $city = $_POST['city']  ?? null;
                $country = $_POST['country']  ?? null;

                if($mail != null && $firstname != null && $lastname != null && $dateofbirth != null &&
                   $street != null && $zip != null && $city != null && $country != null)
                {                  
                    $clientdata = $client[0];

                    if(password_verify($password, $clientdata['password']))
                    {
                        $updatedaddressdata = [
                            'addressid' => $addressid,
                            'street'    => $street,
                            'zip'       => $zip,
                            'city'      => $city,
                            'country'   => $country
                        ];
                        
                        $updatedaddress = new Address($updatedaddressdata);
                        $updatedaddress->save();

                        $hashedpassword = $clientdata['password'];
                        $createdat = $clientdata['createdat'];

                        $updatedclientdata = [
                            'clientid'      => $clientid,
                            'mail'          => $mail,
                            'firstname'     => $firstname,
                            'lastname'      => $lastname,
                            'dateofbirth'   => $dateofbirth,
                            'createdat'     => $createdat,
                            'updatedat'     => date("Y-m-d H:i:s"),
                            'adressid'      => $addressid
                        ];
                        
                        $updatedclient = new Client($updatedclientdata);
                        $updatedclient->save(); 
                                                                
                        $this->_params['mail']        = $mail;
                        $this->_params['firstname']   = $firstname;
                        $this->_params['lastname']    = $lastname;
                        $this->_params['dateofbirth'] = $dateofbirth;
                        $this->_params['street']      = $street;
                        $this->_params['zip']         = $zip;
                        $this->_params['city']        = $city;
                        $this->_params['country']     = $country;
                    }
                    else
                    {
                        $this->_params['mail']        = $mail;
                        $this->_params['firstname']   = $firstname;
                        $this->_params['lastname']    = $lastname;
                        $this->_params['dateofbirth'] = $dateofbirth;
                        $this->_params['street']      = $street;
                        $this->_params['zip']         = $zip;
                        $this->_params['city']        = $city;
                        $this->_params['country']     = $country;

                        $this->_params['updateerror'] = "Passwort nicht korrekt!";
                    }
                }
                else
                {
                    $this->_params['mail']        = $mail;
                    $this->_params['firstname']   = $firstname;
                    $this->_params['lastname']    = $lastname;
                    $this->_params['dateofbirth'] = $dateofbirth;
                    $this->_params['street']      = $street;
                    $this->_params['zip']         = $zip;
                    $this->_params['city']        = $city;
                    $this->_params['country']     = $country;

                    $missingInformation = [];

                    $missingInformation['mail']         = $mail != null ? false : true;
                    $missingInformation['firstname'] 	= $firstname != null ? false : true;
                    $missingInformation['lastname'] 	= $lastname != null ? false : true;
                    $missingInformation['dateofbirth']  = $dateofbirth != null ? false : true;
                    $missingInformation['street']		= $street != null ? false : true;
                    $missingInformation['zip']          = $zip != null ? false : true;
                    $missingInformation['city'] 		= $city != null ? false : true;
                    $missingInformation['country'] 		= $country != null ? false : true;
                    
                    $this->_params['missing'] = $missingInformation;

                    $this->_params['updateerror'] = "Bitte alle fehlenden Felder ausfüllen!";
                }
            }

            $purchases = Purchase::find('clientid = '.$clientid);

            if(!empty($purchases))
            {
                $purchasehistory = [];

                foreach($purchases as $purchase)
                {
                    $purchaseid = $purchase['purchaseid'];
                    $purchasedat = $purchase['purchasedat'];
                    
                    $purchaseitems = Purchaseitem::find('purchaseid = '.$purchaseid);
    
                    $iteminfo = [];
                    $totalprice = 0;
    
                    foreach($purchaseitems as $purchaseitem)
                    {
                        $itemid = $purchaseitem['itemid'];
                        $item = Item::find('itemid = '.$itemid);
    
                        $itemname = $item[0]['name'];
                        $itemdescription = $item[0]['description'];
                        $quantity = $purchaseitem['quantity'];
                        $price = $purchaseitem['price'];
                        $imageurl = $item[0]['imageurl'];
    
                        $iteminfo[] = [
                            'name'          =>  $itemname,
                            'description'   =>  $itemdescription,
                            'itemprice'     =>  $price,
                            'quantity'      =>  $quantity,
                            'imageurl'      =>  $imageurl
                        ];
                        $totalprice += $price * $quantity;

                    }

                    $purchasehistory[] = [
                        'purchasedat'   =>  $purchasedat,
                        'totalprice'    =>  $totalprice,
                        'iteminfo'      =>  $iteminfo
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
		$cart = Cart::find('clientid = '.$clientid);
		if(empty($cart))
		{
			$this->_params['carttotalprice'] = 0;
			$this->_params['carttotalcount'] = 0;
			
		}
		else
		{
			$cartid = $cart[0]['cartid'];
			$cartitems = Cart::find('cartid ='.$cartid);
			$carttotalprice = $cart[0]['totalprice'];
			$carttotalcount = $cart[0]['totalcount'];
			$this->_params['carttotalprice'] = $carttotalprice;
			$this->_params['carttotalcount'] = $carttotalcount;
		}
	}
}