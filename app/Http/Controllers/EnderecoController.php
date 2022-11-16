<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Endereco;
use App\Models\User;

class EnderecoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $enderecos = DB::select('SELECT *
                                FROM Enderecos');
        } catch(\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }
        
        return view("Endereco/index")->with("enderecos", $enderecos);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMessage($message)
    {  
        try{
            $enderecos = DB::select('SELECT *
                                FROM enderecos');
        } catch (\Throwable $th){   
            return view("Endereco/index")->with("enderecos", [])->with("message", [$th->getMessage(), "danger"]); 
        }        
        
        return view("Endereco/index")->with("enderecos", $enderecos)->with("message", $message);       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("Endereco/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $loggedUserId = Auth::user()->id;
            $endereco = new Endereco();
            $endereco->Users_id = $loggedUserId;
            $endereco->bairro = $request->bairro;
            $endereco->logradouro = $request->logradouro;
            $endereco->numero = $request->numero;
            $endereco->complemento = $request->complemento;
            $endereco->save();
        } catch (\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }        
        
        return $this->indexMessage(["Produto cadastrado com sucesso", "success"]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try{
            $enderecos = DB::select("SELECT *
                                FROM enderecos
                                WHERE enderecos.id = ?", [$id]);
                                

            if(count($enderecos) > 0){
                
                return view("Endereco/show")->with("endereco", $enderecos[0]);
            }
            return $this->indexMessage(["Endereço não encontrado", "warning"]);

        } catch (\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try{
            $endereco = Endereco::find($id);

            if( isset($endereco) ){

                return view("Endereco/edit")
                            ->with("endereco", $endereco);
            }
            return $this->indexMessage(["Endereço não encontrado", "warning"]);

        } catch (\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }   
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try{

            $endereco = Endereco::find($id); 

            if( isset($endereco) ){
                $endereco->bairro = $request->bairro;
                $endereco->logradouro = $request->logradouro;
                $endereco->numero = $request->numero;
                $endereco->complemento = $request->complemento;
                $endereco->update();

                return $this->indexMessage(["Endereço atualizado com sucesso", "success"]);
            }
            return $this->indexMessage(["Endereço não encontrado", "warning"]);
            
        } catch (\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        } 
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $endereco = Endereco::find($id);

        if( isset($endereco) ) {
            $endereco->delete();
            return \Redirect::route('endereco.index');
        }
        else{
            echo "Endereço não encontrado";
        }
    }
}
