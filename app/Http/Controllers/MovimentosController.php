<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimento;
use Illuminate\Support\Facades\Auth;

class MovimentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $movimentos = Movimento::with("pilotos","instrutores")->orderBy('data','desc')->paginate(15);
        //$movimentos = Movimento::where("piloto_id",Auth::user()->id)->orderBy('data','desc')->paginate(15);
        return view('movimentos.listMovimentos', compact('movimentos'));
    }
}
