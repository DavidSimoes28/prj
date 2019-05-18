@if(Auth::user()->isAdmin())
    <div class="form-group row">
        <label for="ativo" class="col-md-4 col-form-label text-md-right">{{ __('Ativo') }}</label>

        <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('ativo') ? ' is-invalid' : '' }}" name="ativo" value="0" {{ intval(old('ativo',$user->ativo)) == 0?"checked":"" }}> Não <br>
            <input type="radio" class="form{{ $errors->has('ativo') ? ' is-invalid' : '' }}" name="ativo" value="1" {{ intval(old('ativo',$user->ativo)) == 1?"checked":"" }}> Sim <br>
            @if ($errors->has('ativo'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('ativo') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="form-group row">
        <label for="quota_paga" class="col-md-4 col-form-label text-md-right">{{ __('Quota Paga') }}</label>

        <div class="col-md-6">
        <input type="radio" class="form{{ $errors->has('quota_paga') ? ' is-invalid' : '' }}" name="quota_paga" value="0" {{ intval(old('quota_paga',$user->quota_paga)) == 0?"checked":"" }}> Não <br>
            <input type="radio" class="form{{ $errors->has('quota_paga') ? ' is-invalid' : '' }}" name="quota_paga" value="1" {{ intval(old('quota_paga',$user->quota_paga)) == 1?"checked":"" }}> Sim <br>
            @if ($errors->has('quota_paga'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('quota_paga') }}</strong>
                </span>
            @endif
        </div>
    </div>
@endif
<div class="form-group row">
    <label for="direcao" class="col-md-4 col-form-label text-md-right">{{ __('Direcao') }}</label>
    <div class="col-md-6">
    <input type="radio" class="form{{ $errors->has('direcao') ? ' is-invalid' : '' }}" name="direcao" value="0" {{ intval(old('direcao',$user->direcao)) == 0?"checked":"" }}> Não <br>
        <input type="radio" class="form{{ $errors->has('direcao') ? ' is-invalid' : '' }}" name="direcao" value="1" {{ intval(old('direcao',$user->direcao)) == 1?"checked":"" }}> Sim <br>
        @if ($errors->has('direcao'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('direcao') }}</strong>
            </span>
        @endif
    </div>
</div>