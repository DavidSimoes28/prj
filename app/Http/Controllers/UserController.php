<?php

namespace App\Http\Controllers;

use App\User;
use App\Tipos_licenca;
use Illuminate\Support\Arr;
use App\Classes_certificado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\StoreUserRequest;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\SearchUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Http\Requests\PasswordUserRequest;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{   
    private $certificados = array();
    private $licencas = array();

    public function __construct()
    {
        $this->middleware('auth');
        $this->certificados = Classes_certificado::all();
        $this->licencas = Tipos_licenca::all();

    }
    
    public function index()
    {   
      
        if ( !request()->query() ){

            if(Auth::User()->isAdmin()){
                $users = User::paginate(20);
            }else{
                $users =  User::where('ativo', true);
                $users = $users->paginate(20);
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
            ->paginate(20)->appends(request()->query());
            
            return view('users.listUser', compact('users'));
    }

    public function create(){
        $this->authorize('create', User::class);
        $user = new User();
        return view('users.addUser',compact('user'));
    }

    public function store(StoreUserRequest $request){
        $this->authorize('create', User::class);
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
                $user->fill(["foto_url" => $name_foto]);
            }
        }
        
        $user->save();
        $user->sendEmailVerificationNotification();
        return redirect()->route('socios')->with("success","Sócio inserido com sucesso.");
    }

    public function edit(User $user){
        $this->authorize('update',$user);
        $certificados = $this->certificados;
        $licencas = $this->licencas;


        return view('users.editUser',compact('user','certificados','licencas'));
    }

    public function update(UpdateUserRequest $request, User $user){
        $this->authorize('update',$user);
        $validated = $request->all();
        unset($validated['file_licenca']);
        unset($validated['file_certificado']);
        
        
        $user->fill($validated);
        
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
            if ($user->hasCertificado()) Storage::disk('public')->delete('docs_piloto',$certificado,"certificado_".$user->id.".pdf");
            Storage::putFileAs('docs_piloto',$certificado,"certificado_".$user->id.".pdf");
        }

        if($request->file_licenca!=NULL){
            $licenca = $request->file('file_licenca');
            if ($user->hasLicenca()) Storage::disk('public')->delete('docs_piloto',$licenca,"licenca_".$user->id.".pdf");
            Storage::putFileAs('docs_piloto',$licenca,"licenca_".$user->id.".pdf");
        }
        unset($validated['file_foto']);

        if($user->licenca_confirmada == 0){
            $user->licenca_confirmada = null;
        }
        if($user->certificado_confirmado == 0){
            $user->certificado_confirmado = null;
        }
        
        $user->save();
        return redirect()->route('socios')->with("success","Sócio atualizado com sucesso.");
    }

    public function destroy(User $user){
        $this->authorize('delete',$user);
        $user->delete();
        return redirect()->route('socios')->with("success","Sócio apagado com sucesso.");
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
        return redirect()->route('socios')->with("success","Password atualizada com sucesso.");
    }

    public function mostrarLicenca(User $user){
        if(($user->id == Auth::user()->id || Auth::user()->isAdmin()) && $user->hasLicenca()){
            $path = storage_path('app/docs_piloto/' . 'licenca_' . $user->id . '.pdf');
            return response()->file($path);
        }
        abort(403,"Não pode consultar licencas de outros Socios");
    }
    public function mostrarCertificado(User $user){
        if(($user->id == Auth::user()->id || Auth::user()->isAdmin()) && $user->hasCertificado()){
            $path = storage_path('app/docs_piloto/' . 'certificado_' . $user->id . '.pdf');
            return response()->file($path);
        }
        abort(403,"Não pode consultar certificados de outros Socios");
    }
    public function downloadLicenca(User $user){
        return Response::download(asset('storage/app/docs_piloto/' . 'licenca_' . $user->id . '.pdf'));
    }
    public function downloadCertificado(User $user){
        return Response::download(storage_path('app/docs_piloto/' . 'certificado_' . $user->id . '.pdf'));
    }

    public function definirQuotas(User $user){
        $this->authorize('before',$user);
        $user->update(['quota_paga' => !$user->quota_paga]);
        return redirect()->route('socios');
    }
    public function definirAtivo(User $user){
        $this->authorize('before',$user);
        $user->update(['ativo' => !$user->ativo]);
        return redirect()->route('socios');
    }

    public function reset_quotas(){
        if(Auth::user()->isAdmin()){
            DB::table('users')->update(['quota_paga' => 0]);
            //User::get()->update(['quota_paga' => 0]);
            return redirect()->route('socios');
        }
        return redirect()->route('socios');
    }
    public function desativar_sem_quotas(){
        if(Auth::user()->isAdmin()){
            User::where('quota_paga',false)->update(['ativo' => 0]);
            return redirect()->route('socios');
        }
        return redirect()->route('socios');
    }
}
