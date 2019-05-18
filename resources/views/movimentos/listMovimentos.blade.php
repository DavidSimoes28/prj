@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
@include("partials.errors")


<form method="GET" action="{{ route('movimentos') }}">
    <table class="table table-bordered texter-center">

        <tr>
            <th><label for ="id">{{ __('ID do movimento') }}</label></td>
            <th><label for ="piloto_id">{{ __('Piloto') }}</label></td>
            <th><label for ="instrutor_id">{{ __('Instrutor') }}</label></td>
            <th rowspan="2"><input type="text"  name="aeronave" placeholder="Aeronave" maxlength = "8" value="{{ strval($_GET ['aeronave'] ?? '') }}"></th>
            <th><label for="data_inicio" class="col-form-label text-md-right">{{ __('Data de Início') }}</label></th>
            <th><label for="data_fim" class="col-form-label text-md-right">{{ __('Data do Fim') }}</label></th>
            <th rowspan="2"><input type="text" name="email" placeholder="natureza" value="{{ strval($_GET ['email'] ?? '') }}"></th>
            <th><label for="confirmado">Confirmado&nbsp;</label></th>
            
            <th rowspan="2">
            <input type="submit" class="btn btn-xs btn-primary" value = "Pesquisar">
            &nbsp;&nbsp;
            <a class="btn btn-xs btn-danger" href=" {{ route('socios') }} "><i class="fa fa-trash"></i></a>
            </th>

        </tr>
        <tr>
            <td><input type="number" name="id" autofocus min="0"  value="{{ strval($_GET ['id'] ?? '') }}"></td>
            <td><input type="number" name="piloto_id" min = "0"  value="{{ strval($_GET ['piloto_id'] ?? '') }}"></td>
            <td><input type="number" name="instrutor_id" min = "0"  value="{{ strval($_GET ['instrutor_id'] ?? '') }}"></td>
            <td><input type="date" name="data_inicio" class = "form-control-inline" required></td>
            <td><input type="date" name="data_fim" class = "form-control-inline" required></td>
            <td><select name="confirmado">
            <option value="AMBOS"   {{ strval($_GET ['direcao'] ?? '') == "AMBOS"  ? "selected":"" }} >Ambos</option>
            <option value="1"       {{ strval($_GET ['direcao'] ?? '') == "1"      ? "selected":"" }} >Sim</option>
            <option value="0"       {{ strval($_GET ['direcao'] ?? '') == "0"      ? "selected":"" }} >Não</option>    
            </select></td>

        </tr>

    </table>

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
            <th>Matricula</th>
            <th>Data</th>
            <th>Hora Deslocamento</th>
            <th>Hora Aterragem</th>
            <th>Tempo Voo</th>
            <th>Natureza</th>
            <th>Piloto</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Nº Aterragens</th>
            <th>Nº Deslocamentos</th>
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
    <h2>No users found</h2>
@endif

@endsection
