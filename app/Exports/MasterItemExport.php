<?php

namespace App\Exports;

use App\Models\MasterItem;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MasterItemExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return MasterItem::with('kategoriItem')
            ->get()
            ->map(function ($item) {

                $hargaJual = $item->harga_beli +
                    ($item->harga_beli * $item->laba / 100);

                return [
                    'kode'        => $item->kode,
                    'kategori'    => $item->kategoriItem->nama ?? '-',
                    'nama'        => $item->nama,
                    'supplier'    => $item->supplier,
                    'harga_beli'  => $item->harga_beli,
                    'laba'        => $item->laba, // persen
                    'harga_jual'  => $hargaJual,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Item',
            'Nama Kategori',
            'Nama Item',
            'Nama Supplier',
            'Harga Beli',
            'Laba (%)',
            'Harga Jual',
        ];
    }
}
