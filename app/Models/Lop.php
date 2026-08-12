<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lop extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_proyek',
        'witel',
        'site_id_location',
        'koordinat',
        'kecamatan_lokasi_olt',
        'user_id',
        'size_olt',
        'platform',
        'type',
        'hostname',
        'jumlah_modul',
        'catuan_ac',
        'kode_sto',
        'nama_sto_uplink',
        'port_metro',
        'sfp',
        'odp',
        'port',
        'start_project',
        'toc',
        'tanggal_plan_oa',
        'week_plan_oa',
        'lop_downlink',
        'kontrak_pengadaan',
        'kode_ihld',
        'site_provider',
        'kendala',
        'last_issue',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_project' => 'date',
        'toc' => 'date',
        'tanggal_plan_oa' => 'date',
    ];

    /**
     * Get the user that created the LOP.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}