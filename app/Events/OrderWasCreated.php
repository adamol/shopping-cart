<?php

namespace Acme\Events;

use Acme\Models\Order;
use Acme\Basket\Basket;

class OrderWasCreated extends Event
{
	public $order;
	public $basket;
	
	public function __construct(Order $order, Basket $basket)
	{
		$this->order = $order;
		$this->basket = $basket;
	}
}