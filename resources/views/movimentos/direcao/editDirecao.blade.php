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


