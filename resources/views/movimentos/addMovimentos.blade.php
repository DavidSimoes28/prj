@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @include("partials.errors")
            <div class="card">
                <div class="card-header">{{ __('Adicionar movimentos de Voos') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{route('movimentos.create')}}">
                        @csrf
                        <div class="form-group row">
                            <label for="data" class="col-md-4 col-form-label text-md-right">{{ __('Data do Voo') }}</label>

                            <div class="col-md-6">
                                <input id="data" type="date" class="form-control{{ $errors->has('data') ? ' is-invalid' : '' }}" name="data" required autofocus>

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
                                <input id="hora_descolagem" type="time" class="form-control{{ $errors->has('hora_descolagem') ? ' is-invalid' : '' }}" name="hora_descolagem" required autofocus>

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
                                <input id="hora_aterragem" type="time" class="form-control{{ $errors->has('hora_aterragem') ? ' is-invalid' : '' }}" name="hora_aterragem" required autofocus>

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
                                <input id="aeronave" type="text" class="form-control{{ $errors->has('aeronave') ? ' is-invalid' : '' }}" name="aeronave" required autofocus>

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
                                <input id="num_diario" type="number" class="form-control{{ $errors->has('num_diario') ? ' is-invalid' : '' }}" name="num_diario" required autofocus>

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
                                <input id="num_servico" type="number" class="form-control{{ $errors->has('num_servico') ? ' is-invalid' : '' }}" name="num_servico" required autofocus>

                                @if ($errors->has('num_servico'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('num_servico') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>



                        <div class="form-group row">
                                <label for ="piloto_id" class="col-md-4 col-form-label text-md-right">{{ __('ID Piloto') }}</label>
                                <div class="col-sm-6">
                                    <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('piloto_id') ? ' is-invalid' : '' }}"  name="piloto_id" value="{{ strval(old('piloto_id',request()->piloto_id )) }}" >
                                    <option value="P"   {{ strval(old('piloto_id' ,request()->piloto_id)) == "P"  ? "selected":"" }} >Piloto</option>
                                    <option value="I"   {{ strval(old('piloto_id' ,request()->piloto_id)) == "I"      ? "selected":"" }} >Instrutor</option>
                                    </select> 
                                       
                                    @if ($errors->has('piloto_id'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('piloto_id') }}
                                        </span>
                                    @endif   
                                    </div>                     
                            </div>
                        
                        <div class="form-group row">
                            <label for ="natureza" class="col-md-4 col-form-label text-md-right">{{ __('Natureza do Voo') }}</label>
                            <div class="col-sm-6">
                                
                                <div class="btn-group dropdown btn-block">
                                    <button type="button" class="btn btn-dark dropdown-toggle dropdown-toggle-split btn-block" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                    data-toggle="tooltip" title="Ações">
                                        {{ __('Selecione a Natureza do Voo') }}
                                    </button>
                                    <div class="dropdown-menu btn-block">
                                        <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample1" role="button" aria-expanded="false" aria-controls="collapseExample">Treino</a>
                                        <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample2" role="button" aria-expanded="false" aria-controls="collapseExample">Instrução</a>
                                        <a class="btn btn-primary btn-block" data-toggle="collapse" href="#collapseExample3" role="button" aria-expanded="false" aria-controls="collapseExample">Especial</a>   
                                    </div>        
                                </div>                                 
                            </div>                     
                        </div>
                      
                        <div class="collapse" id="collapseExample1">
                            <input type="text" value="T" hidden>
                        </div>   

                        <div class="collapse" id="collapseExample2">
                            <div class="card card-body">                              
                              <div class="form-group row">
                                <label for ="tipo_instrucao" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Instrução') }}</label>
                                <div class="col-sm-6">
                                    <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('tipo_instrucao') ? ' is-invalid' : '' }}"  name="tipo_instrucao" value="{{ strval(old('tipo_instrucao',request()->tipo_instrucao )) }}" >
                                    <option value="D"  {{ strval(old('tipo_instrucao' ,request()->tipo_instrucao)) == "D"  ? "selected":"" }} >Duplo Comando</option>
                                    <option value="S"  {{ strval(old('tipo_instrucao' ,request()->tipo_instrucao)) == "S"      ? "selected":"" }} >Solo</option>
                                    
                                    </select> 
                                        
                                    @if ($errors->has('tipo_instrucao'))
                                        <span class="invalid-feedback" role="alert">
                                            {{ $errors->first('tipo_instrucao') }}
                                        </span>
                                    @endif   
                                </div>                     
                            </div>
                            </div>
                        </div>

                        <div class="collapse" id="collapseExample3">
                            
                        </div>
                        

                        <div class="form-group row">
                            <label for="aerodromo_partida" class="col-md-4 col-form-label text-md-right">{{ __('Aerodromo de Partida') }}</label>

                            <div class="col-md-6">
                                <input id="aerodromo_partida" type="text" class="form-control{{ $errors->has('aerodromo_partida') ? ' is-invalid' : '' }}" name="aerodromo_partida" required autofocus>

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
                                <input id="aerodromo_chegada" type="text" class="form-control{{ $errors->has('aerodromo_chegada') ? ' is-invalid' : '' }}" name="aerodromo_chegada" required autofocus>

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
                                <input id="num_aterragens" type="number" class="form-control{{ $errors->has('num_aterragens') ? ' is-invalid' : '' }}" name="num_aterragens" required autofocus>

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
                                <input id="num_descolagens" type="number" class="form-control{{ $errors->has('num_descolagens') ? ' is-invalid' : '' }}" name="num_descolagens" required autofocus>

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
                                <input id="num_pessoas" type="number" class="form-control{{ $errors->has('num_pessoas') ? ' is-invalid' : '' }}" name="num_pessoas" required autofocus>

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
                                <input id="conta_horas_inicio" type="number" class="form-control{{ $errors->has('conta_horas_inicio') ? ' is-invalid' : '' }}" name="conta_horas_inicio" required autofocus>

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
                                <input id="conta_horas_fim" type="number" class="form-control{{ $errors->has('conta_horas_fim') ? ' is-invalid' : '' }}" name="conta_horas_fim" required autofocus>

                                @if ($errors->has('conta_horas_fim'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('conta_horas_fim') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="tempo_voo" class="col-md-4 col-form-label text-md-right">{{ __('Tempo Voo') }}</label>

                            <div class="col-md-6">
                                <input id="tempo_voo" type="number" class="form-control{{ $errors->has('tempo_voo') ? ' is-invalid' : '' }}" name="tempo_voo" required autofocus>

                                @if ($errors->has('tempo_voo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('tempo_voo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="preco_voo" class="col-md-4 col-form-label text-md-right">{{ __('Preço do Voo') }}</label>

                            <div class="col-md-6">
                                <input id="preco_voo" type="number" step="0.01" class="form-control{{ $errors->has('preco_voo') ? ' is-invalid' : '' }}" name="preco_voo" pattern="^\d*(\.\d{0,2})?$" required autofocus>

                                @if ($errors->has('preco_voo'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('preco_voo') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for ="modo_pagamento" class="col-md-4 col-form-label text-md-right">{{ __('Modo Pagamento') }}</label>
                            <div class="col-sm-6">
                                <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('modo_pagamento') ? ' is-invalid' : '' }}"  name="modo_pagamento" value="{{ strval(old('modo_pagamento',request()->modo_pagamento )) }}" >
                                <option value="N"  {{ strval(old('modo_pagamento' ,request()->modo_pagamento)) == "N"  ? "selected":"" }} >Numerário</option>
                                <option value="M"  {{ strval(old('modo_pagamento' ,request()->modo_pagamento)) == "M"      ? "selected":"" }} >Multibanco</option>
                                <option value="T"  {{ strval(old('modo_pagamento' ,request()->modo_pagamento)) == "T"      ? "selected":"" }} >Tranferência</option>
                                <option value="P"  {{ strval(old('modo_pagamento' ,request()->modo_pagamento)) == "P"      ? "selected":"" }} >Pacote de Horas</option>
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
                                <input id="num_recibo" type="text" class="form-control{{ $errors->has('num_recibo') ? ' is-invalid' : '' }}" name="num_recibo" required autofocus>

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
                                <input id="observacoes" type="text" class="form-control{{ $errors->has('observacoes') ? ' is-invalid' : '' }}" name="observacoes" required autofocus>

                                @if ($errors->has('observacoes'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('observacoes') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Adicionar Movimento') }}
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