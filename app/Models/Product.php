<?php

namespace Acme\Models;

use Acme\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	public $quantity = null;
	
	public function hasLowStock()
	{
		if ($this->outOfStock()) {
			return false;
		}

		return (bool) ($this->stock <= 5);
	}

	public function outOfStock()
	{
		return $this->stock === 0;
	}

	public function inStock()
	{
		return $this->stock >= 1;
	}

	public function hasStock($quantity)
	{
		return $this->stock >= $quantity;
	}

	public function orders()
	{
		return $this->belongsToMany(Order::class, 'orders_products')->withPivot('quantity');
	}
}