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
        <label for ="piloto_id"><strong>{{ __('Piloto') }}</strong></label>
        <input type="text" class="form-control" name="piloto_id" value="{{ strval(old('piloto_id',request()->piloto_id )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="instrutor_id"><strong>{{ __('Instrutor') }}</strong></label>
        <input type="text" class="form-control" name="instrutor_id" value="{{ strval(old('instrutor_id',request()->instrutor_id )) }}">
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
        <option value="TODOS"   {{ strval(old('natureza' ,request()->natureza)) == "TODOS"  ? "selected":"" }} >Todos</option>
        <option value="T"       {{ strval(old('natureza' ,request()->natureza)) == "T"      ? "selected":"" }} >Treino</option>
        <option value="I"       {{ strval(old('natureza' ,request()->natureza)) == "I"      ? "selected":"" }} >Instrução</option>
        <option value="E"       {{ strval(old('natureza' ,request()->natureza)) == "E"      ? "selected":"" }} >Especial</option>
        </select>

    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="confirmado"><strong>{{ __('Confirmado') }}</strong></label>
        <select name="confirmado" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="AMBOS"   {{ strval(old('confirmado' ,request()->confirmado)) == "AMBOS"  ? "selected":"" }} >Ambos</option>
        <option value="1"       {{ strval(old('confirmado' ,request()->confirmado)) == "1"      ? "selected":"" }} >Sim</option>
        <option value="0"       {{ strval(old('confirmado' ,request()->confirmado)) == "0"      ? "selected":"" }} >Não</option>    
    </select>

    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label>&nbsp;</label>
        <div class="btn-group">
            <input type="submit" class="btn btn-xs btn-primary" value = "Pesquisar">
            <a class="btn btn-xs btn-danger" href=" {{ route('movimentos') }} "><i class="fa fa-trash"></i></a>
        </div>
    </div>
    </div>

   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  
</form>

<br>
<br>
</div>
<a class="btn btn-xs btn-primary" href="{{ route('movimentos.create') }}">{{ __('Adicionar Movimento') }}</a>




@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

@if(count($movimentos))
    <table class="table table-striped">
    <thead>
        <tr>
            
            <th>ID</th>
            <th>Matrícula</th>
            <th>Data</th>
            <th>Hora Deslocamento</th>
            <th>Hora Aterragem</th>
            <th>Tempo Voo</th>
            <th>Natureza</th>
            <th>Piloto</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Aterragens</th>
            <th>Deslocamentos</th>
            <th>Nº Diário</th>
            <th>Nº Serviço</th>
            <th>Conta-horas Inicial</th>
            <th>Conta-horas Final</th>
            <th>Nº Pessoas</th>
            <th>Tipo Instrução</th>
            <th>Instrutor</th>
            <th>Confirmado</th>
            <!--<th>Observações</th>-->
        </tr>
    </thead>
    <tbody>
        @foreach ($movimentos as $movimento)
            <tr>
                <td>{{ $movimento->id }}</td>
                <td>{{ $movimento->aeronave }}</td>
                <td>{{ $movimento->data }}</td>
                <td>{{ $movimento->hora_descolagem }}</td>
                <td>{{ $movimento->hora_aterragem }}</td>
                <td>{{ $movimento->tempo_voo }}</td>
                <td>{{ $movimento->naturezaToStr() }}</td>
                <td>{{ $movimento->pilotos->nome_informal }}</td>
                <td>{{ $movimento->aerodromo_partida }}</td>
                <td>{{ $movimento->aerodromo_chegada }}</td>
                <td>{{ $movimento->num_aterragens }}</td>
                <td>{{ $movimento->num_descolagens }}</td>
                <td>{{ $movimento->num_diario }}</td>
                <td>{{ $movimento->num_servico }}</td>
                <td>{{ $movimento->conta_horas_inicio }}</td>
                <td>{{ $movimento->conta_horas_fim }}</td>
                <td>{{ $movimento->num_pessoas }}</td>
                <td>{{ $movimento->tipoInstrucaoToStr() }}</td>
                <td>{{ $movimento->instrutores->nome_informal ?? ""}}</td>
                <td>{{ $movimento->instrucaoConfirmadaToStr() }}</td>
                <!--<td>{{ $movimento->observacoes }}</td>-->
            </tr>
        @endforeach
    </table>
    {{ $movimentos->links() }}
@else
    <h2>Nenhum movimento encontrado.</h2>
@endif

@endsection
