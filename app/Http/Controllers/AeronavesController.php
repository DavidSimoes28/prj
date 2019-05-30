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

        $precos = [];
        $minutos = [];
        
        if(empty($precos[0])){
            for($i=1;$i<=10;$i++){
                $precos[$i] = $request->precos[$i-1];
            }
        }else{
            $minutos = $request['tempos'];
        }

        if(empty($minutos[0])){
            for($i=1;$i<=10;$i++){
                $minutos[$i] = $request->tempos[$i-1];
            }
        }else{
            $precos = $request['precos'];
        }

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

        /*$precos = [];
        $minutos = [];
        if (!empty($request->tempos[0])){
            foreach ($request->tempos as $index => $i){
                $minutos [$index+1] = $i;
            }
        }else{
            $minutos = $request['tempos'];
        }

        if (!empty($request->precos[0])){
            foreach ($request->precos as $index => $i){
                $precos [$index+1] = $i;
            }
        }else{
            $precos = $request['precos'];
        }
        
        var_dump($minutos,$precos);*/
        $precos = [];
        $minutos = [];
        
        if(empty($precos[0])){
            for($i=1;$i<=10;$i++){
                $precos[$i] = $request->precos[$i-1];
            }
        }else{
            $minutos = $request['tempos'];
        }

        if(empty($minutos[0])){
            for($i=1;$i<=10;$i++){
                $minutos[$i] = $request->tempos[$i-1];
            }
        }else{
            $precos = $request['precos'];
        }

        $valores=[];
        for($i=1;$i<=10;$i++){
            $valores = Aeronaves_valore::where('matricula',$aeronave->matricula)->where('unidade_conta_horas','=',$i)->update(['minutos' => $minutos[$i], 'preco' => $precos[$i],'unidade_conta_horas' => $i,'matricula' => $request->matricula]);
        }

        
        $precos = [];
        $minutos = [];
        if (!empty($request->tempos[0])){
            foreach ($request->tempos as $index => $i){
                $minutos [$index+1] = $i;
            }
        }else{
            $minutos = $request['tempos'];
        }

        if (!empty($request->precos[0])){
            foreach ($request->precos as $index => $i){
                $precos [$index+1] = $i;
            }
        }else{
            $precos = $request['precos'];
        }
        
        var_dump($minutos,$precos);

        
        return redirect()->route('aeronaves')->with("success","Aeronave editada com sucesso.");
    }

    public function destroy(Aeronave $aeronave){
        $this->authorize('delete', $aeronave);

        if ( !$aeronave->aeronave_movimentos->count() ) $aeronave->forceDelete();
        else $aeronave->delete();     
        
        return redirect()->route('aeronaves')->with("success","Aeronave apagada com sucesso.");
    }
}
