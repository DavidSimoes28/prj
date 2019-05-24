<?php

namespace App\Http\Controllers;

use App\User;
use App\Aerodromo;
use App\Movimento;
use App\Models\Aeronave;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreMovimentoRequest;
use App\Http\Requests\UpdateMovimentoRequest;

class MovimentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        
        if ( !request()->query() ){

            $movimentos = Movimento::with("pilotos","instrutores")->orderBy('data','desc')->paginate(20);
            //$movimentos = Movimento::where("piloto_id",Auth::user()->id)->orderBy('data','desc')->paginate(14);
            return view('movimentos.listMovimentos', compact('movimentos'));

        }

        
        $movimentos = Movimento::with("pilotos","instrutores");
        $isPiloto = Auth::user()->tipo_socio == 'P';

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


        // PROCURA NA DB OS PILOTOS QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
        $piloto_filtro = request()->nome_informal_piloto;

        if ( $piloto_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'pilotos', function ( $query ){

                $nome =  request()->nome_informal_piloto;
                if ( $nome != null ) $query->where( 'nome_informal', 'like' , '%' .$nome. '%');
                

        } );
        }


        // PROCURA NA DB OS INSTRUTORES QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
        $instrutor_filtro = request()->nome_informal_instrutor;

        if (  $instrutor_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){

                $nome =  request()->nome_informal_instrutor;
                if ( $nome != null ) $query->where( 'nome_informal', 'like' , '%' .$nome. '%' );

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

            if ( $id != null ) $query->where(  'id', 'like' , '%' .$id. '%'  );

            if ( $aeronave != null ) $query->where('aeronave', 'like' , '%' .$aeronave. '%' );

            if ( $data_inicio != null) $query->where('data', ">=" , $data_inicio);
            
            if ($data_fim != null ) $query->where('data', "<=" , $data_fim);

            //$query->whereBetween('data', array($data_inicio, $data_fim));

            if ( $natureza != null && ($natureza == "T" || $natureza == "E" || $natureza == "I") ) $query->where('natureza', $natureza );

            if ( $confirmado != null && ( $confirmado == "1" || $confirmado == "0" ) ) $query->where('confirmado', $confirmado );
            
        });
    


        $movimentos = $movimentos->orderBy('data','desc')->paginate(20)->appends(request()->query());

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
        
        $data=date("Y-m-d ",strtotime($request->data));
        $hora_descolagem=date("H:i:s",strtotime($request->hora_descolagem));
        $hora_aterragem=date("H:i:s",strtotime($request->hora_aterragem));
        
        $movimento->hora_descolagem = $data.$hora_descolagem;
        $movimento->hora_aterragem = $data.$hora_aterragem;

        $aeronave = Aeronave::where('matricula',$request->aeronave)->first();
        $movimento->aeronave_movimentos()->associate($aeronave);

        $movimento->tempo_voo=$this->calculaTempoViagem($request->hora_descolagem,$request->hora_aterragem);
        $movimento->preco_voo=$this->calculaPrecoViagem();

        $parceiro=Auth::user();
        if($request->is_piloto){
            $movimento=$this->atribuirPiloto($parceiro,$movimento);
        } else{
            $movimento=$this->atribuirInstrutor($parceiro,$movimento);
        }       

        $movimento->confirmado=0; 

        if($request->natureza=='I'){

            $parceiro = User::where('nome_informal',$request->nome_informal)->first();
            

            if($request->is_piloto){
                $movimento=$this->atribuirInstrutor($parceiro,$movimento);

            }else{
                $movimento=$this->atribuirPiloto($parceiro,$movimento);
            }

        }else{
            $movimento->instrutor_id=null;
            $movimento->num_licenca_instrutor=null;
            $movimento->validade_licenca_instrutor=null;
            $movimento->tipo_licenca_instrutor=null;
            $movimento->num_certificado_instrutor=null;
            $movimento->validade_certificado_instrutor=null;
            $movimento->classe_certificado_instrutor=null;         
        }

        $movimento->save();
        return redirect()->route('movimentos')->with("success","Movimento inserido com sucesso.");
    }

    private function atribuirInstrutor($instrutor,$movimento){

        $movimento->num_licenca_instrutor=$instrutor->num_licenca;
        $movimento->validade_licenca_instrutor=$instrutor->validade_licenca;
        $movimento->tipo_licenca_instrutor=$instrutor->tipo_licenca;
        $movimento->num_certificado_instrutor=$instrutor->num_certificado;
        $movimento->validade_certificado_instrutor=$instrutor->validade_certificado;
        $movimento->classe_certificado_instrutor=$instrutor->classe_certificado;

        return $movimento->instrutores()->associate($instrutor);
    }

    private function atribuirPiloto($piloto,$movimento){

        $movimento->num_licenca_piloto=$piloto->num_licenca;
        $movimento->validade_licenca_piloto=$piloto->validade_licenca;
        $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
        $movimento->num_certificado_piloto=$piloto->num_certificado;
        $movimento->validade_certificado_piloto=$piloto->validade_certificado;
        $movimento->classe_certificado_piloto=$piloto->classe_certificado;

        return $movimento->pilotos()->associate($piloto);
    }

    private function calculaTempoViagem($hora_descolagem, $hora_aterragem){ 
        
        return (strtotime($hora_aterragem)-strtotime($hora_descolagem))/60;
    }

    ////FALTA IMPLEMENTAR//////////////////////////////////////////////////////////////////////////////////////////////////////////////
    private function calculaPrecoViagem(){ 
        return 410.05;
    }

    public function edit(Movimento $movimento)
    {
        $this->authorize('update', $movimento);

        return view('movimentos.editMovimentos',compact('movimento'));
               
    }    

    public function update(UpdateMovimentoRequest $request, Movimento $movimento){
        
        $this->authorize('update', $movimento);

        $movimento->fill( $request->all() );

        
        $data=date("Y-m-d ",strtotime($request->data));
        $hora_descolagem=date("H:i:s",strtotime($request->hora_descolagem));
        $hora_aterragem=date("H:i:s",strtotime($request->hora_aterragem));
        
        $movimento->hora_descolagem = $data.$hora_descolagem;
        $movimento->hora_aterragem = $data.$hora_aterragem;

        $aeronave = Aeronave::where('matricula',$request->aeronave)->first();
        $movimento->aeronave_movimentos()->associate($aeronave);

        $movimento->tempo_voo=$this->calculaTempoViagem($request->hora_descolagem,$request->hora_aterragem);
        $movimento->preco_voo=$this->calculaPrecoViagem();

        $parceiro=Auth::user();
        if($request->is_piloto){
            $movimento=$this->atribuirPiloto($parceiro,$movimento);
        } else{
            $movimento=$this->atribuirInstrutor($parceiro,$movimento);
        }       

        if (!$parceiro->isAdmin()){
            $movimento->confirmado=0; 
        }
        

        if($request->natureza=='I'){

            $parceiro = User::where('nome_informal',$request->nome_informal)->first();

            if($request->is_piloto){
                $movimento=$this->atribuirInstrutor($parceiro,$movimento);

            }else{
                $movimento=$this->atribuirPiloto($parceiro,$movimento);
            }

        }else{
            $movimento->tipo_instrucao=null;
            $movimento->instrutor_id=null;
            $movimento->num_licenca_instrutor=null;
            $movimento->validade_licenca_instrutor=null;
            $movimento->tipo_licenca_instrutor=null;
            $movimento->num_certificado_instrutor=null;
            $movimento->validade_certificado_instrutor=null;
            $movimento->classe_certificado_instrutor=null;         
        }

        $movimento->save();
        return redirect()->route('movimentos')->with("success","Movimento editado com sucesso.");
    }

    public function destroy(Movimento $movimento){
        $this->authorize('delete',$movimento);
        $this->diminuirContaHoras($movimento);
        $movimento->delete();
        return redirect()->route('movimentos')->with("success","Movimento apagado com sucesso.");
    }

    private function diminuirContaHoras(Movimento $movimento){
        // DIMINUIR CONTA HORAS DAS AERONAVES
    }
}
