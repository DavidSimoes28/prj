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
@if($errors)
    @include("partials.errors")
@endif

<form method="GET" action="{{ route('socios') }}" class="form-inline">

    <div class="col-xs-2">
        <label for ="num_socio"><strong>{{ __('Nº Sócio') }}</strong></label>
        <input type="number" class="form-control" name="num_socio" autofocus min="0" max="99999999999" value="{{ strval(old('num_socio',request()->num_socio )) }}" autofocus>
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="nome_informal"><strong>{{ __('Nome Informal') }}</strong></label>
        <input type="text" class="form-control" name="nome_informal" maxlength = "40" value="{{ strval(old('nome_informal',request()->nome_informal )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="email"><strong>{{ __('E-mail') }}</strong></label>
        <input type="text" class="form-control" name="email" value="{{ strval(old('email',request()->email )) }}">
    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label for ="tipo"><strong>{{ __('Tipo de Sócio') }}</strong></label>
        <select name="tipo" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="TODOS"   {{ strval(old('tipo' ,request()->tipo)) == "TODOS" ? "selected":"" }} >Todos</option>
        <option value="A"       {{ strval(old('tipo' ,request()->tipo)) == "A" ? "selected":""     }} >Aeromodelista</option>
        <option value="P"       {{ strval(old('tipo' ,request()->tipo)) == "P" ? "selected":""     }} >Piloto</option>
        <option value="NP"      {{ strval(old('tipo' ,request()->tipo)) == "NP" ? "selected":""    }} >Não Piloto</option>
        </select>
    </div>
    &nbsp;&nbsp;&nbsp;
    @if(Auth::user()->isAdmin())
        <div class="col-xs-2">
            <label for ="quotas_pagas"><strong>{{ __('Quotas pagas') }}</strong></label>
            <select name="quotas_pagas" class="btn btn-xs btn-secondary dropdown-toggle">
            <option value=""       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == ""      ? "selected":"" }} ></option>
            <option value="1"       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == "1"      ? "selected":"" }} >Sim</option>
            <option value="0"       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == "0"      ? "selected":"" }} >Não</option>    
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <div class="col-xs-2">
            <label for ="ativo"><strong>{{ __('Ativo') }} </strong> </label>
            <select name="ativo" class="btn btn-xs btn-secondary dropdown-toggle">
            <option value=""       {{ strval(old('ativo' ,request()->ativo)) == ""      ? "selected":"" }} ></option>
            <option value="1"       {{ strval(old('ativo' ,request()->ativo)) == "1"      ? "selected":"" }} >Sim</option>
            <option value="0"       {{ strval(old('ativo' ,request()->ativo)) == "0"      ? "selected":"" }} >Não</option>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;&nbsp;
    @endif
    <div class="col-xs-2">
        <label for ="direcao"><strong>{{ __('Direção') }}</strong></label>
        <select name="direcao" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="AMBOS"   {{ strval(old('direcao' ,request()->direcao)) == "AMBOS"  ? "selected":"" }} >Ambos</option>
        <option value="1"       {{ strval(old('direcao' ,request()->direcao)) == "1"      ? "selected":"" }} >Sim</option>
        <option value="0"       {{ strval(old('direcao' ,request()->direcao)) == "0"      ? "selected":"" }} >Não</option>    
    </select>

    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label>&nbsp;</label>
        <div class="btn-group">
            <input type="submit" class="btn btn-xs btn-primary" value = "Pesquisar">
            <a class="btn btn-xs btn-danger" href=" {{ route('socios') }} "><i class="fa fa-trash"></i></a>
        </div>
    </div>
    </div>

   
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
  
</form>
<br>
<br>
</div>
</div>


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h3>Lista de Sócios&nbsp;&nbsp;&nbsp;&nbsp;<a class="btn btn-success btn-lg" href="{{ route('socios.create') }}">{{ __(' + ') }}</a></div>
                </h3><div class="card-body ">
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
                                <th>Nº Sócio</th>
                                <th>Nome Informal</th>
                                <th>Email</th>
                                <th>Telefone</th>
                                <th>Nº Licença</th>
                                <th>Tipo de Sócio</th>
                                <th>Direção</th>
                                @if(Auth::user()->direcao == 1)
                                    <th>Ações</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                    @if (!empty($user->foto_url))
                                        <img alt="Photo of {{ $user->nome_informal }}" src="{{ asset('storage/fotos/' . $user->foto_url) }}">
                                    @endif
                                    </td>
                                    <td>{{ $user->num_socio }}</td>
                                    <td>{{ $user->nome_informal }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->telefone }}</td>
                                    <td>
                                    @if($user->isPiloto())
                                        {{ $user->num_licenca }}
                                    @endif
                                    </td>
                                    <td>{{ $user->tipoSocioToStr() }}</td>
                                    <td>{{ $user->isDirecaoToStr() }}</td>

                                    @if(Auth::user()->direcao == 1)
                                    <td>
                                        <div class="btn-group">
                                        <!-- fill with edit and delete actions -->
                                        <a class="btn btn-xs btn-primary" href="{{route('socios.edit',['id'=>$user->id])}}">Editar</a>
                                        <form action="{{route('socios.destroy',['id'=>$user->id])}}" method="post">
                                            @csrf
                                            @method('DELETE')

                                            <input type="hidden" name="id" value="{{$user->id}}">
                                            <input type="submit" class="btn btn-xs btn-danger btn-block" value="Apagar">
                                        </form>
                                        @if($user->ativo == 1)
                                            <a class="btn btn-xs btn-secondary btn-block" href="">Desativar</a>
                                        @else
                                            <a class="btn btn-xs btn-success btn-block" href="">  Ativar</a>
                                        @endif
                                        </div>
                                    </td>
                                   @endif
                                </tr>

                            @endforeach
                        </table>
                        {{ $users->links() }}
                    @else
                        <h2>Nenhum sócio encontrado.</h2>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
