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
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

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
        $piloto_filtro = request()->piloto;

        if ( $piloto_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'pilotos', function ( $query ){

                $nome =  request()->piloto;
                if ( $nome != null ) $query->where( 'nome_informal', 'like' , '%' .$nome. '%');
                

        } );
        }


        // PROCURA NA DB OS INSTRUTORES QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
        $instrutor_filtro = request()->instrutor;

        if (  $instrutor_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){

                $nome =  request()->instrutor;
                if ( $nome != null ) $query->where( 'nome_informal', 'like' , '%' .$nome. '%' );

        } );
        }


        //PROCURA POR ID, AERONAVE, DATAS DE VOO, NATUREZA E CONFIRMADO DOS MOVIMENTOS

        $movimentos = $movimentos->where(function ($query) {

            $id =  request()->id;
            $aeronave =  request()->aeronave;
            $data_inf =  request()->data_inf;
            $data_sup =  request()->data_sup;
            $natureza = request()->natureza;
            $confirmado =  request()->confirmado;

            if ( $id != null ) $query->where(  'id', 'like' , '%' .$id. '%'  );

            if ( $aeronave != null ) $query->where('aeronave', 'like' , '%' .$aeronave. '%' );

            if ( $data_inf != null) $query->where('data', ">=" , $data_inf);
            
            if ($data_sup != null ) $query->where('data', "<=" , $data_sup);

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
        $aerodromos = Aerodromo::all();
        $aeronaves = Aeronave::all();
        return view('movimentos.addMovimentos',compact('movimentos','aeronaves','aerodromos'));
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

        /*conta-horas
        $start  = new Carbon($movimento->hora_descolagem);
        $end    = new Carbon($movimento->hora_aterragem);

        $diff_hora = $start->diffInHours($end);
        $start->addHours($diff_hora);
        $diff_minutos = $start->diffInMinutes($end);
        $conta = intval($diff_hora) * 10 + (intval($diff_minutos)*10/60);
        */

        $aeronave = Aeronave::where('matricula',$request->aeronave)->first();
        $movimento->aeronave_movimentos()->associate($aeronave);

        
        $piloto=User::where('id',$request->piloto_id)->first();
        //$movimento=$this->atribuirPiloto($piloto,$movimento);
        $movimento->num_licenca_piloto=$piloto->num_licenca;
        $movimento->validade_licenca_piloto=$piloto->validade_licenca;
        $movimento->tipo_licenca_piloto=$piloto->tipo_licenca;
        $movimento->num_certificado_piloto=$piloto->num_certificado;
        $movimento->validade_certificado_piloto=$piloto->validade_certificado;
        $movimento->classe_certificado_piloto=$piloto->classe_certificado;
        
        if($request->natureza=='I'){

            $instrutor = User::where('id',$request->instrutor_id)->first();
            //$movimento=$this->atribuirInstrutor($instrutor,$movimento);
            $movimento->num_licenca_instrutor=$instrutor->num_licenca;
            $movimento->validade_licenca_instrutor=$instrutor->validade_licenca;
            $movimento->tipo_licenca_instrutor=$instrutor->tipo_licenca;
            $movimento->num_certificado_instrutor=$instrutor->num_certificado;
            $movimento->validade_certificado_instrutor=$instrutor->validade_certificado;
            $movimento->classe_certificado_instrutor=$instrutor->classe_certificado;
        }else{
            $movimento->instrutor_id=null;
            $movimento->num_licenca_instrutor=null;
            $movimento->validade_licenca_instrutor=null;
            $movimento->tipo_licenca_instrutor=null;
            $movimento->num_certificado_instrutor=null;
            $movimento->validade_certificado_instrutor=null;
            $movimento->classe_certificado_instrutor=null;
        }
        $movimento->confirmado=0; 
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
    private function calculaPrecoViagem(Movimento $movimento){ 
        $diff = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $valor = round($diff/5) * 5;
        $incremento = 1;
        $preco_aux = 0;

        while($valor>60){
            $incremento++;
            $valor = $valor-60;
        }
        $precos = DB::table('aeronaves_valores')->where("matricula",$movimento->aeronave)->where("minutos",$valor);
        if($incremento!=1){
            $aux = DB::table('aeronaves_valores')->where("matricula",$movimento->aeronave)->where("minutos",60);
            $preco_aux = $aux->pluck('preco')[0] * $incremento;
        }
        return $preco_aux + $precos->pluck('preco')[0];
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
        
        /*conta-horas
        $start  = new Carbon($movimento->hora_descolagem);
        $end    = new Carbon($movimento->hora_aterragem);

        $diff_hora = $start->diffInHours($end);
        $start->addHours($diff_hora);
        $diff_minutos = $start->diffInMinutes($end);
        $conta = intval($diff_hora) * 10 + (intval($diff_minutos)*10/60);
        
        $movimento->conta_horas_fim = $movimento->conta_horas_inicio + $conta;
        */
        $aeronave = Aeronave::where('matricula',$request->aeronave)->first();
        $movimento->aeronave_movimentos()->associate($aeronave);

        //$aeronave->conta_horas = $aeronave->conta_horas + $conta;
        //dd($movimento->hora_descolagem,$movimento->hora_aterragem,$conta,$movimento->conta_horas_inicio,$movimento->conta_horas_fim,$aeronave->conta_horas);

        $movimento->tempo_voo=$this->calculaTempoViagem($request->hora_descolagem,$request->hora_aterragem);
        $movimento->preco_voo=$this->calculaPrecoViagem($movimento);
        dd($movimento->tempo_voo,$movimento->preco_voo);
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
        // ->tem de ser alguma coisa assim . guardar os dois ultimos movimentos feitos pela aernove . $dois_movimentos = Movimento::where("matricula",$movimento->matricula)->orderBy('conta_horas_final', 'desc')->take(2)->get();
        // $aeronave = Aeronave::where("matricula",$movimento->matricula);
        // $aeronave->contahoras = segundo contahoras final do $dois_movimentos
        $diff = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $aeronave = Aeronave::where("matricula",$movimento->matricula);
        $aeronave->conta_horas = $aeronave->conta_horas - $diff;
        $aeronave->save();
    }
}
