<div class="form-group row">
    <label for ="nome_informal_piloto" class="col-md-4 col-form-label text-md-right">{{ __('Nome Piloto') }}</label>
    <div class="col-sm-6">
        <input id="nome_informal_piloto" type="text" class="form-control{{ $errors->has('nome_informal_piloto') ? ' is-invalid' : '' }}" name="nome_informal_piloto" value="{{$movimento->pilotos->nome_informal}}">
        
        @if ($errors->has('nome_informal_piloto'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('nome_informal_piloto') }}
            </span>
        @endif   
    </div>                     
</div>

<div class="form-group row">
    <label for ="natureza" class="col-md-4 col-form-label text-md-right">{{ __('') }}</label>
    <div class="col-sm-6">                               
            <a class="btn btn-light btn-block" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
            Se escolheu Voo instrução clique aqui
            </a>                            
    </div>
</div>

<div class="collapse" id="collapseOne">
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
        <div class="form-group row">
            <label for="nome_informal_instrutor" class="col-md-4 col-form-label text-md-right">{{ __('Nome Instrutor') }}</label>

            <div class="col-md-6">
                <input id="nome_informal_instrutor" type="text" class="form-control{{ $errors->has('nome_informal_instrutor') ? ' is-invalid' : '' }}" name="nome_informal_instrutor" 
                value=
                @if($movimento->natureza=='I')
                        "{{$movimento->instrutores->nome_informal}}"        
                @endif
                  >
                @if ($errors->has('nome_informal_instrutor'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome_informal_instrutor') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <br>
</div>

<div class="form-group row">
    <label for ="confirmado" class="col-md-4 col-form-label text-md-right">{{ __('Movimento') }}</label>
        <div class="col-sm-6">
            <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('confirmado') ? ' is-invalid' : '' }}"  name="confirmado" value="{{ strval(old('confirmado',request()->confirmado )) }}" >
            <option value="0"  {{ strval(old('confirmado' ,request()->confirmado)) == "0"  ? "selected":"" }} >Não Confirmado</option>
            <option value="1"  {{ strval(old('confirmado' ,request()->confirmado)) == "1"      ? "selected":"" }} >Confirmado</option>
            
            </select> 
            
            @if ($errors->has('confirmado'))
                <span class="invalid-feedback" role="alert">
                    {{ $errors->first('confirmado') }}
                </span>
            @endif   
        </div>                     
</div>

