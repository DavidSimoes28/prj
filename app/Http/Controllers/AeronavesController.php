<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Aeronave;

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
        //$this->authorize('create',Aeronave::class); DAVIDDDDDDDDDDDDDDD
        $aeronave = new Aeronave();
        return view('aeronaves.addAeronave',compact('aeronave'));
    }
}
