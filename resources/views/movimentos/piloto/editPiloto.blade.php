<div class="form-group row">
    <label for ="is_piloto" class="col-md-4 col-form-label text-md-right">{{ __('Participou como') }}</label>
    <div class="col-sm-6">
        <select class="btn btn-xs btn-primary dropdown-toggle btn-block {{ $errors->has('is_piloto') ? ' is-invalid' : '' }}"  name="is_piloto" >
        
            @if($movimento->natureza=='I')
                @if($movimento->piloto_id==Auth::user()->id)
                    <option value="1"  selected >Piloto</option>
                    <option value="0"  >Instrutor</option>   
                @elseif ($movimento->instrutor_id==Auth::user()->id)
                    <option value="1"   >Piloto</option>
                    <option value="0" selected >Instrutor</option>  
                @endif              
            @else
                <option value="1"   >Piloto</option>
                @if($movimento->instrutor_id==Auth::user()->id)
                    <option value="0"  >Instrutor</option> 
                @endif
            @endif
        </select> 
        
        @if ($errors->has('is_piloto'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('is_piloto') }}
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
            <label for="nome_informal" class="col-md-4 col-form-label text-md-right">{{ __('Nome do outro Piloto') }}</label>

            <div class="col-md-6">
                <input id="nome_informal" type="text" class="form-control{{ $errors->has('nome_informal') ? ' is-invalid' : '' }}" name="nome_informal" 
                value=
                @if($movimento->natureza=='I')
                    @if($movimento->piloto_id==Auth::user()->id)
                        "{{$movimento->instrutores->nome_informal}}"       
                    @elseif ($movimento->instrutor_id==Auth::user()->id)
                        "{{$movimento->pilotos->nome_informal}}"       
                    @endif              
                @endif
                  >
                @if ($errors->has('nome_informal'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('nome_informal') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
    <br>
</div>