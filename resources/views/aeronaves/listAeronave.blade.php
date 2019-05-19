@extends('layouts.app')

@section('content')

<div class="container">
<a class="btn btn-xs btn-primary" href="{{ route('socios.create') }}">{{ __('Adicionar Sócio') }}</a>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include("partials.errors")
            <div class="card">
                <div class="card-header">Lista de Aeronaves</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($aeronaves))
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                
                                <th>Matricula</th>
                                <th>Marca</th>
                                <th>Modelo</th>
                                <th>Nº de Lugares</th>
                                <th>Total de Horas</th>
                                <th>Preço Hora</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aeronaves as $aeronave)
                                <tr>
                                    <td>{{ $aeronave->matricula }}</td>
                                    <td>{{ $aeronave->marca }}</td>
                                    <td>{{ $aeronave->modelo }}</td>
                                    <td>{{ $aeronave->num_lugares }}</td>
                                    <td>{{ $aeronave->conta_horas }}</td>
                                    <td>{{ $aeronave->preco_hora }}</td>
                                    <td>
                                    <div class="btn-group">
                                        <a class="btn btn-xs btn-primary" href="{{route('socios.edit',['maticula'=>$aeronave->matricula])}}">Edit</a>
                                        <form action="{{route('socios.destroy',['maticula'=>$aeronave->matricula])}}" method="post" class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="id" value="{{$aeronave->matricula}}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                        </form>
                                            <a class="btn btn-xs btn-dark" href="">Desativar</a>
                                            <a class="btn btn-xs btn-success" href="">Ativar</a>
                                    </div>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h2>No users found</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
