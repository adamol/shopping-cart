<?php

namespace Acme\Handlers;

use Acme\Handlers\Contracts\HandlerInterface;

class MarkOrderPaid implements HandlerInterface
{
	public function handle($event)
	{
		$event->order->update([
			'paid' => true
		]);
	}
}