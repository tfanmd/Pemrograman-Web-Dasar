<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AlatRiset extends Model
{
    protected $table = 'alat_riset';
    protected $fillable = ['kategori_id', 'nama_alat', 'stok', 'kondisi', 'gambar_alat'];

    public function kategori()
    {
        return $this->belongsTo(KategoriAlat::class, 'kategori_id');
    }
}
