<?php

namespace App\Http\Controllers;

use App\Models\MasterItem;
use App\Models\MasterKategoriItem;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class MasterKategoriItemsController extends Controller
{
    public function index()
    {
        return view('master_kategori_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;

        $data_search = MasterKategoriItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        $data_search = $data_search->select('kode', 'nama')->orderBy('id')->get();

        return json_encode([
            'status' => 200,
            'data' => $data_search
        ]);
    }

    public function formView($method, $id = 0)
    {
        if ($method == 'new') {
            $item = [];
        } else {
            $item = MasterKategoriItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        return view('master_kategori_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterKategoriItem::where('kode', $kode)->firstOrFail();
        $data['item_list'] = $data['data']->masterItems()->with('kategoriItem')->get();
        return view('master_kategori_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterKategoriItem;
            $kode = MasterKategoriItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterKategoriItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->kode = $kode;
        $data_item->save();

        return redirect('master-kategori-items');
    }

    public function delete($id)
    {
        MasterKategoriItem::find($id)->delete();
        return redirect('master-kategori-items');
    }

    public function updateRandomData()
    {
        $data = MasterKategoriItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            $item->kode = $kode;
            $item->save();
        }
    }

    public function cetakPdf($id)
    {
        $data = MasterKategoriItem::with('masterItems')->findOrFail($id);

        $pdf = Pdf::loadView('master_kategori_items.pdf', [
            'data' => $data,
            'item_list' => $data->masterItems
        ])->setPaper('a4', 'portrait');

        return $pdf->stream('kategori-item-' . $data->kode . '.pdf');
    }
}
