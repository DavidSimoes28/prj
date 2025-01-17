@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if($errors)
    @include("partials.errors")
@endif
            <div class="card">
                <div class="card-header"><h3 class="text-center">{{ __('Editar Aeronave') }}<h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('aeronaves.update',['matricula'=>$aeronave->matricula]) }}">
                        @csrf
                        @method("PUT")

                        <div class="form-group row">
                            <label for="matricula" class="col-md-4 col-form-label text-md-right">{{ __('Matrícula') }}</label>

                            <div class="col-md-6">
                                <input id="matricula" type="text" class="form-control{{ $errors->has('matricula') ? ' is-invalid' : '' }}" name="matricula" required autofocus value="{{ $aeronave->matricula }}">

                                @if ($errors->has('matricula'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('matricula') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="marca" class="col-md-4 col-form-label text-md-right">{{ __('Marca') }}</label>

                            <div class="col-md-6">
                                <input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" required autofocus value="{{ $aeronave->marca }}">

                                @if ($errors->has('marca'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('marca') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label for="modelo" class="col-md-4 col-form-label text-md-right">{{ __('Modelo') }}</label>

                            <div class="col-md-6">
                                <input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" required autofocus value="{{ $aeronave->modelo }}">

                                @if ($errors->has('modelo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('modelo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_lugares" class="col-md-4 col-form-label text-md-right">{{ __('Nº de lugares') }}</label>

                            <div class="col-md-6">
                                <input id="num_lugares" type="text" class="form-control{{ $errors->has('num_lugares') ? ' is-invalid' : '' }}" name="num_lugares" required autofocus value="{{ $aeronave->num_lugares }}">

                                @if ($errors->has('num_lugares'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_lugares') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="conta_horas" class="col-md-4 col-form-label text-md-right">{{ __('Total de Horas') }}</label>

                            <div class="col-md-6">
                                <input id="conta_horas" type="text" class="form-control{{ $errors->has('conta_horas') ? ' is-invalid' : '' }}" name="conta_horas" required autofocus value="{{ $aeronave->conta_horas }}">

                                @if ($errors->has('conta_horas'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('conta_horas') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="preco_hora" class="col-md-4 col-form-label text-md-right">{{ __('Preço por Hora') }}</label>

                            <div class="col-md-6">
                                <input id="preco_hora" type="text" class="form-control{{ $errors->has('preco_hora') ? ' is-invalid' : '' }}" name="preco_hora" required autofocus value="{{ $aeronave->preco_hora }}">

                                @if ($errors->has('preco_hora'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('preco_hora') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        <br>
                        <div class="form-group row">
                        <table align="center" style="width: 60%">
                            <thead>
                            <tr>
                            <th class="text-center" colspan="2"><h4>{{ __('Lista de Preços') }}</h4></th>
                            </tr>
                                <tr>
                                    <th class="text-center"><h5>Tempo</h5></th>
                                    <th class="text-center"><h5>Preço</h5></th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($valores))
                                    @for($i=1;$i<=10;$i++)
                                    <tr>
                                        <td class="text-center"><input type="text" name="tempos[]" class="form-control"></td>
                                        <td class="text-center"><input type="text" name="precos[]" class="form-control"></td>
                                    </tr>
                                    @endfor
                                @else
                                    @foreach ($valores as $valor)
                                    <tr>
                                        <td class="text-center"><input type="text" name="tempos[]" value="{{$valor->minutos}}" class="form-control"></td>
                                        <td class="text-center"><input type="text" name="precos[]" value="{{$valor->preco}}" class="form-control"></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>
                        <br>

                        <div class="form-group row mb-0">
                        
                            <div class="col-md-6 offset-md-4 btn-group">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                </button>
                                <a class="btn btn-xs btn-danger" href="{{ route('aeronaves') }}">{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                        
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
                        