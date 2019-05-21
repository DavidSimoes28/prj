<?php

namespace App\Http\Controllers;

use App\Movimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMovimentoRequest;

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
    $isPiloto = Auth::user()->tipo_socio == 'P';


    // PROCURA NA DB OS PILOTOS QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
    $piloto_filtro = request()->nome_informal_piloto;

    if ( $piloto_filtro != null ){

        $movimentos =  $movimentos->whereHas( 'pilotos', function ( $query ){

            $nome =  request()->nome_informal_piloto;
            if ( $nome != null ) $query->where( 'nome_informal', $nome );

    } );
    }


    // PROCURA NA DB OS INSTRUTORES QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
    $instrutor_filtro = request()->nome_informal_instrutor;

    if (  $instrutor_filtro != null ){

        $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){

            $nome =  request()->nome_informal_instrutor;
            if ( $nome != null ) $query->where( 'nome_informal', $nome );

    } );
    }


    //PROCURA POR ID, AERONAVE, DATAS DE VOO, NATUREZA E CONFIRMADO DOS MOVIMENTOS

    $movimentos = $movimentos->where(function ($query) {

        $id =  request()->id;
        $aeronave =  request()->aeronave;
        $data_inicio =  request()->data_inicio;
        $data_fim =  request()->data_fim;
        $natureza = request()->natureza;
        $confirmado =  request()->confirmado;

        if ( $id != null ) $query->where('id', $id );

        if ( $aeronave != null ) $query->where('aeronave', $aeronave );

        if ( $data_inicio != null) $query->where('data', ">=" , $data_inicio);
        
        if ($data_fim != null ) $query->where('data', "<=" , $data_fim);

        //$query->whereBetween('data', array($data_inicio, $data_fim));

        if ( $natureza != null && ($natureza == "T" || $natureza == "E" || $natureza == "I") ) $query->where('natureza', $natureza );

        if ( $confirmado != null && ( $confirmado == "1" || $confirmado == "0" ) ) $query->where('confirmado', $confirmado );
        
    });
    

        //SE O UTILIZADOR LOGADO FOR UM PILOTO TEM O FILTROS EXTRAS
        //VERIFICAR SE FOI INSERIDO ALGUM VALOR VALIDO

        if ( $isPiloto ){

            $voos_pessoais =  request()->voos_pessoais;

            if (  $voos_pessoais != null && (  $voos_pessoais=="I" ||  $voos_pessoais=="P" || $voos_pessoais=="TODOS" ) ){

                if ($voos_pessoais=="I"){
                    $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){

                        $nome =  Auth::user()->nome_informal;
                        $query->where( 'nome_informal', $nome );

                    });
                }
                elseif ($voos_pessoais=="P"){
                    $movimentos =  $movimentos->whereHas( 'pilotos', function ( $query ){

                        $nome =  Auth::user()->nome_informal;
                        $query->where( 'nome_informal', $nome );

                    });
                }
                else{

                    $movimentos_intrutor = $movimentos
                    ->WhereHas( 'instrutores',function ( $query ){

                        $nome =  Auth::user()->nome_informal;
                        $query->where( 'nome_informal', $nome );

                    })
                    ->orWhereHas( 'pilotos', function ( $query ){

                        $nome =  Auth::user()->nome_informal;
                        $query->where( 'nome_informal', $nome );

                    });

                    
                }

            }

        }
        

        



    $movimentos = $movimentos->orderBy('data','desc')->paginate(14)->appends(request()->query());

    return view('movimentos.listMovimentos', compact('movimentos'));

    }

    public function create(){
        $this->authorize('create',Movimento::class);
        $movimentos = new Movimento();
        return view('movimentos.addMovimentos',compact('movimentos'));
    }

    public function store (StoreMovimentoRequest $request){ 
        
        $this->authorize('create', Movimento::class);

        $movimento = new Movimento();
        $movimento->fill($request->all());
        dd($movimento);

        //'aeronave', falta verificar que existe
        
        //'confirmado', meter a 0 
        
        //'piloto_id', falta converter o próprio para o seu piloto id
        //'num_licenca_piloto',
        //'validade_licenca_piloto',
        //'tipo_licenca_piloto',
        //'num_certificado_piloto',
        //'validade_certificado_piloto',
        //'classe_certificado_piloto',
        
        //'tempo_voo', calculado
        //'preco_voo', calculado
         
        //'instrutor_id', falta converter o nome informal para id
        //'num_licenca_instrutor',
        //'validade_licenca_instrutor',
        //'tipo_licenca_instrutor',	
        //'num_certificado_instrutor'	,
        //'validade_certificado_instrutor',
        //'classe_certificado_instrutor'




























        $movimento->save();
        return redirect()->route('movimentos')->with("success","Movimento inserido com sucesso.");
    }

}
