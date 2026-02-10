<?php

namespace App\Http\Controllers;

use App\Exports\MasterItemExport;
use App\Models\MasterItem;
use App\Models\MasterKategoriItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class MasterItemsController extends Controller
{
    public function index()
    {
        return view('master_items.index.index');
    }

    public function search(Request $request)
    {
        $kode = $request->kode;
        $nama = $request->nama;
        $hargamin = $request->hargamin;
        $hargamax = $request->hargamax ?? $hargamin;

        // var_dump($hargamin,$hargamax);

        $data_search = MasterItem::query();

        if (!empty($kode)) $data_search = $data_search->where('kode', $kode);
        if (!empty($nama)) $data_search = $data_search->where('nama', 'LIKE', '%' . $nama . '%');

        if (!empty($hargamin)) {
            $data_search = $data_search->whereRaw(
                '(harga_beli+((harga_beli/ 100) * laba)) >= ?',
                [$hargamin]
            );
        }
        if (!empty($hargamax)) {
            $data_search = $data_search->whereRaw(
                '(harga_beli+((harga_beli/ 100) * laba)) >= ?',
                [$hargamax]
            );
        }

        $data_search = $data_search->select('kode', 'nama', 'jenis', 'harga_beli', 'laba', 'supplier')->orderBy('id')->get();


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
            $item = MasterItem::find($id);
        }
        $data['item'] = $item;
        $data['method'] = $method;
        $data['kategori_data'] = MasterKategoriItem::get();
        return view('master_items.form.index', $data);
    }

    public function singleView($kode)
    {
        $data['data'] = MasterItem::with('kategoriItem')
            ->where('kode', $kode)
            ->first();

        // echo $data['data']->kategoriItem->nama ?? '-';

        return view('master_items.single.index', $data);
    }

    public function formSubmit(Request $request, $method, $id = 0)
    {
        if ($method == 'new') {
            $data_item = new MasterItem;
            $kode = MasterItem::count('id');
            $kode = $kode + 1;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);
            sleep(3);
        } else {
            $data_item = MasterItem::find($id);
            $kode = $data_item->kode;
        }

        $data_item->nama = $request->nama;
        $data_item->harga_beli = $request->harga_beli;
        $data_item->laba = $request->laba;
        $data_item->kode = $kode;
        $data_item->supplier = $request->supplier;
        $data_item->jenis = $request->jenis;
        $data_item->kategori = $request->kategori;

        // ======================
        // UPLOAD FOTO
        // ======================
        if ($request->hasFile('foto')) {

            // hapus foto lama (saat edit)
            if ($method != 'new' && $data_item->foto) {
                Storage::disk('public')->delete($data_item->foto);
            }

            $filename = time() . '_' . $request->file('foto')->getClientOriginalName();
            $path = $request->file('foto')->storeAs(
                'master-item',
                $filename,
                'public'
            );

            $data_item->foto = $path;
        }

        $data_item->save();

        $data_item->save();

        return redirect('master-items');
    }

    public function delete($id)
    {
        MasterItem::find($id)->delete();
        return redirect('master-items');
    }

    public function updateRandomData()
    {
        $data = MasterItem::get();
        foreach ($data as $item) {
            $kode = $item->id;
            $kode = str_pad($kode, 5, '0', STR_PAD_LEFT);

            $item->harga_beli = rand(100, 1000000);
            $item->laba = rand(10, 99);
            $item->kode = $kode;
            $item->supplier = $this->getRandomSupplier();
            $item->jenis = $this->getRandomJenis();
            $item->save();
        }
    }

    private function getRandomSupplier()
    {
        $array = ['Tokopaedi', 'Bukulapuk', 'TokoBagas', 'E Commurz', 'Blublu'];
        $random = rand(0, 4);
        return $array[$random];
    }

    private function getRandomJenis()
    {
        $array = ['Obat', 'Alkes', 'Matkes', 'Umum', 'ATK'];
        $random = rand(0, 4);
        return $array[$random];
    }

    public function exportExcel()
    {
        return Excel::download(
            new MasterItemExport,
            'master-item-' . now()->format('Ymd_His') . '.xlsx'
        );
    }
}
