<?php

namespace App\Http\Controllers;

use App\Models\Aeronave;
use App\Aeronaves_valore;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAeronaveRequest;
use App\Http\Requests\UpdateAeronaveRequest;

class AeronavesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {   
        $aeronaves = Aeronave::paginate(20);
        return view('aeronaves.listAeronave', compact('aeronaves'));
    }

    public function create()
    {
        $this->authorize('create', Aeronave::class);

        $aeronave = new Aeronave();
        return view('aeronaves.addAeronave',compact('aeronave'));
        
    }

    public function store (StoreAeronaveRequest $request){ 
        $this->authorize('create', Aeronave::class);

        $aeronave = new Aeronave();
        $aeronave->fill($request->except(['precos.*','tempos.*']));

        $aeronave->save();

        $precos = $request->precos;
        $minutos = $request->tempos;

        for($i=1;$i<=10;$i++){
            $valores = Aeronaves_valore::create(['minutos' => $minutos[$i], 'preco' => $precos[$i],'unidade_conta_horas' => $i,'matricula' => $request->matricula]);
        }
        $valores->save();
            
        return redirect()->route('aeronaves')->with("success","Aeronave inserida com sucesso.");
    }

    public function edit(Aeronave $aeronave)
    {
        $this->authorize('update', $aeronave);
        $valores = Aeronaves_valore::where("matricula",$aeronave->matricula);
        $valores = $valores->take(10)->get();
        return view('aeronaves.editAeronave',compact('aeronave','valores'));
               
    }    

    public function update(UpdateAeronaveRequest $request, Aeronave $aeronave){
        
        $this->authorize('update', $aeronave);

        $aeronave->fill( $request->except(['precos.*','tempos.*', 'matricula']));
        $aeronave->save();

        $precos = $request->precos;
        $minutos = $request->tempos;
        $valores=[];
        for($i=1;$i<=10;$i++){
            $valores = Aeronaves_valore::where('matricula',$aeronave->matricula)->where('unidade_conta_horas','=',$i)->update(['minutos' => $minutos[$i], 'preco' => $precos[$i],'unidade_conta_horas' => $i,'matricula' => $request->matricula]);
        }
        
        return redirect()->route('aeronaves')->with("success","Aeronave editada com sucesso.");
    }

    public function destroy(Aeronave $aeronave){
        $this->authorize('delete', $aeronave);

        if ( !$aeronave->aeronave_movimentos->count() ) $aeronave->forceDelete();
        else $aeronave->delete();     
        
        return redirect()->route('aeronaves')->with("success","Aeronave apagada com sucesso.");
    }
}
