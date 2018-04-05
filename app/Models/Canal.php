<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Canal extends Model
{
    protected $fillable = [
        'CANALSG', 'CANALNM'
    ];
    protected $table = 'cda_canal';
    protected $primaryKey = 'CANALID';
    public $timestamps = false;
}
