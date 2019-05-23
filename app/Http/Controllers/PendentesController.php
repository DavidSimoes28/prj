<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;

class PendentesController extends Controller
{
    public function index(){
        $pendentes = Movimento::where('confirmado','0')->paginate(5);
        return view('pendentes.listPendentes', compact('pendentes'));
    }
    
}
