<?php

namespace App\Http\Controllers;

use App\Models\Aeronave;
use Illuminate\Http\Request;
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
        $aeronaves = Aeronave::whereNull('deleted_at')->get();//->paginate(14);
        return view('aeronaves.listAeronave', compact('aeronaves'));
    }

    public function create()
    {
        $this->authorize('create',Aeronave::class);

        $aeronave = new Aeronave();
        return view('aeronaves.addAeronave',compact('aeronave'));
        
    }

    public function store (StoreAeronaveRequest $request){ 
        $this->authorize('create',Aeronave::class);
               
        $aeronave = new Aeronave();
        $aeronave->fill($request->all());
        $aeronave->save();
        return redirect()->route('aeronaves')->with("success","Aeronave inserida com sucesso.");
    }

    public function edit(Aeronave $aeronave)
    {
        $this->authorize('update',$aeronave);
        return view('aeronaves.editAeronave',compact('aeronave'));
               
    }    

    public function update(UpdateAeronaveRequest $request, Aeronave $aeronave){
        //dd ($request);
        $this->authorize('update',$aeronave);
        $matricula = $aeronave->matricula;

        $aeronave->fill($request->all());

        $aeronave->matricula = $matricula;

        $aeronave->save();
        return redirect()->route('aeronaves')->with("success","Aeronave editada com sucesso.");
    }

    public function destroy(Aeronave $aeronave){
        $this->authorize('delete',$aeronave);
        $aeronave->delete();
        return redirect()->route('aeronaves')->with("success","Aeronave apagada com sucesso.");
    }
}
