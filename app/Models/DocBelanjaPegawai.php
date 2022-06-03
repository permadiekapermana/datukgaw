<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Uuids;

class DocBelanjaPegawai extends Model
{
    use Uuids;
    use HasFactory;
    protected $fillable = [
        'date', 'jenis_dokumen', 'tipe_dokumen', 'nama_dokumen', 'nomor_dokumen', 'deskripsi_dokumen', 'file', 'user_id', 'updated_dt', 'created_by', 'updated_by'
    ];
    public $timestamps = false;
}