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

            

            
                
            $movimentos = Movimento::whereHas('pilotos', function ($query) {

                $piloto_id =  request()->piloto_id;


                if ( $piloto_id != null ) $query->where('nome_informal', $piloto_id );

            });

            $movimentos =  $movimentos->whereHas('instrutores', function ($query) {

                $instrutor_id =  request()->instrutor_id;


                if ( $instrutor_id != null ) $query->where('nome_informal', $instrutor_id );

            });

            $movimentos =$movimentos->where(function ($query) {

                $id =  request()->id;
                $aeronave =  request()->aeronave;
                $data_inicio =  request()->data_inicio;
                $data_fim =  request()->data_fim;
                $natureza = request()->natureza;
                $confirmado =  request()->confirmado;
    
                if ( $id != null ) $query->where('id', $id );
    
                if ( $aeronave != null ) $query->where('aeronave', $aeronave );
    
                if ( $data_inicio != null ) $query->where('data_inicio', $data_inicio );
    
                if ( $data_fim != null ) $query->where('data_fim', $data_fim );
    
                if ( $data_fim != null ) $query->where('data_fim', $data_fim );
    
                if ( $natureza != null && ($natureza=="T" || $natureza=="E" || $natureza=="I") ) $query->where('natureza', $natureza );
    
                //if ( $confirmado != null ) $query->where('confirmado', $confirmado );
                        
                });
            

            $movimentos = $movimentos->orderBy('data','desc')->paginate(14)->appends(request()->query());
        
            return view('movimentos.listMovimentos', compact('movimentos'));

    }
}
