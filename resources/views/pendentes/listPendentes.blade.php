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
                
                </h3><div class="card-body">
                @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
                @endif
                
                    @if( count($movimentos) || count($certificados) || count($licencas) || count($conflitos) )
                        @if( count($movimentos) )
                        <div class="card-header"><th><h4>Lista de movimentos por confirmar</h4></th>
                        </div>
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 20%">Tipo</th>
                            <th class="text-center" style="width: 25%">ID Movimento</th>
                            <th class="text-center" style="width: 30%">Piloto</th>
                            <th class="text-center" style="width: 25%">Natureza</th>

                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($movimentos as $movimento)
                                <tr>
                                    <td class="text-center"><a href="{{ route('movimentos.edit', ['id'=> $movimento->id] ) }}">Movimento&nbsp;<i class="far fa-edit"></i></a></td>
                                    <td class="text-center">{{ $movimento->id }}</td>
                                    <td class="text-center">{{ $movimento->pilotos->nome_informal }}</td>
                                    <td class="text-center">{{ $movimento->naturezaToStr() }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>  
                        <br>
                        @endif

                        

                        @if( count($conflitos))
                        <div class="card-header"><th><h4>Lista de movimentos conflituosos</h4></th>
                        </div>
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 20%">Tipo</th>

                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($conflitos as $conflito)
                                <tr>
                                    <td class="text-center"><a href="{{ route('movimentos.edit', ['id'=> $conflito->id] ) }}">Conflito&nbsp;<i class="far fa-edit"></i></a></td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>  
                        <br>
                        @endif

                        
                        @if( count($certificados) )
                        <div class="card-header"><th><h4>Lista de certificados por confirmar</h4></th>
                        </div>
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            <th class="text-center" style="width: 20%">Tipo</th>
                            <th class="text-center" style="width: 25%">Nº Sócio</th>
                            <th class="text-center" style="width: 30%">Nome Informal</th>
                            <th class="text-center" style="width: 25%">Nº Certificado</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($certificados as $certificado)
                                <tr>
                                    <td class="text-center" ><a href="{{ route('socios.edit', ['id'=> $certificado->id] ) }}">Certificado&nbsp;<i class="far fa-edit"></i></a></td>
                                    <td class="text-center" >{{$certificado->num_socio}}</td>
                                    <td class="text-center" >{{$certificado->nome_informal}}</td>
                                    <td class="text-center" >{{$certificado->num_certificado}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table>
                        <br>  
                        @endif

                        

                        @if( count($licencas) )
                        <div class="card-header"><th><h4>Lista de licenças por confirmar</h4></th>
                        </div>
                        <table class="table table-striped">
                        <thead>
                            <tr>
                            </tr>
                            <tr>
                            <th class="text-center" style="width: 20%">Tipo</th>
                            <th class="text-center" style="width: 25%">Nº Sócio</th>
                            <th class="text-center" style="width: 30%">Nome Informal</th>
                            <th class="text-center" style="width: 25%">Nº Licença</th>
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($licencas as $licenca)
                                <tr>
                                    <td class="text-center"><a href="{{ route('socios.edit', ['id'=> $licenca->id] ) }}">Licença&nbsp;<i class="far fa-edit"></i></a></td>
                                    <td class="text-center">{{$licenca->num_socio}}</td>
                                    <td class="text-center">{{$licenca->nome_informal}}</td>
                                    <td class="text-center">{{$licenca->num_licenca}}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        </table> 
                        <br> 
                        @endif
                       
                    @else
                        <h2>Nenhum assunto pendente.</h2>
                    @endif
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection
