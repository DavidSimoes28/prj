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
        
    if ( !request()->query() ){

        $movimentos = Movimento::with("pilotos","instrutores")->orderBy('data','desc')->paginate(14);
        //$movimentos = Movimento::where("piloto_id",Auth::user()->id)->orderBy('data','desc')->paginate(14);
        return view('movimentos.listMovimentos', compact('movimentos'));

    }
    
    $movimentos = Movimento::with("pilotos","instrutores");

    if (request()->nome_informal_piloto != null){

        $movimentos = $movimentos->whereHas('pilotos', function ($query) {

            $nome_informal_piloto =  request()->nome_informal_piloto;
            $query->where('nome_informal', $nome_informal_piloto );

        });

    }

    if (request()->nome_informal_instrutor != null){

        $movimentos =  $movimentos->whereHas('instrutores', function ($query) {

            $nome_informal_instrutor =  request()->nome_informal_instrutor;
            $query->where('nome_informal', $nome_informal_instrutor );

        });

    }

    $movimentos = $movimentos->where(function ($query) {

        $id =  request()->id;
        $aeronave =  request()->aeronave;
        $data_inicio =  request()->data_inicio;
        $data_fim =  request()->data_fim;
        $natureza = request()->natureza;
        $confirmado =  request()->confirmado;

        if ( $id != null ) $query->where('id', $id );

        if ( $aeronave != null ) $query->where('aeronave', $aeronave );

        if ( $data_inicio != null && $data_fim != null ) {

            $query->whereBetween('data', array($data_inicio, $data_fim));

        }

        if ( $natureza != null && ($natureza == "T" || $natureza == "E" || $natureza == "I") ) $query->where('natureza', $natureza );

        if ( $confirmado != null && ( $confirmado == "1" || $confirmado == "0" ) ) $query->where('confirmado', $confirmado );
                
        });
    

    $movimentos = $movimentos->orderBy('data','desc')->paginate(14)->appends(request()->query());

    return view('movimentos.listMovimentos', compact('movimentos'));

    }
}
