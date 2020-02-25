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


require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/item.class.php';
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