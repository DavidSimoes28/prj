@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include("partials.errors")
            <div class="card">
                <div class="card-header"><h3 class="text-center">{{ __('Adicionar Sócio') }}</h3></div>

                <div class="card-body">
                    <form method="POST" action="{{route('socios.store')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="num_socio" class="col-md-4 col-form-label text-md-right">{{ __('Nº Sócio') }}</label>

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
                            <label for="name" class="col-md-4 col-form-label text-md-right">{{ __('Nome') }}</label>

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
                            <label for="data_nascimento" class="col-md-4 col-form-label text-md-right">{{ __('Data de Nascimento') }}</label>

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
                            <label for="nif" class="col-md-4 col-form-label text-md-right">{{ __('Nif') }}</label>

                            <div class="col-md-6">
                                <input id="nif" type="text" class="form-control{{ $errors->has('nif') ? ' is-invalid' : '' }}" name="nif" required autofocus>

                                @if ($errors->has('nif'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nif') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="telefone" class="col-md-4 col-form-label text-md-right">{{ __('Telefone') }}</label>

                            <div class="col-md-6">
                                <input id="telefone" type="text" class="form-control{{ $errors->has('telefone') ? ' is-invalid' : '' }}" name="telefone" required autofocus>

                                @if ($errors->has('telefone'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('telefone') }}</strong>
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
                            <label for="tipo_socio" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Sócio') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('tipo_socio') ? ' is-invalid' : '' }}"  name="tipo_socio">
                                    <option value="P">Piloto</option>
                                    <option value="NP">Não Piloto</option>
                                    <option value="A">Aeromodelista</option>
                                </select>-->
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


                        <div class="form-group row">
                            <label for="endereco" class="col-md-4 col-form-label text-md-right">{{ __('Endereço') }}</label>

                            <div class="col-md-6">
                                <textarea id="endereco" class="form-control{{ $errors->has('endereco') ? ' is-invalid' : '' }}" name="endereco"> </textarea>

                                @if ($errors->has('endereco'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('endereco') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>


                        <!--                                 PILOTOS                                             -->
                        <div class="form-group row">
                            <label for="num_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Nº Licença') }}</label>

                            <div class="col-md-6">
                                <input id="num_licenca" type="text" class="form-control{{ $errors->has('num_licenca') ? ' is-invalid' : '' }}" name="num_licenca" value="{{ $user->num_licenca }}" autofocus>

                                @if ($errors->has('num_licenca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_licenca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file_licenca" class="col-md-4 col-form-label text-md-right">
                            @if($user->hasLicenca())
                            <a href="{{ route('pilotos.licenca',['id'=>$user->id]) }}" title="licenca" target="_blank"><strong>{{ __('Cópia da Licença') }}&nbsp;</strong><i class="far fa-file-alt"></i></a>
                            @else
                            {{ __('Cópia da Licença') }}
                            @endif
                            </label>

                            <div class="col-md-6">
                                <input type="file" id="file_licenca" name="file_licenca">
                                @if ($errors->has('file_licenca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file_licenca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tipo_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Tipo Licença') }}</label>
                            <div class="col-md-6">
                                <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('tipo_licenca') ? ' is-invalid' : '' }}"  name="tipo_licenca">                   
                                    @foreach ($licencas as $tipo)
                                        <option value="{{$tipo->code}}">{{ $tipo->code }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('tipo_licenca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tipo_licenca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="validade_licenca" class="col-md-4 col-form-label text-md-right">{{ __('Validade Licença') }}</label>

                            <div class="col-md-6">
                                <input id="validade_licenca" type="date" class="form-control{{ $errors->has('validade_licenca') ? ' is-invalid' : '' }}" name="validade_licenca" value="{{ $user->validade_licenca }}" autofocus>

                                @if ($errors->has('validade_licenca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validade_licenca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Nº Certificado') }}</label>

                            <div class="col-md-6">
                                <input id="num_certificado" type="text" class="form-control{{ $errors->has('num_certificado') ? ' is-invalid' : '' }}" name="num_certificado" value="{{ $user->num_certificado }}" autofocus>

                                @if ($errors->has('num_certificado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_certificado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="file_certificado" class="col-md-4 col-form-label text-md-right">
                            
                            
                            @if($user->hasCertificado())
                            <a href="{{ route('pilotos.certificado',['id'=>$user->id]) }}" title="Certificado" target="_blank"><strong>{{ __('Cópia de Certificado') }}&nbsp;</strong><i class="fas fa-file-medical-alt"></i></a>
                            @else
                            {{ __('Cópia de Certificado') }}
                            @endif

                            </label>

                            <div class="col-md-6">
                                <input type="file" id="file_certificado" name="file_certificado">
                                @if ($errors->has('file_certificado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file_certificado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="classe_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Classe de Certificado') }}</label>
                            <div class="col-md-6">
                                <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('classe_certificado') ? ' is-invalid' : '' }}"  name="classe_certificado" >                   
                                    @foreach ($certificados as $classe)
                                        <option value="{{$classe->code}}">{{ $classe->code }} </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('classe_certificado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('classe_certificado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="validade_certificado" class="col-md-4 col-form-label text-md-right">{{ __('Validade Certificado') }}</label>
                            <div class="col-md-6">
                                <input id="validade_certificado" type="date" class="form-control{{ $errors->has('validade_certificado') ? ' is-invalid' : '' }}" name="validade_certificado" autofocus>
                                @if ($errors->has('validade_certificado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('validade_certificado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="instrutor" class="col-md-4 col-form-label text-md-right">{{ __('Instrutor') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('instrutor') ? ' is-invalid' : '' }}"  name="instrutor">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select>-->
                                <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="0" checked> Não <br>
                                <input type="radio" class="form{{ $errors->has('instrutor') ? ' is-invalid' : '' }}" name="instrutor" value="1"> Sim <br>
                                @if ($errors->has('instrutor'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('instrutor') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="aluno" class="col-md-4 col-form-label text-md-right">{{ __('Aluno') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('aluno') ? ' is-invalid' : '' }}"  name="aluno">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('aluno') ? ' is-invalid' : '' }}" name="aluno" value="0" checked> Não <br>
                                <input type="radio" class="form{{ $errors->has('aluno') ? ' is-invalid' : '' }}" name="aluno" value="1"> Sim <br>
                                @if ($errors->has('aluno'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('aluno') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <!--                                         DIREÇÃO                                           -->

                        <div class="form-group row">
                            <label for="certificado_confirmado" class="col-md-4 col-form-label text-md-right">{{ __('Certificado confirmado') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('certificado_confirmado') ? ' is-invalid' : '' }}"  name="certificado_confirmado">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('certificado_confirmado') ? ' is-invalid' : '' }}" name="certificado_confirmado" value="0" checked> Não <br>
                                <input type="radio" class="form{{ $errors->has('certificado_confirmado') ? ' is-invalid' : '' }}" name="certificado_confirmado" value="1"> Sim <br>
                                @if ($errors->has('certificado_confirmado'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('certificado_confirmado') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="licenca_confirmada" class="col-md-4 col-form-label text-md-right">{{ __('Licença confirmada') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('licenca_confirmada') ? ' is-invalid' : '' }}"  name="licenca_confirmada">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('licenca_confirmada') ? ' is-invalid' : '' }}" name="licenca_confirmada" value="0" checked> Não <br>
                                <input type="radio" class="form{{ $errors->has('licenca_confirmada') ? ' is-invalid' : '' }}" name="licenca_confirmada" value="1"> Sim <br>
                                @if ($errors->has('licenca_confirmada'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('licenca_confirmada') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        
                        <div class="form-group row">
                            <label for="quota_paga" class="col-md-4 col-form-label text-md-right">{{ __('Quota Paga') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('quota_paga') ? ' is-invalid' : '' }}"  name="quota_paga">
                                    <option value="0">Não</option>
                                    <option value="1" selected>Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('quota_paga') ? ' is-invalid' : '' }}" name="quota_paga" value="1" checked required> Sim<br>
                                <input type="radio" class="form{{ $errors->has('quota_paga') ? ' is-invalid' : '' }}" name="quota_paga" value="0" required> Não<br>
                                
                                @if ($errors->has('quota_paga'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('quota_paga') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="direcao" class="col-md-4 col-form-label text-md-right">{{ __('Direção') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('direcao') ? ' is-invalid' : '' }}"  name="direcao">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('direcao') ? ' is-invalid' : '' }}" name="direcao" value="0" checked> Não <br>
                                <input type="radio" class="form{{ $errors->has('direcao') ? ' is-invalid' : '' }}" name="direcao" value="1"> Sim <br>
                                @if ($errors->has('direcao'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('direcao') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="ativo" class="col-md-4 col-form-label text-md-right">{{ __('Sócio Ativo') }}</label>
                            <div class="col-md-6">
                                <!--<select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('ativo') ? ' is-invalid' : '' }}"  name="ativo">
                                    <option value="0">Não</option>
                                    <option value="1">Sim</option>
                                </select> -->
                                <input type="radio" class="form{{ $errors->has('ativo') ? ' is-invalid' : '' }}" name="ativo" value="1" checked required> Sim <br>
                                <input type="radio" class="form-{{ $errors->has('ativo') ? ' is-invalid' : '' }}" name="ativo" value="0" required> Não -->
                                @if ($errors->has('ativo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('ativo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                        
                            <div class="col-md-6 offset-md-4 btn-group">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Adicionar') }}
                                </button>
                                <a class="btn btn-xs btn-danger" href="{{ route('socios') }}">{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection