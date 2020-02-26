<?php

namespace app\controller;
use Client;
use Address;
use Item;
use Cart;
use Cartitem;
use Support_mail;
use Purchase;
use Purchaseitem;
use Newsletter;


require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/item.class.php';
require_once 'model/cart.class.php';
require_once 'model/cartitem.class.php';
require_once 'model/support_mail.class.php';
require_once 'model/purchase.class.php';
require_once 'model/purchaseitem.class.php';
require_once 'model/newsletter.class.php';



class PagesController extends \app\core\Controller
{

	public function actionIndex()
	{
		$title = "Willkommen - BORD-Festival";
		$this->_params['title'] = $title;

		$this->_params['title'];
		$title;

		$date1 = new \DateTime("2020-07-31 18:00:00");
		$date2 = new \DateTime();
		$diff = $date1->getTimestamp() - $date2->getTimestamp();

		$days = floor($diff / (60 * 60 * 24));
		$hours = floor(($diff % (60 * 60 * 24)) / (60 * 60));
		$festivalStart = "31.07.2020 18:00";
		$festivalEnde = "02.08.2020 20:00";

		if($hours <> 1)
		{
			$hoursText = strval($hours).' Stunden';
		}
		else
		{
			$hoursText = strval($hours).' Stunde';
		}
		$this->_params['days'] = $days;
		$this->_params['hoursText'] = $hoursText;
		$this->_params['festivalStart'] = $festivalStart;
		$this->_params['festivalEnde'] = $festivalEnde;

		if(isset($_POST['reg_newsletter']))
		{
			$mail = $_POST['email'] ?? null;

			if($mail != null)
			{
				$mail = $_POST['email'];
	
				$newsletterMailData = [
					'mail' 		=> $mail,
					'createdat' => date("Y-m-d H:i:s")
				];
	
				$newsletterMail = new Newsletter($newsletterMailData);
				$newsletterMail->save();

				$this->_params['valid'] = true;
			}
			else
			{
				$this->_params['valid'] = false;	
			}
		}
	}

	public function actionError404()
	{
		
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
			$this->_params['cartTotalPrice'] = 0;
			$this->_params['cartTotalCount'] = 0;
			
		}
		else
		{
			$cartid = $cart[0]['cartid'];
			$cartitems = Cart::find('cartid ='.$cartid);
			$cartTotalPrice = $cart[0]['totalprice'];
			$cartTotalCount = $cart[0]['totalcount'];
			$this->_params['cartTotalPrice'] = $cartTotalPrice;
			$this->_params['cartTotalCount'] = $cartTotalCount;
		}
	}

	public function actionImpressum()
	{
		$title = "Impressum - BORD-Festival";
	}
}