<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PasswordUserRequest;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $users = User::where('ativo', true)->paginate(15);
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
        if ($request->hasFile($user->foto_url)) {
            if ($request->file($user->foto_url)->isValid()) {
                $foto_url = $request->file('foto_url');
                $name_foto = time().$request->foto_url->getClientOriginalExtension();
                Storage::disk('public')->put('fotos',$request->foto_url);
                Storage::disk('public')->putFileAs('fotos',$foto_url,$name_foto);
                Storage::disk('public')->delete($user->foto_url);
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
