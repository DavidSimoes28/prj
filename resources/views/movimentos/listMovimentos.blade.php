@extends('layouts.app')

@section('content')


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
            <th>Hora Delocamento</th>
            <th>Hora Aterragem</th>
            <th>Tempo Voo</th>
            <th>Natureza</th>
            <th>Piloto</th>
            <th>Aerodromo Partida</th>
            <th>Aerodromo Chegada</th>
            <th>Nº Aterragens</th>
            <th>Nº Deslocamentos</th>
            <th>Nº Diario</th>
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
