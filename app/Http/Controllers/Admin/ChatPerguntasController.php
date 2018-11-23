<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Softon\SweetAlert\Facades\SWAL;
use Yajra\DataTables\Facades\DataTables;

class ChatPerguntasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.perguntas.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.perguntas.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //https://api.recast.ai/v2/users/${USER_SLUG}/bots/${BOT_SLUG}/intents/${INTENT_SLUG}/expressions
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents/$request->intent/expressions";
        $body=[
            "source"=>$request->source
        ];
        $return=self::requestRecast($endpoint,'POST',$body);

        return \response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ChatPerguntas  $chat
     * @return \Illuminate\Http\Response
     */
    public function show( $chat)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ChatPerguntas  $chat
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // show the view and pass the nerd to it
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents/$id";
        $intents=self::requestRecast($endpoint);
        return view('admin.perguntas.edit',[
            'ChatPerguntas'=>$intents
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChatPerguntas  $chat
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        //https://api.recast.ai/v2/users/${USER_SLUG}/bots/${BOT_SLUG}/intents/${INTENT_SLUG}/expressions/${EXPRESSION_ID}
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents/$request->intent/expressions/$request->id";
        $body=[
            "source"=>$request->source
        ];
        $return=self::requestRecast($endpoint,'PUT',$body);

        return \response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ChatPerguntas  $chat
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //https://api.recast.ai/v2/users/${USER_SLUG}/bots/${BOT_SLUG}/intents/${INTENT_SLUG}/expressions/${EXPRESSION_ID}
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents/$request->intent/expressions/$request->id";
        $return=self::requestRecast($endpoint,'DELETE');

        return 'true';
    }


    public function getDadosDataTable(Request $request)
    {
        $endpoint="https://api.recast.ai/v2/users/cda/bots/divinopolis/intents/$request->id/expressions";
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
