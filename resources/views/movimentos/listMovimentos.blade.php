@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
@include("partials.errors")


<form method="GET" action="{{ route('movimentos') }}" class="form-inline">

    <div class="col-xs-2">
        <label for ="id"><strong>{{ __('ID do movimento') }}</strong></label>
        <input type="number" class="form-control" name="id" autofocus min="0" value="{{ strval(old('id',request()->id )) }}" autofocus>
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="nome_informal_piloto"><strong>{{ __('Piloto') }}</strong></label>
        <input type="text" class="form-control" name="nome_informal_piloto" value="{{ strval(old('nome_informal_piloto',request()->nome_informal_piloto )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="nome_informal_instrutor"><strong>{{ __('Instrutor') }}</strong></label>
        <input type="text" class="form-control" name="nome_informal_instrutor" value="{{ strval(old('nome_informal_instrutor',request()->nome_informal_instrutor )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="aeronave"><strong>{{ __('Aeronave') }}</strong></label>
        <input type="text" class="form-control" name="aeronave" value="{{ strval(old('aeronave',request()->aeronave )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;

    <div class="col-xs-2">
        <label for ="data_inicio"><strong>{{ __('Data Inicial') }}</strong></label>
        <input type="date" class="form-control" name="data_inicio" value="{{ strval(old('data_inicio',request()->data_inicio )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="data_fim"><strong>{{ __('Data Final') }}</strong></label>
        <input type="date" class="form-control" name="data_fim" value="{{ strval(old('data_fim',request()->data_fim )) }}">
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
    <div class="col-xs-2">
        <label for ="confirmado"><strong>{{ __('Confirmado') }}</strong></label>
        <select name="confirmado" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="AMBOS"   {{ strval(old('confirmado' ,request()->confirmado)) == "AMBOS"  ? "selected":"" }} >--</option>
        <option value="1"       {{ strval(old('confirmado' ,request()->confirmado)) == "1"      ? "selected":"" }} >Sim</option>
        <option value="0"       {{ strval(old('confirmado' ,request()->confirmado)) == "0"      ? "selected":"" }} >Não</option>    
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
        <label>&nbsp;</label>
        <div class="btn-group">
            <input type="submit" class="btn btn-xs btn-primary" value = "Pesquisar" data-toggle="tooltip" title="Pesquisar">
            <a class="btn btn-xs btn-danger" href=" {{ route('movimentos') }} " data-toggle="tooltip" title="Limpar pesquisa"><i class="fa fa-trash"></i></a>
        </div>
    </div>

   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  
</form>

<br>
<br>
</div>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Lista de Movimentos&nbsp;&nbsp;&nbsp;&nbsp;
                    <div class="btn-group dropright">
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    data-toggle="tooltip">
                        {{ __('Opções direção') }}
                    </button>
                    
                    <div class="dropdown-menu">
                    <a class="btn btn-xs btn-primary" href="{{ route('movimentos.create') }}" data-toggle="tooltip" title="Adicionar Movimento">{{ __('Adicionar Movimento') }}</a>
                        <div class="dropdown-divider"></div>
                           
                    </div>
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
                            <th style="width: 10%">ID</th>
                            <th style="width: 10%">Aeronave</th>
                            <th style="width: 15%">Data de voo</th>
                            <th style="width: 10%">Natureza</th>
                            <th style="width: 20%">Piloto</th>
                            <th style="width: 15%">Aerodromo Partida</th>
                            <th style="width: 15%">Aerodromo Chegada</th>
                            <th style="width: 5%">Nº Serviço</th>
                            <th style="width: 15%">Confirmação</th>
                            <th style="width: 10%">Ações</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($movimentos as $movimento)
                                <tr>
                                    <td>{{ $movimento->id }}</td>
                                    <td>{{ $movimento->aeronave }}</td>
                                    <td>{{ $movimento->data }}</td>
                                    <td>{{ $movimento->naturezaToStr() }}</td>
                                    <td>{{ $movimento->pilotos->nome_informal }}</td>
                                    <td>{{ $movimento->aerodromo_partida }}</td>
                                    <td>{{ $movimento->aerodromo_chegada }}</td>
                                    <td>{{ $movimento->num_servico }}</td>
                                    <td>{{ $movimento->instrucaoConfirmadaToStr() }}</td>

                                    <td>
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            data-toggle="tooltip" title="Ações">
                                                {{ __('Ações') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-primary btn-block" href="">Editar</a>
                                                <a href="#detalhes-{{ $movimento->id }}" class="btn btn-secondary" data-toggle="modal" data-target="#detalhes-{{ $movimento->id }}">{{ __('Mais Informações') }}</a>
                                                
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
                                                                                            <td><span class="input-group-text">Aeronave: {{ $movimento->aeronave }}</span></td>
                                                                                            <td><span class="input-group-text">Natureza: {{ $movimento->naturezaToStr() }}</span></td>
                                                                                            <td><span class="input-group-text">Duração de {{ $movimento->horasDeVoo() }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Data do voo: {{ $movimento->data }}</span></td>
                                                                                            <td><span class="input-group-text">Hora de partida: {{ $movimento->horaDePartida() }}</span></td>
                                                                                            <td><span class="input-group-text">Hora de aterragem: {{ $movimento->horaDeChegada() }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Piloto: {{ $movimento->pilotos->nome_informal }}</span></td>
                                                                                            <td><span class="input-group-text">Partida: {{ $movimento->aerodromo_partida }}</span></td>
                                                                                            <td><span class="input-group-text">Chegada: {{ $movimento->aerodromo_chegada }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Nº Aterragens: {{ $movimento->num_aterragens }}</span></td>
                                                                                            <td><span class="input-group-text">Nº Descolagens: {{ $movimento->num_descolagens }}</span></td>
                                                                                            <td><span class="input-group-text">Nº Diário: {{ $movimento->num_diario }}</span></td>
                                                                                        </tr>

                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Nº Serviço: {{ $movimento->num_servico }}</span></td>
                                                                                            <td><span class="input-group-text">Conta Horas-inicial: {{ $movimento->conta_horas_inicio }}</span></td>
                                                                                            <td><span class="input-group-text">Conta Horas-final: {{ $movimento->conta_horas_fim }}</span></td>
                                                                                        </tr>

                                                                                        @if ( $movimento->natureza == 'I' )
                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Tipo Instrução: {{ $movimento->tipoInstrucaoToStr() }}</span></td>
                                                                                            <td><span class="input-group-text">Instrutor: {{ $movimento->instrutores->nome_informal ?? ""}}</span></td>
                                                                                            <td><span class="input-group-text">Instrução {{ $movimento->instrucaoConfirmadaToStr() }}</span></td> 
                                                                                        </tr>
                                                                                        @endif

                                                                                        <tr>
                                                                                            <td><span class="input-group-text">Nº Pessoas: {{ $movimento->num_pessoas }}</span></td>
                                                                                        </tr>

                                                                                    </div>

                                                                                </table>

                                                                            </div>
                                                                            
                                                                            <div><h5><label for ="observacoes">{{ __('Observações') }}</label></h5></div>
                                                                            <h6>
                                                                            <textarea style="width: 100%; resize: none" class="md-textarea form-control" readonly>{{ $movimento->observacoes }}</textarea>
                                                                            </h6>                                
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
