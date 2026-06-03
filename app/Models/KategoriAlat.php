<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class KategoriAlat extends Model
{
    protected $table = 'kategori_alat';
    protected $fillable = ['nama_kategori'];

    public function alatRiset()
    {
        return $this->hasMany(AlatRiset::class, 'kategori_id');
    }
}
