<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Orgao extends Model
{
    protected $fillable = [
         'org_nome'
    ];
    protected $table = 'cda_orgao';
    public $timestamps = false;
    protected $primaryKey = 'org_id';
}
