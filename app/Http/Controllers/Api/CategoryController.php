<?php


namespace App\Http\Controllers\Api;


use App\Helper\CustomController;
use App\Models\Categories;
use phpDocumentor\Reflection\Types\Parent_;

class CategoryController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        try {
            $data = Categories::all();
            return $this->jsonResponse("success", 200, $data);
        }catch (\Exception $e) {
            return $this->jsonResponse('failed', 500);
        }
    }
}
