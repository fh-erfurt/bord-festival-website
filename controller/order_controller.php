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
use ItemCategory;
use ItemGender;
use ItemColor;


require_once 'model/user.class.php';
require_once 'model/address.class.php';
require_once 'model/item.class.php';
require_once 'model/cart.class.php';
require_once 'model/cartitem.class.php';
require_once 'model/support_mail.class.php';
require_once 'model/purchase.class.php';
require_once 'model/purchaseitem.class.php';
require_once 'model/itemcategory.class.php';
require_once 'model/itemGender.class.php';
require_once 'model/itemcolor.class.php';


class OrderController extends \app\core\Controller
{
	// views for ticketshop and merchandiseshop
	public function actionShop()
	{
		$json = false;
		// input and output if JSON/AJAX is used
		if(isset($_GET['json']) && ($_GET['json']) === "true")
		{
			$json = true;
			if(isset($_GET['addtocart']) && ($_GET['addtocart']) === "true")
			{
				self::addItemsToCart($json);
			}
			if(isset($_GET['calculatecart']) && ($_GET['calculatecart']) === "true")
			{
				$clientid = $_SESSION['client_id'];
				self::CalculateCart($clientid, $json);
			}
		}
		// if JSON/AJAX isn't used
		else
		{
			if(isset($_GET['t']))
			{
				$type = $_GET['t'];
				if($type === 'tickets')
				{
					$title = "Ticketshop - BORD-Festival";
					$this->_params['title'] = $title;
				}
				else
				{
					$title = "Merchandise - BORD-Festival";
					$this->_params['title'] = $title;
				}
				$type = \addslashes($type);

				// get the filter values and sortings for the merchandise-shop from database
				// pre-order and pre-filter the output, if a filter already exists
				$itemCategories = ItemCategory::find();
				$this->_params['itemCategories'] = $itemCategories;
				$itemGender = ItemGender::find();
				$this->_params['itemGender'] = $itemGender;
				$itemColors = ItemColor::find();
				$this->_params['itemColors'] = $itemColors;

				$where = 'type = "'.$type.'"';
				$filter = '';
				$orderby = '';
				$selectedCategoryFilter = '';
				$selectedGenderFilter = '';
				$selectedColorFilter = '';

				$selectedSort = '';
				$getSelectedSort = false;
				if(!isset($_POST['price']) && !isset($_POST['name']))
				{
					$getSelectedSort = true;
				}

				$filter .= self::AddFilter('category', 'selectedCategoryFilter');
				$filter .= self::AddFilter('gender', 'selectedGenderFilter');
				$filter .= self::AddFilter('color', 'selectedColorFilter');

				$orderby .= self::AddFilter('price', 'selectedSort', true, $getSelectedSort);
				
				$orderby .= self::AddFilter('name', 'selectedSort', true, $getSelectedSort);
				
				$where .= $filter;
				$where .= $orderby;
			
				$items = Item::find($where, false);
				if(!empty($items))
				{
					$this->_params['items'] = $items;
				}
			}
			else
			{
				header('Location: index.php?c=pages&a=error404');
			}

			if(isset($_POST['addItemToCart']))
			{
				self::addItemsToCart($json);
			}
		}
    }
    // create a new shopping cart for new users, to prevent errors
    public function intizialiseCart($clientid)
	{
		$result = null;
		if(!empty($clientid))
		{
			$cartdata = [
				'totalprice'	=> null,
				'totalcount'	=> null,
				'lastupdated'	=> date("Y-m-d H:i:s"),
				'clientid' 		=> $clientid
	
			];
	
			$cart = new Cart($cartdata);
			$cart->save();
	
			$cartid = $cart->schema['cartid'];
			$result = $cart;
		}

		return $result;
    }
	
	// show the shoppingcart items
	// delete items from shoppingcart
	// buy items from shoppingcart and remove them from shoppingcart into account-purchases
	public function actionShoppingcart()
	{
		$title = "Warenkorb - BORD-Festival";

		$this->_params['title'] = $title;

		if(isset($_SESSION['client_id']))
		{
			// get user data for purchasing
			$clientid = $_SESSION['client_id'];
			$client = Client::find('clientid = ' . $clientid);
			$cart = Cart::find('clientid = ' . $clientid);
			$addressid = $client[0]['addressid'];
			$address = Address::find('addressid = ' . $addressid);

			$this->_params['street'] = $address[0]['street'];
			$this->_params['zip'] = $address[0]['zip'];
			$this->_params['city'] = $address[0]['city'];
			$this->_params['country'] = $address[0]['country'];

			// delete items from cart
			if(isset($_POST['deleteItemFromCart']))
			{
				$cartitemid = $_POST['cartitemid'] ?? null;
				
				$success = false;
				if($cartitemid !== null)
				{
					$cartitem = Cartitem::find('cartitemid = '.$cartitemid);
					$cartid = 0;

					if(!empty($cartitem))
					{
						$cartitemdata = [
							'cartitemid'		=> $cartitem[0]['cartitemid'],
							'cartid'			=> $cartitem[0]['cartid'],
							'itemid'  			=> $cartitem[0]['itemid'],
							'quantity' 			=> $cartitem[0]['quantity']
						];

						$cartid = $cartitem[0]['cartid'];
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

			// delete the whole cart
			if(isset($_POST['deleteWholeCart']))
			{
				$success = self::deleteWholeCart($clientid);
				http_response_code( 303 );
				header( "Location: {$_SERVER['REQUEST_URI']}&success=".$success ); 
				exit();	
			}

			// buy the cart and move the items into table "purchases"
			if(isset($_POST['buyCart']))
			{
				$purchasedata = [
					'purchasedat'	=> date("Y-m-d H:i:s"),
					'clientid' 		=> $clientid				
				];
		
				$tmppurchase = new Purchase($purchasedata);
				$tmppurchase->save();
		
				$purchaseid = $tmppurchase->schema['purchaseid'];

				$cartitems = Cartitem::find('cartid = ' . $cart[0]['cartid']);

				foreach($cartitems as $cartitem)
				{
					$itemid = $cartitem['itemid'];
					$item = Item::find('itemid = '.$itemid);
					$itemprice = $item[0]['price'];
					
					$purchaseitemdata = [
						'purchaseid'	=> $purchaseid,
						'itemid'  		=> $cartitem['itemid'],
						'quantity' 		=> $cartitem['quantity'],
						'price'	        => $itemprice
					];

					$purchaseitem = new Purchaseitem($purchaseitemdata);
					$purchaseitem->save();
				}

				self::deleteWholeCart($clientid);
				header('Location: index.php?c=pages&a=index');
			}

			$cart = Cart::find('clientid = '.$clientid);
			$sum = 0;

			// get shoppingcart items for displaying
			if(!empty($cart))
			{
				$cartid = $cart[0]['cartid'];

				$cartTotalPrice = $cart[0]['totalprice'];
				$cartitemcount = Cartitem::count('cartid = '.$cartid);
				$this->_params['cartTotalPrice'] = $cartTotalPrice;
				$this->_params['cartitemcount'] = $cartitemcount;	
				
				$cartitems = Cartitem::find('cartid = '.$cartid);
				
				$this->_params['cartitems'] = $cartitems;

				$shoppingcart = [];

				foreach($cartitems as $cartitem)
				{
					// CartitemId is needed to remove a cartitem-entry, if the Client deletes a item in his shoppingcart
					$cartitemid = $cartitem['cartitemid'];
					$itemid = $cartitem['itemid'];
					$item = Item::find('itemid = '.$itemid);

					$itemname = $item[0]['name'];
					$itemdescription = $item[0]['description'];
					$itemprice = $item[0]['price'];
					$quantity = $cartitem['quantity'];
					$itemcategory = $item[0]['category'];
					$imageurl = $item[0]['imageurl'];
					
					$iteminfo = [
						'cartitemid'			=>	$cartitemid,
						'itemname'				=>	$itemname,
						'itemdescription'		=>	$itemdescription,
						'itemprice'				=>	$itemprice,
						'quantity'				=>	$quantity,
						'itemcategory'			=>	$itemcategory,
						'imageurl'				=>	$imageurl
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

	// update the cart, if the user added or removed items
	public function updateCart($cartid, $clientid)
	{
		$cartitems = Cartitem::find('cartid = '.$cartid);

		$totalprice = 0;
		$totalcount = 0;

		foreach($cartitems as $cartitem)
		{
			$itemid = $cartitem['itemid'];
			$item = Item::find('itemid = '.$itemid);
			$itemprice = $item[0]['price'];
			$quantity = $cartitem['quantity'];

			$totalprice += $quantity * $itemprice;
			$totalcount += $quantity;
		}

		$changedcartdata = [
			'cartid'		=> $cartid,
			'totalprice'	=> $totalprice,
			'totalcount'	=> $totalcount,
			'lastupdated'	=> date("Y-m-d H:i:s"),
			'clientid' 		=> $clientid
		];

		$changedcart = new Cart($changedcartdata);
		$changedcart->save();
	}

	// delete all items in the cart
	public function deleteWholeCart($clientid)
	{		
		$cart = Cart::find('clientid = '.$clientid);
		$success = false;

		if(!empty($cart))
		{					
			$cartid = $cart[0]['cartid'];
			$cartitemdata = Cartitem::find('cartid = '.$cartid);

			if(!empty($cartitemdata))
			{
				$cartitem = new Cartitem($cartitemdata[0]);
				$where = 'cartid = '.$cartid;
				$cartitem->delete($where);
				self::updateCart($cartid, $clientid);
				$success = true;
			}			
		}

		return $success;
    }
    
	// Get ClientId to calculate the Cart in menu
	public function actionNavbar()
	{
		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];
			self::CalculateCart($clientid);
		}
	}
	// calculate the cart
	private function CalculateCart($clientid, $json = false)
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

		if($json)
		{
			$output['cartTotalPrice'] = $this->_params['cartTotalPrice'];
			$output['cartTotalCount'] = $this->_params['cartTotalCount'];
			echo json_encode($output);
		}
	} 

	// is called when a user adds items from the shopping pages into the cart
	private function addItemsToCart($json = false)
	{
		if(isset($_SESSION['client_id']))
		{
			$clientid = $_SESSION['client_id'];
			$itemid = $_POST['itemid'] ?? null;
			$itemcount = $_POST['itemcount'] ?? null;
			$itemcountint = (int)$itemcount ?? null;

			$success = 0;

			// validation: only accepts itemcounts greater than 0
			if(!empty($itemcountint) && $itemcountint > 0)
			{
				if($itemid !== null && $itemcount !== null)
				{
					$cart = Cart::find('clientid = '.$clientid);
					$cartid = 0;
					$oldtotalprice = 0;

					// get or create a cart
					if(empty($cart))
					{
						$tmpcart = self::intizialiseCart($clientid);
						$cartid = $tmpcart->schema['cartid'];
						$oldtotalprice = $tmpcart->schema['totalprice'];
					}
					else
					{
						$cartid = $cart[0]['cartid'];
						$oldtotalprice = $cart[0]['totalprice'];
					}

					$cartitem = Cartitem::find('cartid = '.$cartid.' AND itemid = '.$itemid);

					// update the itemcount, if the item already exists in the cart or add the item to the cart, if it doesn't exist
					if(empty($cartitem))
					{
						$cartitemdata = [
							'cartid'			=> $cartid,
							'itemid'  			=> $itemid,
							'quantity' 			=> $itemcount
						];
					}
					else
					{
						$olditemcount = $cartitem[0]['quantity'];
						$newitemcount = $olditemcount + $itemcount;
						$cartitemdata = [
							'cartitemid'		=> $cartitem[0]['cartitemid'],
							'cartid'			=> $cartid,
							'itemid'  			=> $itemid,
							'quantity' 			=> $newitemcount
						];

					}
					$newcartitem = new Cartitem($cartitemdata);
					$newcartitem->save();

					//update the cart
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
			if($json)
			{
				echo $success;
			}
			else
			{
				// PRG (Post-Redirect-Get) Pattern to allow page reloading after using a form
				http_response_code( 303 );
				header( "Location: {$_SERVER['REQUEST_URI']}&success=".$success ); 
				exit();
			}
		}
	}
	
	// called when a user sets a filter or a sort in the merchandise-shop
	private function AddFilter($field, $filtername, $usesort = false, $getselectedSort = false)
	{
		$result = '';
		$param = null;

		if(isset($_POST[$field]))
		{
			$filter = $_POST[$field];
		}
		else
		{
			if($getselectedSort)
			{
				if(!empty($_POST[$field.'_selected']))
				{
					$filter = $_POST[$field.'_selected'];
				}
			}
		}

		if(!empty($filter))
		{
			$filter = \addslashes($filter);

			if($usesort)
			{
				$param = [
					$field => $filter
				];
				$result = self::AddSort($field, $filter);
			}
			else
			{
				$param = $filter;
				$result = self::AddWhere($field, $filter);

			}
			
			self::AddToParams($filtername, $param);
		}

		return $result;
	}

	private function AddWhere($field, $filter)
	{
		return ' AND '.$field.' = "'.$filter.'"';
	}
	
	private function AddSort($field, $filter)
	{
		return ' ORDER BY '.$field.' '.$filter;
	}

	private function AddToParams($filtermame, $filter)
	{
		if(!empty($filter))
		{
			$this->_params[$filtermame] = $filter;

		}	
	}
}