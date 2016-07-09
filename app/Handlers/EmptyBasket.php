<?php

namespace Acme\Handlers;

use Acme\Handlers\Contracts\HandlerInterface;

class EmptyBasket implements HandlerInterface
{
	public function handle($event)
	{
		$event->basket->clear();
	}
}