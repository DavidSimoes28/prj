@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<div class="row justify-content-center">
@include("partials.errors")




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
                <div class="card-header"><h4>Lista de Pendentes&nbsp;&nbsp;&nbsp;&nbsp;
                   
                    </h4>
                    
                </div>
                
                </h3><div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif

                @if(count($pendentes))
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th class="text-center">Tipo</th>
                            <th class="text-center">ID / Nº Sócio</th>
                            <th class="text-center">Piloto</th>

                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($pendentes as $movimento)
                                <tr>
                                    <td class="text-center">Movimento</td>
                                    <td class="text-center">{{ $movimento->id }}</td>
                                    <td class="text-center">{{ $movimento->pilotos->nome_informal }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        {{ $pendentes->links() }}
                    @else
                        <h2>Nenhum assunto pendente.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
