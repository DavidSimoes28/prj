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

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
        $users = User::where('ativo', true);
        if ( !count ( $_GET ) ){
            $users = $users->paginate(14);
            return view('users.listUser', compact('users'));
        }

        $email =  $_GET ['email'] ?? null;
        $num_socio =  $_GET ['num_socio'] ?? null;
        $nome_informal =  $_GET ['nome_informal'] ?? null;
        $tipo_socio =  $_GET ['tipo_socio'] ?? null;
        $direcao =  $_GET ['direcao'] ?? null;

        if ( $email != null ){
            $users = $users->where('email', 'LIKE', "%".$email."%" );
        }

        if ( $num_socio != null ){
            $users = $users->where('num_socio', 'LIKE', "%".$num_socio."%" );
        }

        if ( $nome_informal != null ){
            $users = $users->where('nome_informal', 'LIKE', "%".$nome_informal."%" );
        }

        if ( $tipo_socio != null && $tipo_socio != 'TODOS' ){
            $users = $users->where('tipo_socio', $tipo_socio);
        }

        if ( $direcao != null && $direcao != 'AMBOS' ){
            $users = $users->where('direcao', $direcao);
        }

        $users = $users->paginate(14);
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

        if ($request->hasFile('foto_url')) {
            if ($request->file('foto_url')->isValid()) {
                $foto_url = $request->file('foto_url');
                $name_foto = $user->id."_".$request->foto_url->hashName();
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
        unset($validated['licenca_pdf']);
        unset($validated['certificado_pdf']);
        $user->fill($validated);
        if ($request->hasFile('foto_url')) {
            if ($request->file('foto_url')->isValid()) {
                $foto_url = $request->file('foto_url');
                $name_foto = $user->id."_".$request->foto_url->hashName();
                Storage::disk('public')->putFileAs('fotos',$foto_url,$name_foto);
                Storage::disk('public')->delete('fotos/'.$user->foto_url);
                $user->foto_url = $name_foto;
            }
        }
        if($request->certificado_pdf!=NULL){
            $certificado = $request->file('certificado_pdf');
            Storage::putFileAs('docs_piloto',$certificado,"certificado_".$user->id.".pdf");
            $user->certificado_confirmada == 0;
        }

        if($request->licenca_pdf!=NULL){
            $licenca = $request->file('licenca_pdf');
            Storage::putFileAs('docs_piloto',$licenca,"licenca_".$user->id.".pdf");
            $user->licenca_confirmada == 0;
        }
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
        return view('passwords.replace',compact('user'));
    }

    public function updatePass(PasswordUserRequest $request){
        
        if (!Hash::check($request->old_password,Auth::user()->password)){
            return redirect()->route('password.showPass')->with("error","Passwords don't match"); 
        }
        $user = Auth::user();
        $user->password=Hash::make($request->password);
        $user->save();
        return redirect()->route('socios')->with("success","User password updated");
    }

}
