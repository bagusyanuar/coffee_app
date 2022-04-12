<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Transaction;

class TransactionController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $transactions = Transaction::with('cart.menu')
                ->get();
            return $this->jsonResponse('success', 200, $transactions);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function get_transaction_by_id($id)
    {
        try {
            $transaction = Transaction::with('cart.menu')
                ->where('id', '=', $id)
                ->first();
            if (!$transaction) {
                return $this->jsonResponse('Ooops, Maaf Transaksi Tidak Di Temukan', 202);
            }
            return $this->jsonResponse('success', 200, $transaction);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
