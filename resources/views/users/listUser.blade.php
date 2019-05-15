@extends('layouts.app')

@section('content')
<!--
<div class="container">
<div class="row justify-content-center">

<table class="table table-striped">

    <thead>
    <tr colspan="4">Dados Pessoais</tr>
</thead>
<tbody>
    <tr>
        <td>Nº Socio: {{ Auth::user()->num_socio }}</td>
        <td>Nome: {{ Auth::user()->name }}</td>
        <td>Telefone: {{ Auth::user()->telefone }}</td>
        <td>Nome Informal: {{ Auth::user()->nome_informal }}</td>
    </tr>
    <tr>
        <td>Sexo: {{ Auth::user()->sexoToStr() }}</td>
        <td>Data Nascimento: {{ Auth::user()->data_nascimento }}</td>
        <td>E-mail: {{ Auth::user()->email }}</td>
        <td>Tipo_socio: {{ Auth::user()->tipoSocioToStr() }}</td>
    </tr>
    <tr>
        <td>NIF: {{ Auth::user()->nif }}</td>
        <td>Direcao: {{ Auth::user()->isDirecaoToStr() }}</td>
        <td>Quota: {{ Auth::user()->isQuotaPagaToStr() }}</td>
        <td>Ativo: {{ Auth::user()->isAtivoToStr() }}</td>
    </tr>
</table>

@if(Auth::user()->isPiloto())
<table class="table table-striped">
<thead>
    <tr colspan="4">Licenca</tr>
</thead>
    <tbody>
        <tr>
            <td>Nº Licenca: {{ Auth::user()->num_licenca }}</td>
            <td>Tipo Licenca: {{ Auth::user()->tipo_licenca }}</td>
            <td>Instrutor: {{ Auth::user()->instrutor }}</td>
            <td>Validade: {{ Auth::user()->validade_licenca }}</td> 
        </tr>
        <tr>
            <td colspan="2">Licenca Confirmada: {{ Auth::user()->licenca_confirmada }}</td>
            @if(!Storage::exists("app/licenca_".Auth::user()->id.".pdf"))
                <td colspan="2">Copia Digital: <a href="{{ asset('storage/app/docs_piloto/' . 'licenca_' . Auth::user()->id . '.pdf') }}" title="Licenca" target="_blank">Licenca</a>
            @else
                <td colspan="2">Copia Digital: Não </td>
            @endif
            <td></td>
            <td></td> 
        </tr>
</table>

<table class="table table-striped">
    <thead>
        <tr colspan="4">Certificado</tr>
    </thead>
    <tbody>
        <tr>
            <td>Nº Certificado: {{ Auth::user()->num_certificado }}</td>
            <td>Classe: {{ Auth::user()->classe_certificado }}</td>
            <td>Validade: {{ Auth::user()->validade_certificado }}</td>
            <td>Confirmado: {{ Auth::user()->certificado_confirmado }}</td> 
        </tr>
        <tr>
            @if(!Storage::exists("app/certificado_".Auth::user()->id.".pdf"))
                <td colspan="4">Copia Digital: <a href="{{ asset('storage/app/docs_piloto/' . 'certificado_' . Auth::user()->id . '.pdf') }}" title="Certificado" target="_blank">Certificado</a>
            @else
                <td colspan="4">Copia Digital: Não </td>
            @endif
        </tr>
</table>
@endif

<a class="btn btn-xs btn-primary" href="{{ route('socios.edit', ['id'=> Auth::user()->id]) }}">{{ __('Alterar Perfil') }}</a>
&nbsp &nbsp
<a class="btn btn-xs btn-primary" href="{{ route('password.showPass', ['id'=> Auth::user()->id]) }}">{{ __('Alterar Password') }}</a>
</div>
</div>

-->
<div class="container">
<div class="row justify-content-center">


<form method="GET" action="{{ route('socios') }}">

    <label for ="nume_socio">Número de sócio:</label>
    <input type="number" name="num_socio" value="1" autofocus min = "0" max = "99999999999">&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="text"  name="nome_informal" placeholder="Nome Informal" maxlength = "40">&nbsp;&nbsp;&nbsp;&nbsp;
    <input type="email" name="email" placeholder="Email" checked >&nbsp;&nbsp;&nbsp;&nbsp;

    <select name="tipo_socio">
    <option value="P" selected >Piloto</option>
    <option value="NP">Não Piloto</option>
    <option value="A">Aeromodelista</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;

    <label for ="direcao">Direção: </label>
    <select name="tipo_socio">
    <option value="S" selected >Sim</option>
    <option value="N">Não</option>
    <option value="A" checked>Ambos</option>
    </select>&nbsp;&nbsp;&nbsp;&nbsp;

    <input type="submit" class="btn btn-info" value ="Pesquisar">
  
</form>

</div>
</div>

<div class="container">
<a class="btn btn-xs btn-primary" href="{{ route('socios.create') }}">{{ __('Adicionar Socio') }}</a>
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Lista de Socios</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($users))
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Foto</th>
                                <th>Nº Socio</th>
                                <th>Name Informal</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Tipo Socio</th>
                                @if(Auth::user()->tipo_socio == 'P')
                                    <th>Num Licenca</th>
                                @endif
                                <th>Direcao</th>
                                @if(Auth::user()->direcao == 1)
                                    <th>Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                    @if(!empty($user->foto_url))
                                        <img halt="foto $user->nome_informal" src ="{{ asset('storage/fotos/' . $user->foto_url) }}" >
                                    @endif
                                    </td>
                                    <td>{{ $user->num_socio }}</td>
                                    <td>{{ $user->nome_informal }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telefone }}</td>
                                    <td>{{ $user->tipoSocioToStr() }}</td>
                                    @if(Auth::user()->tipo_socio == 'P')
                                        <td>{{ $user->num_licenca }}</td>
                                    @endif
                                    <td>{{ $user->isDirecaoToStr() }}</td>

                                    @if(Auth::user()->direcao == 1)
                                    <td>
                                        <!-- fill with edit and delete actions -->
                                        <a class="btn btn-xs btn-primary" href="{{route('socios.edit',['id'=>$user->id])}}">Edit</a>
                                        <form action="{{route('socios.destroy',['id'=>$user->id])}}" method="post" class="inline">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="Delete">
                                        </form>
                                        @if(Auth::user()->ativo == 1)
                                            <a class="btn btn-xs btn-danger" href="">Desativar</a>
                                        @else
                                            <a class="btn btn-xs btn-primary" href="">Ativar</a>
                                        @endif
                                    </td>
                                   @endif
                                </tr>

                            @endforeach
                        </table>
                        {{ $users->links() }}
                    @else
                        <h2>No users found</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
