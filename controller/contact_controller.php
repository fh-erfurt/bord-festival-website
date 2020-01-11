<?php

namespace app\controller;

use Support_mail;
use Cart;

require_once 'model/support_mail.class.php';
require_once 'model/cart.class.php';

class ContactController extends \app\core\Controller
{
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
			$inputInformation = trim($_POST['information']) ?? null;
			
			if($firstname != null && $lastname != null && $mail != null && $inputProblem != null && $inputInformation != null)
			{	
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

				header('Location: index.php?c=contact&a=confirmcontact');
			}
			else
			{
				$this->_params['contacterror'] = 'Bitte alle fehlenden Felder ausfüllen!';
				
				// Array containing information about which inputs are missing
				$missingInformation = [];

				$missingInformation['firstname'] 	= $firstname != null ? false : true;
				$missingInformation['lastname'] 	= $lastname != null ? false : true;
				$missingInformation['mail']			= $mail != null ? false : true;
				$missingInformation['problem'] 		= $inputProblem != null ? false : true;
				$missingInformation['information'] 	= $inputInformation != null ? false : true;

				$this->_params['missing'] = $missingInformation;
			}
		}
	}

	public function actionConfirmcontact()
	{
		$title = "Kontakt";

		$this->_params['title'] = $title;
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