<?php

namespace App\Http\Controllers;

use App\User;
use App\Movimento;
use Illuminate\Http\Request;

class PendentesController extends Controller
{
    public function index(){
        $movimentos = Movimento::where('confirmado','0')->get();

        $licencas = User::where('tipo_socio','P')
        ->whereNotNull('num_licenca')
        ->whereNull('licenca_confirmada')
        ->get();

        $certificados = User::where('tipo_socio','P')
        ->whereNotNull('num_certificado')
        ->whereNull('certificado_confirmado')
        ->get();

        $conflitos=array();

        return view('pendentes.listPendentes', compact('movimentos','certificados','licencas','conflitos'));
    }
    
}
