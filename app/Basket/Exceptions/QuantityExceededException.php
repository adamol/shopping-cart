<?php

namespace Acme\Basket\Exceptions;

use Exception;

class QuantityExceededException extends Exception
{
	protected $massage = 'You have exceeded the available quantity for this item.';
}