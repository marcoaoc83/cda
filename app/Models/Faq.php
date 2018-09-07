<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $fillable = [
        'faq_titulo', 'faq_texto', 'faq_ordem'
    ];
    protected $table = 'cda_portal_faq';
    protected $primaryKey = 'faq_id';
    public $timestamps = false;
}
