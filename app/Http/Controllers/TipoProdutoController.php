<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TipoProduto;
use Illuminate\Support\Facades\DB;

class TipoProdutoController extends Controller
{
    /**
     * Display a listing of the resource.
     * Mostra uma lista com todos os recursos cadastrados.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            // SELECT * FROM TIPO_PRODUTOS e armazenando o resultado no objeto $tipoProdutos
            // Esse objeto é um vetor de models
            //$tipoProdutos = TipoProduto::all();
            $tipoProdutos = DB::select('SELECT * FROM TIPO_PRODUTOS');

        } catch(\Throwable $th){
            return $this->indexMessage([$th->getMessage(), "danger"]);
        }        
        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexMessage($message)
    {  
        try{

            $tipoProdutos = DB::select('SELECT * FROM TIPO_PRODUTOS');

        } catch (\Throwable $th){   
            return view("TipoProduto/index")->with("tipoProdutos", [])->with("message", [$th->getMessage(), "danger"]); 
        }        
        // redirect('/produto');
        return view("TipoProduto/index")->with("tipoProdutos", $tipoProdutos)->with("message", $message);       
    }

    /**
     * Show the form for creating a new resource.
     * Mostrar um formulário para criação de um novo recurso
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view("TipoProduto/create");
    }

    /**
     * Store a newly created resource in storage.
     * Armazena um recurso recém criado na base de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $tipoProduto = new TipoProduto();
        $tipoProduto->descricao = $request->descricao;
        $tipoProduto->save();
        return $this->index();
    }

    /**
     * Display the specified resource.
     * Mostra um recurso específico em detalhes.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tipoProduto = DB::select("SELECT
                    tipo_produtos.id as id,
                    tipo_produtos.descricao as descricao,
                    tipo_produtos.updated_at as updated_at,
                    tipo_produtos.created_at as created_at
                from tipo_produtos
                where id = ?", [$id]);


        if(count($tipoProduto) > 0)
        return view("TipoProduto/show")->with("tipoProduto", $tipoProduto[0]);

        echo "Tipo de Produto não encontrado não encontrado!";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tipoproduto = TipoProduto::find($id);

        if(isset($tipoproduto)){
            //dd($tipoproduto);
            return view("TipoProduto/edit")
                                        ->with("tipoproduto", $tipoproduto);

        }
        //#TODO implementar tratamento de exceção

        echo "Tipo de produto não encontrado";
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
        $tipoproduto = TipoProduto::find($id);

       if(isset($tipoproduto)){
           $tipoproduto->descricao = $request->descricao;
           $tipoproduto->update();
           //Recarregar view index:
           return $this->index();
       }
       //Tratar exceções.
       echo "Produto não encontrado";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $tipoproduto = Produto::find($id); // Retorna o objeto encontrado ou null, caso ñ encontrado
        // Se o produto foi encontrado
        if( isset($tipoproduto) ) {
            $tipoproduto->delete();
            return \Redirect::route('tipoproduto.index');
            //return $this->index();
        }
        else{
            echo "Tipo Produto não encontrado";
        }
    }
}
