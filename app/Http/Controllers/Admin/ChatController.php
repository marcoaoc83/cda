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
        // show the view and pass the nerd to it
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
        $data = $request->all();

        Chat::create($data);
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
        $Chat = Chat::find($id);
        return view('admin.chat.edit',[
            'Chat'=>$Chat
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
        $Chat = Chat::findOrFail($id);
        $Chat->update($request->except(['_token']));

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
    public function destroy($chat)
    {
        $var = Chat::find($chat);
        if($var->delete()) {
            return 'true';
        }else{
            return 'false';
        }
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
                <a href="javascript:;" onclick="deleteChat('.$intents->id.')" class="btn btn-xs btn-danger deleteChat" >
                <i class="glyphicon glyphicon-remove-circle"></i> Deletar
                </a>
                ';
            })
            ->make(true);
    }


    public function requestRecast($endpoint,$type='GET',$file=null) {

        $token ="eb59fe93d776ae163bff913d98e46855";

        if (!$token) {
            throw new \Exception('Error: Parameter token is missing');
        }

        $headers = ['Authorization' => "Token " . $token];

        $client = new \GuzzleHttp\Client();

        try {
            $response = $client->request($type, $endpoint, [
                'headers' => $headers,
                'body' => $file
            ]);
        } catch (\Exception $e) {
            throw new \Exception('Error: API is not accessible: ' . $e->getMessage());
        }

        $responseBody = json_decode($response->getBody()->getContents())->results;

        return ($responseBody);
    }
}
