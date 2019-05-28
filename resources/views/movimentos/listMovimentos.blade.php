@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
@include("partials.errors")


<form method="GET" action="{{ route('movimentos') }}" >
    <div class="form-inline">
    <div class="col-xs-2">
        <label for ="id"><strong>{{ __('ID do movimento') }}</strong></label>
        <input type="number" class="form-control" name="id" autofocus min="0" value="{{ strval(old('id',request()->id )) }}" autofocus>
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="aeronave"><strong>{{ __('Aeronave') }}</strong></label>
        <input type="text" class="form-control" name="aeronave" value="{{ strval(old('aeronave',request()->aeronave )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="piloto"><strong>{{ __('Piloto') }}</strong></label>
        <input type="text" class="form-control" name="piloto" value="{{ strval(old('piloto',request()->piloto )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="instrutor"><strong>{{ __('Instrutor') }}</strong></label>
        <input type="text" class="form-control" name="instrutor" value="{{ strval(old('instrutor',request()->instrutor )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    </div>
    <br>
    <div class="form-inline">

    <div class="col-xs-2">
        <label for ="data_inf"><strong>{{ __('Data Inicial') }}</strong></label>
        <input type="date" class="form-control" name="data_inf" value="{{ strval(old('data_inf',request()->data_inf )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="data_fim"><strong>{{ __('Data Final') }}</strong></label>
        <input type="date" class="form-control" name="data_sup" value="{{ strval(old('data_sup',request()->data_sup )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;

    <div class="col-xs-2">
        <label for ="natureza"><strong>{{ __('Natureza') }}</strong></label>
        <select class="btn btn-xs btn-secondary dropdown-toggle" name="natureza" value="{{ strval(old('natureza',request()->natureza )) }}" >
        <option value="TODOS"   {{ strval(old('natureza' ,request()->natureza)) == "TODOS"  ? "selected":"" }} >--</option>
        <option value="T"       {{ strval(old('natureza' ,request()->natureza)) == "T"      ? "selected":"" }} >Treino</option>
        <option value="I"       {{ strval(old('natureza' ,request()->natureza)) == "I"      ? "selected":"" }} >Instrução</option>
        <option value="E"       {{ strval(old('natureza' ,request()->natureza)) == "E"      ? "selected":"" }} >Especial</option>
        </select>
    </div>
    &nbsp;&nbsp;&nbsp;

    @if (Auth::user()->tipo_socio == 'P')
    <div class="col-xs-2">
        <label for ="voos_pessoais"><strong>{{ __('Voos pessoais') }}</strong></label>
        <select name= "voos_pessoais" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value=""        {{ strval(old('voos_pessoais' ,request()->voos_pessoais)) == ""       ? "selected":"" }} >--</option>
        <option value="I"       {{ strval(old('voos_pessoais' ,request()->voos_pessoais)) == "I"      ? "selected":"" }} >Instrutor</option>
        <option value="P"       {{ strval(old('voos_pessoais' ,request()->voos_pessoais)) == "P"      ? "selected":"" }} >Piloto</option>  
        <option value="TODOS"   {{ strval(old('voos_pessoais' ,request()->voos_pessoais)) == "TODOS"  ? "selected":"" }} >Todos</option>
        </select>
    </div>

    &nbsp;&nbsp;&nbsp;
    @endif

    <div class="col-xs-2">
        <label for ="confirmado"><strong>{{ __('Confirmado') }}</strong></label>
        <select name="confirmado" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="AMBOS"   {{ strval(old('confirmado' ,request()->confirmado)) == "AMBOS"  ? "selected":"" }} >--</option>
        <option value="1"       {{ strval(old('confirmado' ,request()->confirmado)) == "1"      ? "selected":"" }} >Sim</option>
        <option value="0"       {{ strval(old('confirmado' ,request()->confirmado)) == "0"      ? "selected":"" }} >Não</option>    
        </select>
    </div>

    &nbsp;&nbsp;&nbsp;

    <div class="col-xs-2">
        <label>&nbsp;</label>
        <div class="btn-group">
            <button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip"  title="Pesquisar">Pesquisa&nbsp;<i class="fas fa-search"></i></button>
            <a class="btn btn-xs btn-danger" href=" {{ route('movimentos') }} " data-toggle="tooltip" title="Limpar pesquisa"><i class="fa fa-trash"></i></a>
        </div>
    </div>

    
  </div>
</form>

<br>
<br>
<br>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <br>
            <br>
            <br>
            <div class="card">
                <div class="card-header"><h4>Lista de Movimentos&nbsp;&nbsp;&nbsp;&nbsp;
                    @if ( Auth::user()->isPiloto() )
                        <div class="btn-group dropright">
                        <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        data-toggle="tooltip">
                        <i class="fas fa-cog"></i>  {{ __(' Opções') }}
                        </button>
                        
                        <div class="dropdown-menu">
                        <a class="btn btn-xs btn-primary" href="{{ route('movimentos.create') }}" data-toggle="tooltip" title="Adicionar Movimento">{{ __('Adicionar Movimento ') }}<i class="fas fa-plus"></i></a>   
                            @if(Auth::user()->isAdmin())
                                <div class="dropdown-divider"></div>
                                <a href="#list_confirmacao" class="btn btn-success btn-block" data-toggle="modal" data-target="#list_confirmacao" >{{ __('Confirmar ') }}<i class="far fa-check-circle"></i></a>
                            @endif
                        </div>               
                    @endif
                    </h4>
                    
                </div>
                
                </h3><div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                @if(count($movimentos))
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 7%">ID</th>
                            <th class="text-center" style="width: 7%">Aeronave</th>
                            <th class="text-center" style="width: 11%">Data de voo</th>
                            <th class="text-center" style="width: 8%">Natureza</th>
                            <th class="text-center">Piloto</th>
                            <th class="text-center" style="width: 10%">Partida</th>
                            <th class="text-center" style="width: 10%">Chegada</th>
                            <th class="text-center" style="width: 9%">Nº Serviço</th>
                            <th class="text-center" style="width: 14%">Confirmação</th>
                            <th class="text-center" style="width: 9%">Ações</th>
                            </tr>
                        </thead>
                    
                        <tbody>
                            @foreach ($movimentos as $movimento)
                                <tr>
                                    <td class="text-center">{{ $movimento->id }}</td>
                                    <td class="text-center">{{ $movimento->aeronave }}</td>
                                    <td class="text-center">{{ $movimento->data }}</td>
                                    <td class="text-center">{{ $movimento->naturezaToStr() }}</td>
                                    <td class="text-center">{{ $movimento->pilotos->nome_informal }}</td>
                                    <td class="text-center">{{ $movimento->aerodromo_partida }}</td>
                                    <td class="text-center">{{ $movimento->aerodromo_chegada }}</td>
                                    <td class="text-center">{{ $movimento->num_servico }}</td>
                                    <td class="text-center">
                                        {{ $movimento->instrucaoConfirmadaToStr() }}
                                        @if(Auth::user()->isAdmin() && $movimento->confirmado=='0')
                                            <input type="checkbox" style="width: 18px; height: 18px; vertical-align:middle;" name="movimento_check_{{$movimento->id}}" value="1" >
                                        @endif 
                                    </td>

                                    <td class="text-center">
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            data-toggle="tooltip" title="Ações">
                                                {{ __('Ações') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a href="#detalhes-{{ $movimento->id }}" class="btn btn-secondary btn-block" data-toggle="modal" data-target="#detalhes-{{ $movimento->id }}">{{ __('Mais Informações ') }}<i class="far fa-file-alt"></i></a> 
                                                @if(!$movimento->isConfirmado()) 
                                                    @if(Auth::user()->isAdmin() || $movimento->pertencePiloto(Auth::user())) 
                                                    <div class="dropdown-divider"></div>
                                                        <a class="btn btn-xs btn-primary btn-block" href="{{ route('movimentos.edit', ['id'=> $movimento->id] ) }}">{{ __('Editar ') }}<i class="far fa-edit"></i></a>
                                                        @if(Auth::user()->isAdmin())
                                                            <div class="dropdown-divider"></div>
                                                            <form action="{{route('movimentos.destroy',['id'=>$movimento->id])}}" method="post">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="hidden" name="id" value="{{$movimento->id}}">
                                                                <button type="submit" class="btn btn-danger btn-block" href="{{ route('movimentos.destroy', ['id'=> $movimento->id] ) }}">Remover&nbsp;<i class="far fa-trash-alt"></i></button>
                                                            </form>
                                                        @endif
                                                    @endif
                                                @endif
                                            </div>

                                            <!--
                                             -->
                                             <div class="modal" id="detalhes-{{ $movimento->id }}">
                                                    <div class="modal-dialog modal-lg">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="list-group">
                                                                    <div class="d-flex w-100 justify-content-between">

                                                                        <div class="container">
                                                                            <h4>Detalhes do Movimento - {{ $movimento->id }}</h4>
                                                                            <div class="row justify-content-center">
                                                                                <table class="table table-striped">
                                                                                    <div class="card-body">
                                                                                    
                                                                                        <tr>
                                                                                            <td><span class="input-group-text"><strong>Aeronave:&nbsp;</strong> {{ $movimento->aeronave }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Natureza:&nbsp;</strong> {{ $movimento->naturezaToStr() }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Duração de {{ $movimento->horasDeVoo() }}</strong></span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text"><strong>Data do voo:&nbsp;</strong> {{ $movimento->data }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Hora de partida:&nbsp;</strong> {{ $movimento->horaDePartida() }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Hora de aterragem:&nbsp;</strong> {{ $movimento->horaDeChegada() }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td  colspan="2"><span class="input-group-text"><strong>Piloto:&nbsp;</strong> {{ $movimento->pilotos->nome_informal }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Nº Pessoas:&nbsp;</strong> {{ $movimento->num_pessoas }}</span></td>
                                                                                            
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text"><strong>Nº Aterragens:&nbsp;</strong> {{ $movimento->num_aterragens }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Nº Descolagens:&nbsp;</strong> {{ $movimento->num_descolagens }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Nº Diário:&nbsp;</strong> {{ $movimento->num_diario }}</span></td>
                                                                                            
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text"><strong>Nº Serviço:&nbsp;</strong> {{ $movimento->num_servico }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Conta Horas-inicial:&nbsp;</strong> {{ $movimento->conta_horas_inicio }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Conta Horas-final:&nbsp;</strong> {{ $movimento->conta_horas_fim }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text"><strong>Partida:&nbsp;</strong> {{ $movimento->aerodromo_partida }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Chegada:&nbsp;</strong> {{ $movimento->aerodromo_chegada }}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Movimento {{ $movimento->instrucaoConfirmadaToStr() }}</strong></span></td> 
                                                                                        </tr>

                                                                                        @if ( $movimento->natureza == 'I' )
                                                                                        <tr>
                                                                                            <td colspan="2"><span class="input-group-text"><strong>Instrutor:&nbsp;</strong>{{ $movimento->instrutores->nome_informal ?? ""}}</span></td>
                                                                                            <td><span class="input-group-text"><strong>Tipo Instrução:&nbsp;</strong>{{ $movimento->tipoInstrucaoToStr() }}</span></td>
                                                                                            
                                                                                        </tr>
                                                                                        @endif
                                                                                    </div>

                                                                                </table>

                                                                            </div>
                                                                            @if ( isset($movimento->observacoes) )
                                                                            <div><h5><label for ="observacoes"><strong>{{ __('Observações') }}</strong></label></h5></div>
                                                                            <h6>
                                                                            <textarea style="width: 100%; resize: none" class="md-textarea form-control" readonly>{{ $movimento->observacoes }}</textarea>
                                                                            </h6>                               
                                                                            @endif 
                                                                        </div>
                                                                    </div>
                                                                </div>                            
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class = "btn-group">
                                                                    <a class="btn btn-xs btn-primary" href="{{ route('movimentos.edit', ['id'=> $movimento->id] ) }}">{{ __('Editar movimento') }}</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                <!--
                                                -->

                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                            @if(Auth::user()->isAdmin())
                                <div class="modal" id="list_confirmacao" tabindex="-1" role="dialog" aria-labelledby="list_confirmacaoLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h4 class="modal-title" id="list_confirmacaoLabel">Confirmação Movimento(s)</h4>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <p class="alert alert-danger">Se confirmar o(s) movimento(s) não poderá ser mais alterado.</p>
                                                Pretende confirmar o(s) movimento(s) selecionado(s)? <br>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                <form action="" method="post">
                                                    @csrf
                                                    <input type="submit" class="btn btn-xs btn-success" value="Guardar">
                                                </form>

                                                

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </tbody>
                        </table>
                        {{ $movimentos->links() }}
                    @else
                        <h2>Nenhum movimento encontrado.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
