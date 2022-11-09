<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\UserInfo;
use Illuminate\Support\Facades\Auth; 

class UserInfoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web'); //Especificando guarda.
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try{
            $userInfos = DB::select('SELECT User_Infos.Users_id,
                                       User_Infos.profileImg,
                                       User_Infos.status,
                                       User_Infos.dataNasc,
                                       User_Infos.genero,
                                       User_Infos.updated_at,
                                       User_Infos.created_at
                                FROM User_Infos');
        } catch(\Throwable $th){
            return $this->goToCreate([$th->getMessage(), "danger"]);
        }        
        // redirect('/produto');
        return view("UserInfo/index")->with("userInfos", $userInfos);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // if(Auth::check()){
        //     $user = Auth::user();
        //     echo "<p> $user->id </p>";
        //     echo "<p> $user->name </p>";
        //     echo "<p> $user->email </p>";
        //     echo "<p> $user->password </p>";

        // }

        // else{
        //     echo "<p> Sem usuário logado </p>";
        // }

        return view("UserInfo/create");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $loggedUserId = Auth::user()->id;
    try{
        $userInfos = new UserInfo();
        $userInfos->Users_id = $loggedUserId;
        $userInfos->profileImg = $request->profileImg;
        $userInfos->status = 'A';
        $userInfos->dataNasc = $request->dataNasc;
        $userInfos->genero = $request->genero;
        $userInfos->save();
    } catch (\Throwable $th){
        return $this->goToCreate([$th->getMessage(), "danger"]);
    }

        return $this->goToCreate(["Informações do usuário cadastradas com sucesso", "success"]);
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
            $userInfos = DB::select("SELECT User_Infos.Users_id,
                                    User_Infos.profileImg,
                                    User_Infos.status,
                                    User_Infos.dataNasc,
                                    User_Infos.genero,
                                    User_Infos.updated_at,
                                    User_Infos.created_at
                            FROM User_Infos
                                WHERE User_Infos.Users_id = ?", [$id]);

            if(count($userInfos) > 0){
                return view("UserInfo/show")->with("userInfos", $userInfos[0]);
            }
            return $this->goToCreate(["userInfo não encontrado", "warning"]);

        } catch (\Throwable $th){
            return $this->goToCreate([$th->getMessage(), "danger"]);
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
            $userInfos = UserInfo::find($id);
            if( isset($userInfos) ){
              
                return view("UserInfo/edit")
                            ->with("userInfos", $userInfos);
            }
          //  return $this->goToCreate(["User Info não encontrada", "warning"]);

        } catch (\Throwable $th){
         //   return $this->goToCreate([$th->getMessage(), "danger"]);
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
            $loggedUserId = Auth::user()->id;
            $userInfos = UserInfo::find($id); 

            if( isset($userInfos) ){
                $userInfos->Users_id = $loggedUserId;
                $userInfos->profileImg = $request->profileImg;
                $userInfos->dataNasc = $request->dataNasc;
                $userInfos->genero = $request->genero;
                $userInfos->update();
                //return "atualizado";
             return redirect()->route('userinfo.show', 1)->with("userInfos", $userInfos)->with("message",["teste", "danger"]);
            }
            //return "não encontrado";
             return $this->goToCreate(["User Info não encontrado", "warning"]);
            
        } catch (\Throwable $th){
           // return $th->getMessage();
             return $this->goToCreate([$th->getMessage(), "danger"]);
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
        $userInfos = UserInfo::find($id); // Retorna o objeto encontrado ou null, caso ñ encontrado
        // Se o produto foi encontrado
        if( isset($userInfos) ) {
            $userInfos->delete();
            return \Redirect::route('userinfo.create');
            //return $this->index();
        }
        else{
            echo "User Info não encontrado";
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function goToCreate($message)
    {  
            return view("UserInfo/create")->with("message", $message); 
    }
}
