@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Adicionar Sócio') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('socios.create',['id'=>$user->id])}}" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group row">
                            <label for="num_socio" class="col-md-4 col-form-label text-md-right">{{ __('Nº Socio') }}</label>

                            <div class="col-md-6">
                                <input id="num_socio" type="text" class="form-control{{ $errors->has('num_socio') ? ' is-invalid' : '' }}" name="num_socio" required autofocus>

                                @if ($errors->has('num_socio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_socio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control{{ $errors->has('name') ? ' is-invalid' : '' }}" name="name" required autofocus>

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
                                <input id="nome_informal" type="text" class="form-control{{ $errors->has('nome_informal') ? ' is-invalid' : '' }}" name="nome_informal" required autofocus>

                                @if ($errors->has('nome_informal'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nome_informal') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail Address') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="data_nascimento" class="col-md-4 col-form-label text-md-right">{{ __('Data Nascimento') }}</label>

                            <div class="col-md-6">
                                <input id="data_nascimento" type="date" class="form-control{{ $errors->has('data_nascimento') ? ' is-invalid' : '' }}" name="data_nascimento" required>

                                @if ($errors->has('data_nascimento'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('data_nascimento') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="sexo" class="col-md-4 col-form-label text-md-right">{{ __('Sexo') }}</label>
                            <div class="col-md-6">
                                <input type="radio" class="form{{ $errors->has('sexo') ? ' is-invalid' : '' }}" name="sexo" value="M" checked required> Masculino <br>
                                <input type="radio" class="form-{{ $errors->has('sexo') ? ' is-invalid' : '' }}" name="sexo" value="F" required> Feminino
                                @if ($errors->has('sexo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('sexo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="foto_url" class="col-md-4 col-form-label text-md-right">{{ __('Foto') }}</label>

                            <div class="col-md-6">
                                <input type="file" id="foto_url" name="foto_url">
                                @if ($errors->has('foto_url'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('foto_url') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_socio" class="col-md-4 col-form-label text-md-right">{{ __('Tipo socio') }}</label>
                            <div class="col-md-6">
                                <input type="radio" class="form{{ $errors->has('tipo_socio') ? ' is-invalid' : '' }}" name="tipo_socio" value="P" checked required> Piloto<br>
                                <input type="radio" class="form{{ $errors->has('tipo_socio') ? ' is-invalid' : '' }}" name="tipo_socio" value="NP" required> Não Piloto<br>
                                <input type="radio" class="form{{ $errors->has('tipo_socio') ? ' is-invalid' : '' }}" name="tipo_socio" value="A" required> Aeromodelista
                                @if ($errors->has('tipo_socio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipo_socio') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Adicionar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection