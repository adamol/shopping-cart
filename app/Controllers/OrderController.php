<?php

namespace Acme\Controllers;

use Slim\Router;
use Slim\Views\Twig;
use Acme\Basket\Basket;
use Acme\Models\Address;
use Acme\Models\Product;
use Acme\Models\Customer;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Acme\Validation\Contracts\ValidatorInterface;
use Acme\Validation\Forms\OrderForm;
use Braintree_Transaction;

class OrderController
{
	protected $basket;
	protected $router;
	protected $validator;

	public function __construct(Basket $basket, Router $router, ValidatorInterface $validator)
	{
		$this->basket = $basket;
		$this->router = $router;
		$this->validator = $validator;
	}
	public function index(Request $request, Response $response, Twig $view)
	{
		$this->basket->refresh();

		if (!$this->basket->subTotal()) {
			return $response->withRedirect($this->router->pathFor('cart.index'));
		}

		return $view->render($response, 'order/index.twig');
	}

	public function create(Request $request, Response $response, Customer $customer, Address $address)
	{
		$this->basket->refresh();

		if (!$this->basket->subTotal()) {
			return $response->withRedirect($this->router->pathFor('cart.index'));
		}

		if (!$request->getParam('payment_method_nonce')) {
			return $response->withRedirect($this->router->pathFor('order.index'));
		}

		$validation = $this->validator->validate($request, OrderForm::rules());

		if ($validation->fails()) {
			return $response->withRedirect($this->router->pathFor('order.index'));
		}

		$hash = bin2hex(random_bytes(32));

		$customer = $customer->firstOrCreate([
			'email' => $request->getParam('email'),
			'name' => $request->getParam('name'),
		]);

		$address = $address->firstOrCreate([
			'address1' => $request->getParam('address1'),
			'address2' => $request->getParam('address2'),
			'city' => $request->getParam('city'),
			'postal_code' => $request->getParam('postal_code'),
		]);

		$order = $customer->orders()->create([
			'hash' => $hash,
			'paid' => false,
			'total' => $this->basket->total(),
			'address_id' => $address->id,
		]);

		$order->products()->saveMany(
			$this->basket->all(),
			$this->getQuantities($this->basket->all())
		);

		$result = Braintree_Transaction::sale([
			'amount' => $this->basket->total(),
			'paymentMethodNonce' => $request->getParam('payment_method_nonce'),
			'options' => [
				'submitForSettlement' => true,
			]
		]);

		var_dump($result);
		die();
	}

	protected function getQuantities($items)
	{
		$quantities = [];

		foreach ($items as $item) {
			$quantities[] = ['quantity' => $item->quantity];
		}

		return $quantities;
	}
}