<?php

namespace App\Http\Controllers;

use App\Models\Aeronave;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAeronaveRequest;

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
        $aeronave = new Aeronave();
        $aeronave->fill($request->all());
        $aeronave->save();
        return redirect()->route('aeronaves')->with("success","aeronave successfully inserted");
    }
}
