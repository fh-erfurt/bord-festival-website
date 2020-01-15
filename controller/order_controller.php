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


class OrderController extends \app\core\Controller
{
	public function actionShop()
	{
		$title = "Shop - BORD-Festival";
		$this->_params['title'] = $title;

		if(isset($_GET['t']))
		{
			$type = $_GET['t'];
			$type = \addslashes($type);

			$where = 'category = "'.$type.'"';			
		
			$items = Item::find($where);
			if(!empty($items))
			{
				$this->_params['items'] = $items;
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

		if(isset($_POST['additemtocart']))
		{
			if(isset($_SESSION['client_id']))
			{
				$clientid = $_SESSION['client_id'];
				$itemid = $_POST['itemid'] ?? null;
				$itemcount = $_POST['itemcount'] ?? null;
				$itemcategory = $_POST['itemcategory'] ?? null;
				$itemfiltercategory = $_POST['itemfiltercategory'] ?? null;
	
				$success = 0;
				if($itemcount !== '0')
				{
					if($itemid !== null && $itemcount !== null)
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

						$cartitem = Cartitem::find('CARTID = '.$cartid.' AND ITEMID = '.$itemid);

						if(empty($cartitem))
						{
							$cartitemdata = [
								'CARTID'			=> $cartid,
								'ITEMID'  			=> $itemid,
								'QUANTITY' 			=> $itemcount,
								'CATEGORY'			=> $itemcategory,
								'FILTERCATEGORY'	=> $itemfiltercategory
							];
						}
						else
						{
							$olditemcount = $cartitem[0]['QUANTITY'];
							$newitemcount = $olditemcount + $itemcount;
							$cartitemdata = [
								'CARTITEMID'		=> $cartitem[0]['CARTITEMID'],
								'CARTID'			=> $cartid,
								'ITEMID'  			=> $itemid,
								'QUANTITY' 			=> $newitemcount,
								'CATEGORY'			=> $itemcategory,
								'FILTERCATEGORY'	=> $itemfiltercategory
							];

						}
						//die(var_dump($cartitemdata));
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
    }
    
    public function intizialiseCart($clientid)
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
							'CARTITEMID'		=> $cartitem[0]['CARTITEMID'],
							'CARTID'			=> $cartitem[0]['CARTID'],
							'ITEMID'  			=> $cartitem[0]['ITEMID'],
							'QUANTITY' 			=> $cartitem[0]['QUANTITY'],
							'CATEGORY'			=> $cartitem[0]['CATEGORY'],
							'FILTERCATEGORY'	=> $cartitem[0]['FILTERCATEGORY']
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
				header('Location: index.php?c=order&a=confirmorder');
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

				foreach($cartitems as $cartitem)
				{
					// CartitemId is needed to remove a cartitem-entry, if the Client deletes a item in his shoppingcart
					$cartitemid = $cartitem['CARTITEMID'];
					$itemid = $cartitem['ITEMID'];
					$item = Item::find('ITEMID = '.$itemid);

					$itemname = $item[0]['NAME'];
					$itemdescription = $item[0]['DESCRIPTION'];
					$itemprice = $item[0]['PRICE'];
					$quantity = $cartitem['QUANTITY'];
					$itemcategory = $cartitem['CATEGORY'];
					$itemfiltercategory = $cartitem['FILTERCATEGORY'];
					$imageurl = $item[0]['IMAGEURL'];
					
					$iteminfo = [
						'CARTITEMID'			=>	$cartitemid,
						'ITEMNAME'				=>	$itemname,
						'ITEMDESCRIPTION'		=>	$itemdescription,
						'ITEMPRICE'				=>	$itemprice,
						'QUANTITY'				=>	$quantity,
						'ITEMCATEGORY'			=>	$itemcategory,
						'ITEMFILTERCATEGORY'	=>	$itemfiltercategory,
						'IMAGEURL'				=>	$imageurl
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

	public function actionConfirmorder()
	{
		$title = "Bestätigen - BORD-Festival";

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

				if(isset($_POST['buycart']))
				{
					$purchasedata = [
						'PURCHASEDAT'	=> date("Y-m-d H:i:s"),
						'CLIENTID' 		=> $clientid				
					];
			
					$tmppurchase = new Purchase($purchasedata);
					$tmppurchase->save();
			
					$purchaseid = $tmppurchase->schema['PURCHASEID'];

					$cartitems = Cartitem::find('CARTID = ' . $cart[0]['CARTID']);

					foreach($cartitems as $cartitem)
					{
						$itemid = $cartitem['ITEMID'];
						$item = Item::find('ITEMID = '.$itemid);
						$itemprice = $item[0]['PRICE'];
						
						$purchaseitemdata = [
							'PURCHASEID'	=> $purchaseid,
							'ITEMID'  		=> $cartitem['ITEMID'],
							'QUANTITY' 		=> $cartitem['QUANTITY'],
							'PRICE'	        => $itemprice
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

	public function updateCart($cartid, $clientid)
	{
		$cartitems = Cartitem::find('CARTID = '.$cartid);

		$totalprice = 0;
		$totalcount = 0;

		foreach($cartitems as $cartitem)
		{
			$itemid = $cartitem['ITEMID'];
			$item = Item::find('ITEMID = '.$itemid);
			$itemprice = $item[0]['PRICE'];
			$quantity = $cartitem['QUANTITY'];

			$totalprice += $quantity * $itemprice;
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
		$item = Item::find('ITEMID = '.$itemid);
		$itemprice = $item[0]['PRICE'];

		$addedprice = $itemprice * $itemcount;

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


	public function deleteWholecart($clientid)
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
}