@extends('layouts.app')

@section('content')

<div class="container">
    <br>
    <br>
    <br>
    <br>
    <br>
    <div class="row justify-content-center">
        <div class="col-md-12">
            @include("partials.errors")
            <div class="card">
                <div class="card-header"><h4>Lista de Aeronaves&nbsp;&nbsp;&nbsp;&nbsp;
                    @if(Auth::user()->isAdmin())
                    <a class="btn btn-success btn-lg" data-toggle="tooltip" title="Adicionar aeronave" href="{{ route('aeronaves.create') }}">{{ __(' + ') }}</a>
                    @endif
                    </h4>
                    </div>
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
                                
                                <th class="text-center">Matrícula</th>
                                <th class="text-center">Marca</th>
                                <th class="text-center">Modelo</th>
                                <th class="text-center">Nº de Lugares</th>
                                <th class="text-center">Total de Horas</th>
                                <th class="text-center">Preço por Hora</th>
                                @if(Auth::user()->isAdmin())
                                <th class="text-center">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($aeronaves as $aeronave)
                                <tr>
                                    <td class="text-center">{{ $aeronave->matricula }}</td>
                                    <td class="text-center">{{ $aeronave->marca }}</td>
                                    <td class="text-center">{{ $aeronave->modelo }}</td>
                                    <td class="text-center">{{ $aeronave->num_lugares }}</td>
                                    <td class="text-center">{{ $aeronave->conta_horas }}&nbsp;h</td>
                                    <td class="text-center">{{ $aeronave->preco_hora }}&nbsp;€/h</td>
                                    @if(Auth::user()->isAdmin())
                                    <td class="text-center">
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            data-toggle="tooltip" title="Ações">
                                                {{ __('Ações') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-primary btn-block" href="{{route('aeronaves.edit',['maticula'=>$aeronave->matricula])}}">Editar</a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{route('aeronaves.destroy',['maticula'=>$aeronave->matricula])}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="id" value="{{$aeronave->matricula}}">
                                                <input type="submit" class="btn btn-danger btn-block" value="Apagar">
                                                </form>
                                                <div class="dropdown-divider"></div>   

                                            </div>

                                        </div>

                                    </div>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                        </table>
                    @else
                        <h2>Não foram encontradas aeronaves.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
