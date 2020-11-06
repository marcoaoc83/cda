<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.chat.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.chat.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $endpoint="https://api.recast.ai/train/v2/users/cda/bots/divinopolis/versions/v1/dataset/intents/";
        $body=[
            "name"=>$request->name,
            "description"=>$request->description
        ];
        $return=self::requestRecast($endpoint,'POST',$body);

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('chat.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function show(Chat $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the view and pass the nerd to it
        $endpoint="https://api.recast.ai/train/v2/users/cda/bots/divinopolis/versions/v1/dataset/intents/$id";
        $intents=self::requestRecast($endpoint);
        return view('admin.chat.edit',[
            'Chat'=>$intents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {

        $endpoint="https://api.recast.ai/train/v2/users/cda/bots/divinopolis/versions/v1/dataset/intents/$id";
        $body=[
        "name"=>$request->name,
            "description"=>$request->description
        ];
        $return=self::requestRecast($endpoint,'PUT',$body);

        // redirect
        SWAL::message('Salvo','Salvo com sucesso!','success',['timer'=>4000,'showConfirmButton'=>false]);
        return redirect()->route('chat.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Chat  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $endpoint="https://api.recast.ai/train/v2/users/cda/bots/divinopolis/versions/v1/dataset/intents/$id";
        $return=self::requestRecast($endpoint,'DELETE');

        return 'true';
    }


    public function getDadosDataTable()
    {
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents";
        $intents=self::requestRecast($endpoint);
        return Datatables::of($intents)
            ->addColumn('action', function ($intents) {
                return '
                <a href="chat/'.$intents->id.'/edit/" class="btn btn-xs btn-primary">
                    <i class="glyphicon glyphicon-edit"></i> Editar
                </a>
                <a href="javascript:;" onclick="deleteChat(\''.$intents->id.'\')" class="btn btn-xs btn-danger deleteChat" >
                    <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }

    public function getPerguntas(Request $request)
    {
        $endpoint="https://api.recast.ai/train/v2/users/cda/bots/divinopolis/versions/v1/dataset/intents/$request->id/expressions";
        $intents=self::requestRecast($endpoint);
        return Datatables::of($intents)->make(true);
    }

    public function requestRecast($endpoint,$type='GET',$file=null) {

        $token ="32af5b8eacd51b2fbe0a9526eee4a9d5";

        if (!$token) {
            throw new \Exception('Error: Parameter token is missing');
        }

        $headers = ['Authorization' => "Token " . $token];

        $client = new \GuzzleHttp\Client();
        $body = json_encode($file);
        try {
            $response = $client->request($type, $endpoint, [
                'headers' => $headers,
                'form_params' => $file
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
        }

        $responseBody = json_decode($response->getBody()->getContents())->results;

        return ($responseBody);
    }
}
