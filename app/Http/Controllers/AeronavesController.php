<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aeronave;

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
}
