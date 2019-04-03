<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Graficos extends Model
{
    protected $fillable = [
        'graf_titulo','graf_tipo','graf_subtitulo','graf_principal','graf_sql_valor','graf_sql_campo','graf_sql_condicao','graf_sql_agrupamento','graf_filtro','graf_sql_condicao','graf_grafico_ref'
    ];
    protected $table = 'cda_graficos';
    protected $primaryKey = 'graf_id';
    public $timestamps = false;

    public function parent()
    {
        return $this->belongsTo('App\Models\Graficos','graf_grafico_ref')->where('graf_grafico_ref',null)->with('parent');
    }
    // all ascendants
    public function parent_rec()
    {
        return $this->parent()->with('parent_rec');
    }

    public function children()
    {
        return $this->hasMany('App\Models\Graficos','graf_grafico_ref')->with('children');
    }
    public function children_rec()
    {
        return $this->children()->with('children_rec');
        // which is equivalent to:
        // return $this->hasMany('App\CourseModule', 'parent')->with('children_rec);
    }
}
