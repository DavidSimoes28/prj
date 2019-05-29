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
        ->where('licenca_confirmada','0')
        ->get();

        $certificados = User::where('tipo_socio','P')
        ->whereNotNull('num_certificado')
        ->where('certificado_confirmado','0')
        ->get();

        $conflitos=array();

        return view('pendentes.listPendentes', compact('movimentos','certificados','licencas','conflitos'));
    }
    
}
