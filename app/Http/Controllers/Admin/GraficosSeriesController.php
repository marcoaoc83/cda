<?php

namespace App\Http\Controllers\Admin;

use App\Models\GraficosSeries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class GraficosSeriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Series = GraficosSeries::all();
        return view('admin.graficos.series.index',compact('Series'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // show the view and pass the nerd to it
        return view('admin.graficos.series.create',[]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        if (GraficosSeries::create($data))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\GraficosSeries  $graficos_series
     * @return \Illuminate\Http\Response
     */
    public function show(GraficosSeries $graficos_series)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\GraficosSeries  $graficos_series
     * @return \Illuminate\Http\Response
     */
    public function edit(Request $request)
    {
        // get the nerd
        $GraficosSeries = GraficosSeries::find($request->grse_id)->toArray();

        return response()->json($GraficosSeries);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\GraficosSeries  $graficos_series
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $graficos_series = GraficosSeries::findOrFail($id);

        if($graficos_series->update($request->except(['_token'])))
            return \response()->json(true);
        return \response()->json(false);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\GraficosSeries  $graficos_series
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $var = GraficosSeries::find($request->id);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
    }

    public function getDadosDataTable(Request $request)
    {
        $cda_graficos_series = GraficosSeries::select(['*'])
            ->join('cda_graficos_tipos','grti_id','=','grse_tipo')
            ->where('grse_grafico_id',$request->grse_grafico_id)
            ->get();

        return Datatables::of($cda_graficos_series)
            ->addColumn('action', function ($serie) {

                return '
                <a href="graficosseries/'.$serie->grse_id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteGraficosSeries('.$serie->grse_id.')" class="btn btn-xs btn-danger deleteGraficosSeries" >
                    <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }
}
