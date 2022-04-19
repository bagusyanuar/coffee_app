<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Cart;
use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Kreait\Firebase\Contract\Messaging;

class CartController extends CustomController
{
    private Messaging $messaging;

    public function __construct(Messaging $messaging)
    {
        parent::__construct();
        $this->messaging = $messaging;
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
                    $total_after = $qty * $price;
                    $cart_exist->update([
                        'qty' => $qty,
                        'harga' => $price,
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
                $to = 'f1sZWCMYD6nj2cx34Uvuk8:APA91bEf_eRaKgV1bzoAXntRSEgjWmQkXZ2gh9qw_8X8qvjT1VhYWHasnu0tKpKHL658f5vkjg7eHbOkL7yUejTchnGRnf9LIRY-XS0eF-PLgLj4qW8TS9bbdXnWrF20YOoyiTskA-Th';
                $this->send_notification($this->messaging, $to, 'Pesananan Baru', "Pesanan Baru Datang");
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
                'user_id' => 3,
                'tanggal' => $tanggal,
                'customer' => $customer,
                'sub_total' => $sub_total,
                'diskon' => $discount,
                'total' => $sub_total - $discount,
                'status' => 0,
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
