<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MasterKategoriItem extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function masterItems()
    {
        return $this->hasMany(MasterItem::class, 'kategori', 'id');
    }
}
