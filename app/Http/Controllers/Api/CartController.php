<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Cart;
use Matrix\Exception;

class CartController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function add_to_cart()
    {
        try {
            $menu_id = $this->postField('menu');
            $qty = $this->postField('qty');
            $description = $this->postField('description') ?? '';
            $menu = Barang::find($menu_id);
            if (!$menu) {
                return $this->jsonResponse('Menu Tidak Di Temukan...', 202);
            }

            $price = $menu->harga;
            $total = $qty * $price;
            $data = [
                'barang_id' => $menu_id,
                'qty' => $qty,
                'harga' => $price,
                'total' => $total,
                'deskripsi' => $description,
                'transaction_id' => null
            ];
            Cart::create($data);
            return $this->jsonResponse('success', 200);
        } catch (Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }
}
