<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PasswordUserRequest;
use Illuminate\Support\Arr;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
       if(!Auth::User()->isAdmin()){
            $users =  User::where('ativo', true);
        }
        
        if ( !count ( $_GET ) ){
            if(Auth::User()->isAdmin()){
                $users = User::paginate(800);
            }else{
                $users = $users->paginate(800);
            }
            return view('users.listUser', compact('users'));
        }
        //dd(request(), request()->num_socio ,request()->num_socio , request()->query("num_socio") , request()->nome_informal, request()->query("nome_informal"), 
        //request()->tipo_socio, request()->query("tipo_socio"), request()->direcao, request()->query("direcao"));
        //no request na WEB está nos +request: ParameterBag {#51 ▶}  -->  #parameters: array:5 [▶]   OR    +query: ParameterBag {#51 ▶} --> #parameters: array:5 [▶]
        //Já traz valores null por default
        // request()->num_socio ou request()->query('num_socio')
        //Acho que o Query deve ser mais incidicado não sei

        $users = User::whereNull('deleted_at');

        $email =  $_GET ['email'] ?? null;
        $num_socio =  $_GET ['num_socio'] ?? null;
        $nome_informal =  $_GET ['nome_informal'] ?? null;
        $tipo_socio =  $_GET ['tipo'] ?? null;
        $direcao =  $_GET ['direcao'] ?? null;

        /*
            $users = User::where(function ($query) {
                if(nome_informal != null ) $query->where('votes', '>', 100);
                if(nome_informal != null ) $query->where('votes', '>', 100);
                ...
            })


            // se nao der procura no Google "laravel query builder"
        */

        if ( $email != null ){
            $users = $users->where('email', $email );
        }

        if ( $num_socio != null ){
            $users = $users->where('num_socio', $num_socio);
        }

        if ( $nome_informal != null ){
            $users = $users->where('nome_informal', $nome_informal);
        }

        if ( $tipo_socio != null && $tipo_socio != 'TODOS' ){
            $users = $users->where('tipo_socio', $tipo_socio);
        }

        if ( $direcao != null && $direcao != 'AMBOS' ){
            $users = $users->where('direcao', $direcao);
        }

        $users = $users->paginate(800); //->appends(request()->query()) or  ->appends(request())  ||isto permite usar o old no form sem usar $_get (Pesquisa se não tiveres a ver como é)
        return view('users.listUser', compact('users'));
    }

    public function create(){
        $this->authorize('create',User::class);
        $user = new User();
        return view('users.addUser',compact('user'));
    }

    public function store(StoreUserRequest $request){
        $this->authorize('create',User::class);
        $user = new User();
        $user->fill($request->all());
        $user->password=Hash::make($user->data_nascimento);
        $user->save();

        if ($request->hasFile('file_foto')) {
            if ($request->file('file_foto')->isValid()) {
                $foto_url = $request->file('file_foto');
                $name_foto = $user->id."_".$request->file_foto->hashName();
                Storage::disk('public')->putFileAs('fotos',$foto_url,$name_foto);
                $user->foto_url = $name_foto;
            }
        }
        $user->fill(["foto_url" => $name_foto]);
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect()->route('socios')->with("success","User successfully inserted");
    }

    public function edit(User $user){
        $this->authorize('update',$user);
        return view('users.editUser',compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $this->authorize('update',$user);
        $validated = $request->all();
        unset($validated['file_licenca']);
        unset($validated['file_certificado']);
        
        if(!Auth::User()->isAdmin()){
            $user->fill(Arr::except($validated,["id","num_socio","ativo","password_inicial","quota_paga",
            "sexo","tipo_socio","direcao","instrutor","aluno","certificado_confirmado" ,"licenca_confirmada","num_licenca",
            "tipo_licenca","validade_licenca","num_certificado","classe_certificado","validade_certificado"]));
        }else{
            $user->fill($validated);
        }
        if ($request->hasFile('file_foto')) {
            if ($request->file('file_foto')->isValid()) {
                $file_foto = $request->file('file_foto');
                $name_foto = $user->id."_".$request->file_foto->hashName();
                Storage::disk('public')->putFileAs('fotos',$file_foto,$name_foto);
                Storage::disk('public')->delete('fotos/'.$user->foto_url);
                $user->foto_url = $name_foto;
            }
        }
        if($request->file_certificado!=NULL){
            $certificado = $request->file('file_certificado');
            Storage::putFileAs('docs_piloto',$certificado,"certificado_".$user->id.".pdf");
            $user->certificado_confirmada = 0;
        }

        if($request->file_licenca!=NULL){
            $licenca = $request->file('file_licenca');
            Storage::putFileAs('docs_piloto',$licenca,"licenca_".$user->id.".pdf");
            $user->licenca_confirmada = 0;
        }
        unset($validated['file_foto']);
        $user->save();
        return redirect()->route('socios')->with("success","User successfully updated");
    }

    public function destroy(User $user){
        $this->authorize('delete',$user);
        $user->delete();
        return redirect()->route('socios')->with("success","User successfully updated");
    }

    public function showPass(){
        
        $user = Auth::user();
        return view('auth.passwords.replace',compact('user'));
    }

    public function updatePass(PasswordUserRequest $request){
        
        if (!Hash::check($request->old_password,Auth::user()->password)){
            return redirect()->route('password.showPass')->withErrors(['old_password'=>'Old Password is not correct !!']); 
        }
        $user = User::findOrFail(Auth::user()->id);
        $user->password=Hash::make($request->password);
        $user->save();
        return redirect()->route('socios')->with("success","User password updated");
    }

}
