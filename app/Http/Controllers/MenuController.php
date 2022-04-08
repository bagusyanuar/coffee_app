<?php


namespace App\Http\Controllers;


use App\Helper\CustomController;
use App\Models\Barang;
use App\Models\Categories;

class MenuController extends CustomController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $data = Barang::with('category')->get();
        return view('menu.index')->with(['data' => $data]);
    }

    public function add_page()
    {
        $kategori = Categories::all();
        return view('menu.add')->with(['kategori' => $kategori]);
    }

    public function create()
    {
        try {
            $data = [
                'category_id' => $this->postField('kategori'),
                'nama' => $this->postField('nama'),
                'deskripsi' => $this->postField('deskripsi'),
                'qty' => $this->postField('qty'),
                'harga' => $this->postField('harga'),
            ];

            if ($gambar = $this->request->file('gambar')) {
                $ext = $gambar->getClientOriginalExtension();
                $photoTarget = uniqid( 'image-') . '.' . $ext;
                $data['gambar'] = '/gambar/' . $photoTarget;
                $this->uploadImage('gambar', $photoTarget, 'gambar');
            }
            Barang::create($data);
            return redirect()->back()->with(['success' => 'Berhasil Menambahkan Data...']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }

    public function edit_page($id)
    {
        $data = Barang::findOrFail($id);
        $kategori = Categories::all();
        return view('menu.edit')->with(['data' => $data, 'kategori' => $kategori]);
    }

    public function patch()
    {
        try {
            $id = $this->postField('id');
            $menu = Barang::find($id);

            $data = [
                'category_id' => $this->postField('kategori'),
                'nama' => $this->postField('nama'),
                'deskripsi' => $this->postField('deskripsi'),
                'qty' => $this->postField('qty'),
                'harga' => $this->postField('harga'),
            ];

            if ($gambar = $this->request->file('gambar')) {
                $ext = $gambar->getClientOriginalExtension();
                $photoTarget = uniqid( 'image-') . '.' . $ext;
                $data['gambar'] = '/gambar/' . $photoTarget;
                $this->uploadImage('gambar', $photoTarget, 'gambar');
            }
            $menu->update($data);
            return redirect('/menu')->with(['success' => 'Berhasil Merubah Data...']);
        }catch (\Exception $e) {
            return redirect()->back()->with(['failed' => 'Terjadi Kesalahan' . $e->getMessage()]);
        }
    }
}
