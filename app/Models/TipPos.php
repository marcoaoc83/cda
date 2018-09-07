<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TipPos extends Model
{
    protected $fillable = [
        'TipPosId','CanalId'
    ];
    protected $table = 'cda_tippos';
    public $timestamps = false;
    protected $primaryKey = 'id';

    public function canais(){
        return $this->belongsTo(Canal::class);
    }


}
