<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Barang;
use phpDocumentor\Reflection\Types\Parent_;

class MenuController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Barang::all();
            return $this->jsonResponse("success", 200, $data);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
