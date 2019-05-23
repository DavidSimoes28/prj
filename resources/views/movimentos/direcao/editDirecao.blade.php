<div class="form-group row">
    <label for ="piloto_id" class="col-md-4 col-form-label text-md-right">{{ __('Participou como') }}</label>
    <div class="col-sm-6">
        <input id="piloto_id" type="text" class="form-control{{ $errors->has('piloto_id') ? ' is-invalid' : '' }}" name="piloto_id" >
        
        @if ($errors->has('is_piloto'))
            <span class="invalid-feedback" role="alert">
                {{ $errors->first('is_piloto') }}
            </span>
        @endif   
    </div>                     
</div>

<div class="form-group row">
    <label for="instrutor_id" class="col-md-4 col-form-label text-md-right">{{ __('Nome do outro Piloto') }}</label>

    <div class="col-md-6">
        <input id="instrutor_id" type="text" class="form-control{{ $errors->has('instrutor_id') ? ' is-invalid' : '' }}" name="instrutor_id" >

        @if ($errors->has('instrutor_id'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('instrutor_id') }}</strong>
            </span>
        @endif
    </div>
</div>

<div class="form-group row">
    <label for ="confirmado" class="col-md-4 col-form-label text-md-right">{{ __('Tipo de Instrução') }}</label>
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


<!--   FALTA A CONFIRMAÇÃO DO VOO   -->