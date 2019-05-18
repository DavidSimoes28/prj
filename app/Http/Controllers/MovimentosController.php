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
        
        if ( !count ( $_GET ) ){

            $movimentos = Movimento::with("pilotos","instrutores")->orderBy('data','desc')->paginate(14);
            //$movimentos = Movimento::where("piloto_id",Auth::user()->id)->orderBy('data','desc')->paginate(14);
            return view('movimentos.listMovimentos', compact('movimentos'));

        }


        $movimentos = Movimento::where(function ($query) {

            $id =  request()->id;
            $piloto_id =  request()->piloto_id;
            $instrutor_id =  request()->instrutor_id;
            $aeronave =  request()->aeronave;
            $data_inicio =  request()->data_inicio;
            $data_fim =  request()->data_fim;
            $natureza =  request()->natureza;
            $confirmado =  request()->confirmado;

            //$query->where("piloto_id",Auth::user()->id);

            //if ( !Auth::User()->isAdmin() ) $query->where('ativo', true );

            if ( $id != null ) $query->where('id', $id );

            if ( $piloto_id != null ) $query->where('piloto_id', $piloto_id );

            if ( $instrutor_id != null ) $query->where('instrutor_id', $instrutor_id );

            if ( $aeronave != null ) $query->where('aeronave', $aeronave );

            if ( $data_inicio != null ) $query->where('data_inicio', $data_inicio );

            if ( $data_fim != null ) $query->where('data_fim', $data_fim );

            if ( $data_fim != null ) $query->where('data_fim', $data_fim );

            if ( $natureza != null ) $query->where('natureza', $natureza );

            if ( $confirmado != null ) $query->where('confirmado', $confirmado );
                    
            })
            ->orderBy('data','desc')->paginate(14)->appends(request()->query());
        
            return view('movimentos.listMovimentos', compact('movimentos'));

    }
}
