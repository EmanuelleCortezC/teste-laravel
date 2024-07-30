<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TbEstrategiaWms extends Model
{
    use HasFactory;

    protected $table = 'tb_estrategia_wms';
    protected $primaryKey = 'cd_estrategia_wms';
    public $timestamps = false;
    protected $fillable = ['ds_estrategia_wms',
                           'nr_prioridade'];

    public function horarios(){
        $this->hasMany(TbEstrategiaWmsHorarioPrioridade::class, 'cd_estrategia_wms', 'cd_estrategia_wms');
    }
}
