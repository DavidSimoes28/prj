@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header"><h3 class="text-center">{{ __('Adicionar Aeronave') }}<h3></div>

                <div class="card-body">
                    <form method="POST" action="{{route('aeronaves.store')}}">
                        @csrf

                        <div class="form-group row">
                            <label for="matricula" class="col-md-4 col-form-label text-md-right">{{ __('Matrícula') }}</label>

                            <div class="col-md-6">
                                <input id="matricula" type="text" class="form-control{{ $errors->has('matricula') ? ' is-invalid' : '' }}" name="matricula" required autofocus>

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
                                <input id="marca" type="text" class="form-control{{ $errors->has('marca') ? ' is-invalid' : '' }}" name="marca" required autofocus>

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
                                <input id="modelo" type="text" class="form-control{{ $errors->has('modelo') ? ' is-invalid' : '' }}" name="modelo" required autofocus>

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
                                <input id="num_lugares" type="text" class="form-control{{ $errors->has('num_lugares') ? ' is-invalid' : '' }}" name="num_lugares" required autofocus>

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
                                <input id="conta_horas" type="text" class="form-control{{ $errors->has('conta_horas') ? ' is-invalid' : '' }}" name="conta_horas" required autofocus>

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
                                <input id="preco_hora" type="text" class="form-control{{ $errors->has('preco_hora') ? ' is-invalid' : '' }}" name="preco_hora" required autofocus>

                                @if ($errors->has('preco_hora'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('preco_hora') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="preco_hora" class="col-md-4 col-form-label text-md-right">{{ __('Lista de Preços') }}</label>
                            <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Tempo</th>
                                    <th>Preço</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(empty($valores))
                                    @for($i=1;$i<=10;$i++)
                                    <tr>
                                        <td align="center"><input type="text" name="tempos[$i]" value="{{$i*5}}"></td>
                                        <td align="center"><input type="text" name="precos[$i]" value=""></td>
                                    </tr>
                                    @endfor
                                @else
                                    @foreach ($valores as $valor => $i)
                                    <tr>
                                        <td align="center"><input type="text" name="tempos[$i+1]" value="{{$valor->minutos}}"></td>
                                        <td align="center"><input type="text" name="precos[$i+1]" value="{{$valor->preco}}"></td>
                                    </tr>
                                    @endforeach
                                @endif
                            </table>
                        </div>

                        <div class="form-group row mb-0">
                        
                            <div class="col-md-6 offset-md-4 btn-group">
                                <button type="submit" class="btn btn-success">
                                    {{ __('Adicionar') }}
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