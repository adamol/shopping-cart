<?php

namespace Acme\Basket\Exception;

use Exception;

class QuantityExceededException extends Exception
{
	protected $massage = 'You have exceeded the available quantity for this item.';
}