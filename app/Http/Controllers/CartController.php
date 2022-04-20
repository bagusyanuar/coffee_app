<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Cart;

class CartController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index() {
        try {
            $data = Cart::with(['menu', 'transaction'])
                ->whereNull('transaction_id')
                ->get();
            return $this->basicDataTables($data);
        }catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }
}
