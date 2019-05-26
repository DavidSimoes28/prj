@extends('layouts.app')

@section('content')


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
        <option value="TODOS"   {{ strval(old('tipo' ,request()->tipo)) == "TODOS" ? "selected":"" }} >--</option>
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
            <option value=""       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == ""      ? "selected":"" }} >--</option>
            <option value="1"       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == "1"      ? "selected":"" }} >Sim</option>
            <option value="0"       {{ strval(old('quotas_pagas' ,request()->quotas_pagas)) == "0"      ? "selected":"" }} >Não</option>    
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;
        <div class="col-xs-2">
            <label for ="ativo"><strong>{{ __('Ativo') }} </strong> </label>
            <select name="ativo" class="btn btn-xs btn-secondary dropdown-toggle">
            <option value=""       {{ strval(old('ativo' ,request()->ativo)) == ""      ? "selected":"" }} >--</option>
            <option value="1"       {{ strval(old('ativo' ,request()->ativo)) == "1"      ? "selected":"" }} >Sim</option>
            <option value="0"       {{ strval(old('ativo' ,request()->ativo)) == "0"      ? "selected":"" }} >Não</option>
            </select>
        </div>
        &nbsp;&nbsp;&nbsp;
    @endif
    <div class="col-xs-2">
        <label for ="direcao"><strong>{{ __('Direção') }}</strong></label>
        <select name="direcao" class="btn btn-xs btn-secondary dropdown-toggle">
        <option value="AMBOS"   {{ strval(old('direcao' ,request()->direcao)) == "AMBOS"  ? "selected":"" }} >--</option>
        <option value="1"       {{ strval(old('direcao' ,request()->direcao)) == "1"      ? "selected":"" }} >Sim</option>
        <option value="0"       {{ strval(old('direcao' ,request()->direcao)) == "0"      ? "selected":"" }} >Não</option>    
    </select>

    </div>
    &nbsp;&nbsp;&nbsp;
    <div class="col-xs-2">
        <label>&nbsp;</label>
        <div class="btn-group">
            <button type="submit" class="btn btn-xs btn-primary" data-toggle="tooltip"  title="Pesquisar">Pesquisa&nbsp;<i class="fas fa-search"></i></button>
            <a class="btn btn-xs btn-danger" href=" {{ route('socios') }} " data-toggle="tooltip" title="Limpar pesquisa"><i class="fa fa-trash"></i></a>
        </div>
    </div>
    </div>
    
  
</form>
<br>
<br>
</div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header"><h4>Lista de Sócios&nbsp;&nbsp;&nbsp;&nbsp;
                    @if(Auth::user()->isAdmin())
                    <div class="btn-group dropright">
                    <button type="button" class="btn btn-primary dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                    data-toggle="tooltip">
                    <i class="fas fa-user-tie"></i> {{ __(' Opções direção') }}
                    </button>
                    
                    <div class="dropdown-menu">
                        <a class="btn btn-success btn-block" data-toggle="tooltip" title="Adicionar sócio" href="{{ route('socios.create') }}">{{ __('Adicionar sócio ') }}<i class="fas fa-user-plus"></i></a>
                        <div class="dropdown-divider"></div>
                        
                        <form method="post" action="{{route('socios.reset_quotas')}}">
                        @csrf
                        @method('patch')
                        <button type ="submit" class="btn btn-primary btn-block">Todas as quotas por pagar&nbsp;<i class="far fa-thumbs-down"></i></button>
                        </form>

                        <div class="dropdown-divider"></div>

                        <form method="post" action="{{route('socios.desativar_sem_quotas')}}">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-danger btn-block">Desativar sócios com quotas por pagar&nbsp;<i class="far fa-times-circle"></i></button>
                        
                        </form>
                           
                    </div>
                    </h4>
                    @endif
                    
                </div>
                
                </h3><div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if(count($users))
                        <table class="table table-striped">
                        <thead>
                            <tr>
                                <th class="text-center" style="width: 10%">Foto</th>
                                <th class="text-center" style="width: 4%">Nº Sócio</th>
                                <th class="text-center" style="width: 15%">Nome Informal</th>
                                <th class="text-center">Email</th>
                                <th class="text-center" style="width: 7%">Telefone</th>
                                <th class="text-center" style="width: 6%">Nº Licença</th>
                                <th class="text-center" style="width: 6%">Tipo de Sócio</th>
                                <th class="text-center" style="width: 6%">Direção</th>
                                @if(Auth::user()->isAdmin())
                                    <th class="text-center" style="width: 6%">Ativo</th>
                                    <th class="text-center" style="width: 6%">Quota</th>
                                    <th class="text-center" style="width: 6%">Ações</th>
                                @endif
                            </tr>
                        </thead>
                        
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td class="text-center">
                                    @if (!empty($user->foto_url))
                                        <img alt="Photo of {{ $user->nome_informal }}" src="{{ asset('storage/fotos/' . $user->foto_url) }}">
                                    @endif
                                    </td>
                                    <td class="text-center">{{ $user->num_socio }}</td>
                                    <td class="text-center">{{ $user->nome_informal }}</td>
                                    <td class="text-center">{{ $user->email }}</td>
                                    <td class="text-center">{{ $user->telefone }}</td>
                                    <td class="text-center">
                                    @if($user->isPiloto())
                                        {{ $user->num_licenca }}
                                    @endif
                                    </td class="text-center">
                                    <td class="text-center">{{ $user->tipoSocioToStr() }}</td>
                                    <td class="text-center">{{ $user->isDirecaoToStr() }}</td>
                                    @if(Auth::user()->isAdmin())
                                    <td class="text-center">{{ $user->isAtivoToStr() }}</td>
                                    <td class="text-center">{{ $user->isQuotaPagaToStr() }}</td>

                                    <td class="text-center">
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                            data-toggle="tooltip" title="Ações">
                                                {{ __('Ações') }}
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="btn btn-primary btn-block" href="{{route('socios.edit',['id'=>$user->id])}}">Editar&nbsp;<i class="far fa-edit"></i></a>
                                                <div class="dropdown-divider"></div>

                                                <form action="{{route('socios.destroy',['id'=>$user->id])}}" method="post">
                                                @csrf
                                                @method('DELETE')

                                                <input type="hidden" name="id" value="{{$user->id}}">
                                                <button type="submit" class="btn btn-danger btn-block">Apagar&nbsp;<i class="fas fa-user-times"></i></button>
                                                </form>

                                                <div class="dropdown-divider"></div>            
                                                <form method="post" action="{{route('socios.ativo',['id'=>$user->id])}}">
                                                    @csrf
                                                    @method('patch')

                                                    @if($user->isAtivo())
                                                        <button type="submit" class="btn btn-dark btn-block"  name="ativo" data-toggle="tooltip"  title="Desativar">Desativar&nbsp;<i class="fas fa-exclamation-triangle"></i></button>
                                                    @else
                                                        <button type="submit" class="btn btn-success btn-block"  name="ativo" data-toggle="tooltip"  title="Ativar">Ativar&nbsp;<i class="fas fa-check"></i></button>
                                                    @endif
                                                </form>

                                                <div class="dropdown-divider"></div>
                                                <form method="post" action="{{route('socios.quotas',['id'=>$user->id])}}">
                                                    @csrf
                                                    @method('patch')
                                                    
                                                    @if($user->isQuotaPaga())
                                                        <button name="quota_paga" type="submit" class="btn btn-danger btn-block">Sócio não pagou&nbsp;<i class="fas fa-coins"></i></button>
                                                    @else
                                                    <button name="quota_paga" type="submit" class="btn btn-success btn-block">Sócio já pagou&nbsp;<i class="fas fa-coins"></i></button>
                                                    @endif
                                                </form>
                                            </div>

                                        </div>
                                    </td>
                                   @endif
                                </tr>
                            @endforeach
                        </tbody>
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
