@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
        @if($errors)
            @include("partials.errors")
        @endif
            <div class="card">
                <div class="card-header"><h3 class="text-center">Editar Sócio</h3></div>
                <div class="card-body">
                    <form method="POST" action="{{ route('socios.update',['id'=>$user->id]) }}" enctype="multipart/form-data">
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" value="{{ $user->name }}" required autofocus>

                                @if ($errors->has('name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nome_informal" class="col-md-4 col-form-label text-md-right">{{ __('Nome Informal') }}</label>

                            <div class="col-md-6">
                                <input id="nome_informal" type="text" class="form-control{{ $errors->has('nome_informal') ? ' is-invalid' : '' }}" name="nome_informal" value="{{ $user->nome_informal }}" required autofocus>

                                @if ($errors->has('nome_informal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nome_informal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $user->email }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="data_nascimento" class="col-md-4 col-form-label text-md-right">{{ __('Data de Nascimento') }}</label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="date" class="form-control{{ $errors->has('data_nascimento') ? ' is-invalid' : '' }}" value="{{ $user->data_nascimento }}" name="data_nascimento" required>

                                @if ($errors->has('data_nascimento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('data_nascimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="nif" class="col-md-4 col-form-label text-md-right">{{ __('NIF') }}</label>

                            <div class="col-md-6">
                                <input id="nif" type="text" class="form-control{{ $errors->has('nif') ? ' is-invalid' : '' }}" name="nif" value="{{ $user->nif }}" autofocus>

                                @if ($errors->has('nif'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nif') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file_foto" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <input type="file" id="file_foto" name="file_foto">
                                @if ($errors->has('file_foto'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file_foto') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                            <div class="col-md-6">
                                <input id="telefone" name="telefone" type="text" class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}" value="{{ $user->telefone }}">

                                @if ($errors->has('telefone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="endereco" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>

                            <div class="col-md-6">
                                <textarea id="endereco" name="endereco" class="form-control{{ $errors->has('endereco') ? ' is-invalid' : '' }}">{{ $user->endereco }}</textarea>

                                @if ($errors->has('endereco'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('endereco') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        @if ( Auth::user()->isPiloto() )

                            @include ('users.piloto.editPiloto')

                        @endif

                        @if ( Auth::user()->isAdmin() )

                            @include ('users.direcao.editDirecao')

                        @endif
                        
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 btn-group">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                <a class="btn btn-xs btn-danger" href="{{ route('socios') }}">{{ __('Cancelar') }}</a>
                                
                                @if( $user->email_verified_at == null )
                                <form method="POST" action="">
                                    <input type="submit" class="btn btn-xs btn-secondary" value="{{ __('Reenviar verificação Email') }}">  
                                </form>
                                @endif

                            </div>                          
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
