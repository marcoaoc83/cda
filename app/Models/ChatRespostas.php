<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatRespostas extends Model
{
    protected $fillable = [
        'resp_intents_slug', 'resp_texto'
    ];
    protected $table = 'cda_chat_respostas';
    protected $primaryKey = 'resp_id';
    public $timestamps = false;
}
