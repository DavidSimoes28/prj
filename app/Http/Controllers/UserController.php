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
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
      
        if ( !request()->query() ){

            if(Auth::User()->isAdmin()){
                $users = User::paginate(800);
            }else{
                $users =  User::where('ativo', true);
                $users = $users->paginate(800);
            }

            return view('users.listUser', compact('users'));
        }

        $users = User::where(function ($query) {

            $email =  request()->email;
            $num_socio =  request()->num_socio;
            $nome_informal =  request()->nome_informal;
            $tipo =  request()->tipo;
            $ativo =  request()->ativo;
            $quotas_pagas =  request()->quotas_pagas;
            $direcao =  request()->direcao;

            if ( !Auth::User()->isAdmin() ) $query->where('ativo', true );

            if ( Auth::User()->isAdmin() ){
                if(!is_null($ativo)) $query->where('ativo', $ativo ); 
                if(!is_null($quotas_pagas)) $query->where('quota_paga', $quotas_pagas );
            }

            if ( !empty($email) ) $query->where('email','LIKE','%'.$email.'%');

            if ( !empty($num_socio) ) $query->where('num_socio', $num_socio);

            if ( !empty($nome_informal)) $query->where('nome_informal', 'LIKE' ,'%'.$nome_informal.'%');

            if ( !empty($tipo) && $tipo != 'TODOS' ) $query->where('tipo_socio', $tipo);

            if ( !empty($direcao) && $direcao != 'AMBOS' ) $query->where('direcao', $direcao);
                    
            })
            ->paginate(800)->appends(request()->query());
            
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
            $user->certificado_confirmado = 0;
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

    public function mostrarLicenca(User $user){
        $path = storage_path('app/docs_piloto/' . 'licenca_' . $user->id . '.pdf');
        return response()->file($path);
    }
    public function mostrarCertificado(User $user){
        $path = storage_path('app/docs_piloto/' . 'certificado_' . $user->id . '.pdf');
        return response()->file($path);
    }
    public function downloadLicenca(User $user){
        return Response::download(asset('storage/app/docs_piloto/' . 'licenca_' . $user->id . '.pdf'));
    }
    public function downloadCertificado(User $user){
        return Response::download(storage_path('app/docs_piloto/' . 'certificado_' . $user->id . '.pdf'));
    }

    public function definirQuotas(User $user){
        $user->update(['quota_paga' => !$user->quota_paga]);
        return redirect()->route('socios');
    }
    public function definirAtivo(User $user){
        $user->update(['ativo' => !$user->ativo]);
        return redirect()->route('socios');
    }
}
