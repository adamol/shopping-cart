<?php

namespace Acme\Models;

use Acme\Models\Order;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
	protected $fillable = ['failed', 'transaction_id'];
}