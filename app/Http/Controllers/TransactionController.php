<?php


namespace App\Http\Controllers;


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
            $status = $this->field('status');
            $query = Transaction::with(['cart']);
            if ($status !== null) {
                $query->where('status', '=', $status);
            }
            $data = $query->get();
            return $this->basicDataTables($data);
        } catch (\Exception $e) {
            return $this->basicDataTables([]);
        }
    }

    public function confirm()
    {
        try {
            $id = $this->postField('id');
            $status = $this->postField('status');
            $transaction = Transaction::find($id);
            if (!$transaction) {
                return $this->jsonResponse('Transaksi Tidak Ditemukan', 202);
            }
            $data = [
                'status' => $status
            ];
            $transaction->update($data);
            return $this->jsonResponse('success', 200);
        } catch (\Exception $e) {
            return $this->jsonResponse('terjadi kesalahan ' . $e->getMessage(), 500);
        }
    }
}
