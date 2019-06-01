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

            $meus_movimentos =  request()->meus_movimentos;

            if (  $meus_movimentos == 1){
                $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){
                    $query->where( 'id', Auth::user()->id );
                })->orWhereHas( 'pilotos', function ( $query ){
                    $query->where( 'id', Auth::user()->id );
                });
            }
        }


        // PROCURA NA DB OS PILOTOS QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
        $piloto_filtro = request()->piloto;

        if ( $piloto_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'pilotos', function ( $query ){

                $nome =  request()->piloto;
                if ( $nome != null ) $query->where( 'id', $nome);
                

        } );
        }


        // PROCURA NA DB OS INSTRUTORES QUE TÊM O NOME INFORMAL IGUAL AO INSERIDO NO FILTRO E QUE PARTICIPARAM EM MOVIMENTOS
        $instrutor_filtro = request()->instrutor;

        if (  $instrutor_filtro != null ){

            $movimentos =  $movimentos->whereHas( 'instrutores',function ( $query ){

                $nome =  request()->instrutor;
                if ( $nome != null ) $query->where( 'id', $nome );

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
        
        $this->authorize('store', Movimento::class);
        $movimento = new Movimento();
        $movimento->fill($request->all());
        
        if(Auth::user()->id != $request->piloto_id && !Auth::user()->isAdmin()) return redirect()->route('movimentos')->with("errors","Movimento deu merda memo.");

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
        $movimento=$this->atribuirPiloto($piloto,$movimento);
        
        if($request->natureza=='I' || $movimento->instrutor_id != null){

            $instrutor = User::where('id',$request->instrutor_id)->first();
            $movimento=$this->atribuirInstrutor($instrutor,$movimento);
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

    private function calculaPrecoViagem(Movimento $movimento){ 
        $diff = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $valor = round($diff/5) * 5;
        $incremento = 1;
        $preco_aux = 0;
        if ($valor == 0){
            $valor = 5;
        }
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
        $movimentos = new Movimento();
        $aerodromos = Aerodromo::all();
        $aeronaves = Aeronave::all();

        return view('movimentos.editMovimentos',compact('movimento','aeronaves','aerodromos'));
               
    }    

    public function update(UpdateMovimentoRequest $request, Movimento $movimento){
        
        $this->authorize('update', $movimento);

        $movimento->fill($request->all());
        //esta verificação precisa de ser feita aqui porque o id para conparar tem de ser o mais recente
        if(Auth::user()->id != $request->piloto_id && !Auth::user()->isAdmin()) return redirect()->route('movimentos')->with("errors","Movimento deu merda memo.");

        $data=date("Y-m-d ",strtotime($request->data));
        $hora_descolagem=date("H:i:s",strtotime($request->hora_descolagem));
        $hora_aterragem=date("H:i:s",strtotime($request->hora_aterragem));
        
        $movimento->hora_descolagem = $data.$hora_descolagem;
        $movimento->hora_aterragem = $data.$hora_aterragem;

        $aeronave = Aeronave::where('matricula',$request->aeronave)->first();
        $movimento->aeronave_movimentos()->associate($aeronave);

        
        $piloto=User::where('id',$request->piloto_id)->first();
        $movimento=$this->atribuirPiloto($piloto,$movimento);
        
        if($request->natureza=='I' || $movimento->instrutor_id != null){
            $instrutor = User::where('id',$request->instrutor_id)->first();
            $movimento=$this->atribuirInstrutor($instrutor,$movimento);
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
        return redirect()->route('movimentos')->with("success","Movimento editado com sucesso.");
    }

    public function destroy(Movimento $movimento){
        $this->authorize('delete',$movimento);
        //$this->diminuirContaHoras($movimento);
        $movimento->delete();
        return redirect()->route('movimentos')->with("success","Movimento apagado com sucesso.");
    }

    private function diminuirContaHoras(Movimento $movimento){
        $diff = $movimento->conta_horas_fim - $movimento->conta_horas_inicio;
        $aeronave = Aeronave::where("matricula",$movimento->aeronave)->first();
        $aeronave->conta_horas = $aeronave->conta_horas - $diff;
        $aeronave->save();
    }

    public function confirmar_todos(){

        $array = $_POST;

        if(Auth::user()->isAdmin()){

            foreach ($array as $id => $value){

                if ($value){

                    $movimento = Movimento::where('id',$id)->first();

                    if (!$movimento->isConfirmado()){
                        
                    $movimento->confirmado="1";
                    $movimento->save();

                    }

                }else{
                    break;
                }


            }
        }

        return redirect()->route('movimentos');

    }


}
