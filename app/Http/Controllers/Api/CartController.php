<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Cart;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CartController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function cart()
    {
        try {
            if ($this->request->method() === 'POST') {
                $menu_id = $this->postField('menu');
                $qty = $this->postField('qty');
                $description = $this->postField('description') ?? '';
                $menu = Barang::find($menu_id);
                if (!$menu) {
                    return $this->jsonResponse('Menu Tidak Di Temukan...', 202);
                }
                $price = $menu->harga;

                //cek apakah menu yang di input sudah ada di keranjang
                $cart_exist = Cart::where('barang_id', '=', $menu_id)
                    ->whereNull('transaction_id')
                    ->first();

                if ($cart_exist) {
                    $qty_before = $cart_exist->qty;
                    $qty_after = $qty + $qty_before;
                    $total_after = $qty_after * $price;
                    $cart_exist->update([
                        'qty' => $qty_after,
                        'price' => $price,
                        'total' => $total_after,
                        'deskripsi' => $description
                    ]);
                } else {
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
                }
                return $this->jsonResponse('success', 200);
            }
            $carts = Cart::with('menu')
                ->whereNull('transaction_id')
                ->get();
            return $this->jsonResponse('success', 200, $carts);
        } catch (\Exception $e) {
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

    public function checkout()
    {
        try {
            setlocale(LC_TIME, 'id_ID');
            Carbon::setLocale('id');
            $tanggal = Carbon::now();
            $customer = $this->postField('customer');
            $discount = $this->postField('discount') ?? 0;
            DB::beginTransaction();
            $carts = Cart::whereNull('transaction_id')->get();
            $sub_total = $carts->sum('total');
            $data = [
                'user_id' => 7,
                'tanggal' => $tanggal,
                'customer' => $customer,
                'sub_total' => $sub_total,
                'diskon' => $discount,
                'total' => $sub_total - $discount
            ];
            $transaction = Transaction::create($data);
            foreach ($carts as $cart) {
                $menu = Barang::find($cart->barang_id);

                //cek ketersediaan barang
                if (!$menu) {
                    DB::rollBack();
                    return $this->jsonResponse('Ooops, Menu Tidak Tersedia!', 202);
                }

                //cek stock barang
                $qty_order = $cart->qty;
                $qty_available = $menu->qty;
                if ($qty_order > $qty_available) {
                    DB::rollBack();
                    return $this->jsonResponse('Ooops, Jumlah Pesanan Melebihi Persediaan...', 202);
                }

                //update stock menu
                $qty_current = $qty_available - $qty_order;
                $menu->update([
                    'qty' => $qty_current,
                ]);

                //set transaction id of cart
                $cart->update([
                    'transaction_id' => $transaction->id
                ]);
            }
            DB::commit();
            return $this->jsonResponse('success', 200, $transaction->id);
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->jsonResponse('failed ' . $e->getMessage(), 500);
        }
    }

}
