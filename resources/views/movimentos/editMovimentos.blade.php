@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
        @if($errors)
            @include("partials.errors")
        @endif
            <div class="card">
                <div class="card-header"><h3 class="text-center">{{ __('Editar Movimento') }}<h3></div>

                <div class="card-body">
                    <form method="POST" action="{{ route('movimentos.update',['id'=>$movimento->id]) }}">
                        @csrf
                        @method("PUT")
                        
                        <div class="form-group row">
                            <label for="data" class="col-md-4 col-form-label text-md-right">{{ __('Data do Voo') }}</label>

                            <div class="col-md-6">
                                <input id="data" type="date" class="form-control{{ $errors->has('data') ? ' is-invalid' : '' }}" name="data"  value="{{ $movimento->data }}" required autofocus>

                                @if ($errors->has('data'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('data') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hora_descolagem" class="col-md-4 col-form-label text-md-right">{{ __('Hora Descolagem') }}</label>

                            <div class="col-md-6">
                                <input id="hora_descolagem" type="time" class="form-control{{ $errors->has('hora_descolagem') ? ' is-invalid' : '' }}" name="hora_descolagem" autofocus value="{{ date('H:m',strtotime($movimento->hora_descolagem)) }}"  required autofocus >

                                @if ($errors->has('hora_descolagem'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hora_descolagem') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="hora_aterragem" class="col-md-4 col-form-label text-md-right">{{ __('Hora Aterragem') }}</label>

                            <div class="col-md-6">
                                <input id="hora_aterragem" type="time" class="form-control{{ $errors->has('hora_aterragem') ? ' is-invalid' : '' }}" name="hora_aterragem"  value="{{ date('H:m',strtotime($movimento->hora_aterragem)) }}" required autofocus>

                                @if ($errors->has('hora_aterragem'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('hora_aterragem') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="aeronave" class="col-md-4 col-form-label text-md-right">{{ __('Matrícula Aeronave') }}</label>

                            <div class="col-md-6">
                                <input id="aeronave" type="text" class="form-control{{ $errors->has('aeronave') ? ' is-invalid' : '' }}" name="aeronave" value="{{ $movimento->aeronave }}" required autofocus>

                                @if ($errors->has('aeronave'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('aeronave') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_diario" class="col-md-4 col-form-label text-md-right">{{ __('Nº Diário') }}</label>

                            <div class="col-md-6">
                                <input id="num_diario" type="number" class="form-control{{ $errors->has('num_diario') ? ' is-invalid' : '' }}" name="num_diario" value="{{ $movimento->num_diario }}" required autofocus>

                                @if ($errors->has('num_diario'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_diario') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="num_servico" class="col-md-4 col-form-label text-md-right">{{ __('Nº Serviço') }}</label>

                            <div class="col-md-6">
                                <input id="num_servico" type="number" class="form-control{{ $errors->has('num_servico') ? ' is-invalid' : '' }}" name="num_servico" value="{{ $movimento->num_servico }}" required autofocus>

                                @if ($errors->has('num_servico'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_servico') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for ="natureza" class="col-md-4 col-form-label text-md-right">{{ __('Natureza de Voo') }}</label>
                            <div class="col-sm-6">
                                <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('natureza') ? ' is-invalid' : '' }}"  name="natureza" >

                                <option value="T"  {{ strval(old('natureza' ,$movimento->natureza)) == "T"  ? "selected":"" }} >Treino</option>
                                <option value="I"  {{ strval(old('natureza' ,$movimento->natureza)) == "I"  ? "selected":"" }} >Instrução</option>
                                <option value="E"  {{ strval(old('natureza' ,$movimento->natureza)) == "E"  ? "selected":"" }} >Especial</option>
                                </select> 
                                    
                                @if ($errors->has('natureza'))
                                    <span class="invalid-feedback" role="alert">
                                        {{ $errors->first('natureza') }}
                                    </span>
                                @endif   
                            </div>                     
                        </div>

                        @if ( Auth::user()->isAdmin() )
                            @include ('movimentos.direcao.editDirecao')
                        @elseif ( $movimento->pertencePiloto(Auth::user()) ) 
                            @include ('movimentos.piloto.editPiloto')
                        @endif

                        

                        <div class="form-group row">
                                <label for="aerodromo_partida" class="col-md-4 col-form-label text-md-right">{{ __('Aerodromo de Partida') }}</label>
    
                                <div class="col-md-6">
                                    <input id="aerodromo_partida" type="text" class="form-control{{ $errors->has('aerodromo_partida') ? ' is-invalid' : '' }}" name="aerodromo_partida" value="{{ $movimento->aerodromo_partida }}" required autofocus>
    
                                    @if ($errors->has('aerodromo_partida'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('aerodromo_partida') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="aerodromo_chegada" class="col-md-4 col-form-label text-md-right">{{ __('Aerodromo de Chegada') }}</label>
    
                                <div class="col-md-6">
                                    <input id="aerodromo_chegada" type="text" class="form-control{{ $errors->has('aerodromo_chegada') ? ' is-invalid' : '' }}" name="aerodromo_chegada" value="{{ $movimento->aerodromo_chegada }}" required autofocus>
    
                                    @if ($errors->has('aerodromo_chegada'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('aerodromo_chegada') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="num_aterragens" class="col-md-4 col-form-label text-md-right">{{ __('Nº Aterragens') }}</label>
    
                                <div class="col-md-6">
                                    <input id="num_aterragens" type="number" class="form-control{{ $errors->has('num_aterragens') ? ' is-invalid' : '' }}" name="num_aterragens"  value="{{ $movimento->num_aterragens }}" required autofocus>
    
                                    @if ($errors->has('num_aterragens'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('num_aterragens') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="num_descolagens" class="col-md-4 col-form-label text-md-right">{{ __('Nº Descolagens') }}</label>
    
                                <div class="col-md-6">
                                    <input id="num_descolagens" type="number" class="form-control{{ $errors->has('num_descolagens') ? ' is-invalid' : '' }}" name="num_descolagens" value="{{ $movimento->num_descolagens }}" required autofocus>
    
                                    @if ($errors->has('num_descolagens'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('num_descolagens') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="num_pessoas" class="col-md-4 col-form-label text-md-right">{{ __('Nº Pessoas a Bordo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="num_pessoas" type="number" class="form-control{{ $errors->has('num_pessoas') ? ' is-invalid' : '' }}" name="num_pessoas" value="{{ $movimento->num_pessoas }}" required autofocus>
    
                                    @if ($errors->has('num_pessoas'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('num_pessoas') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="conta_horas_inicio" class="col-md-4 col-form-label text-md-right">{{ __('Conta Horas Inicial') }}</label>
    
                                <div class="col-md-6">
                                    <input id="conta_horas_inicio" type="number" class="form-control{{ $errors->has('conta_horas_inicio') ? ' is-invalid' : '' }}" name="conta_horas_inicio" value="{{ $movimento->conta_horas_inicio }}" required autofocus>
    
                                    @if ($errors->has('conta_horas_inicio'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('conta_horas_inicio') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
                            <div class="form-group row">
                                <label for="conta_horas_fim" class="col-md-4 col-form-label text-md-right">{{ __('Conta Horas Final') }}</label>
    
                                <div class="col-md-6">
                                    <input id="conta_horas_fim" type="number" class="form-control{{ $errors->has('conta_horas_fim') ? ' is-invalid' : '' }}" name="conta_horas_fim" value="{{ $movimento->conta_horas_fim }}" required autofocus>
    
                                    @if ($errors->has('conta_horas_fim'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('conta_horas_fim') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
    
    
                            <div class="form-group row">
                                <label for ="modo_pagamento" class="col-md-4 col-form-label text-md-right">{{ __('Modo Pagamento') }}</label>
                                <div class="col-sm-6">
                                    <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('modo_pagamento') ? ' is-invalid' : '' }}"  name="modo_pagamento" >
                                    <option value="N"  {{ strval(old('modo_pagamento' ,$movimento->modo_pagamento)) == "N"  ? "selected":"" }} >Numerário</option>
                                    <option value="M"  {{ strval(old('modo_pagamento' ,$movimento->modo_pagamento)) == "M"      ? "selected":"" }} >Multibanco</option>
                                    <option value="T"  {{ strval(old('modo_pagamento' ,$movimento->modo_pagamento)) == "T"      ? "selected":"" }} >Tranferência</option>
                                    <option value="P"  {{ strval(old('modo_pagamento' ,$movimento->modo_pagamento)) == "P"      ? "selected":"" }} >Pacote de Horas</option>
                                    </select> 
                                        
                                    @if ($errors->has('modo_pagamento'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('modo_pagamento') }}
                                        </span>
                                    @endif   
                                </div>                     
                            </div>
    
                            <div class="form-group row">
                                <label for="num_recibo" class="col-md-4 col-form-label text-md-right">{{ __('Nº Recibo') }}</label>
    
                                <div class="col-md-6">
                                    <input id="num_recibo" type="text" class="form-control{{ $errors->has('num_recibo') ? ' is-invalid' : '' }}" name="num_recibo" value="{{ $movimento->num_recibo }}" required autofocus>
    
                                    @if ($errors->has('num_recibo'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('num_recibo') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                        <div class="form-group row">
                            <label for="observacoes" class="col-md-4 col-form-label text-md-right">{{ __('Observações') }}</label>

                            <div class="col-md-6">
                                <input id="observacoes" type="text" class="form-control{{ $errors->has('observacoes') ? ' is-invalid' : '' }}" name="observacoes" value="{{ $movimento->observacoes }}" >

                                @if ($errors->has('observacoes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observacoes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4 btn-group">
                                @if(!Auth::user()->isAdmin())
                                    <button type="submit" class="btn btn-success">
                                    {{ __('Guardar') }}
                                    </button>
                                @else
                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal">
                                        Guardar
                                    </button>
                                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="edit_confimacao" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4 class="modal-title" id="edit_confimacao">Confirmação Movimento</h4>
                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">
                                                    <p class="alert alert-danger">Se confirmar o movimento não poderá ser mais alterado.</p>    
                                                    Pretende guardar as alterações do movimento?<br>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Cancelar</button>
                                                    <button type="submit" class="btn btn-success">
                                                        {{ __('Guardar') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <a class="btn btn-xs btn-danger" href="{{ route('movimentos') }}">{{ __('Cancelar') }}</a>
                            </div>
                        </div>
                        
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection