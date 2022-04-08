<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Categories;

class CategoriesController extends CustomController
{

    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Categories::all();
        return view('kategori.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        return view('kategori.add');
    }

    public function create()
    {
        try {
            $data = [
                'nama' => $this->postField('name'),
            ];
            Categories::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Categories::findOrFail($id);
        return view('kategori.edit')->with(['data' => $data]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $category = Categories::find($id);

            $data = [
                'nama' => $this->postField('name'),
            ];
            $category->update($data);
            return redirect('/kategori')->with(['success' => 'Berhasil Merubah Data...']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }
}
