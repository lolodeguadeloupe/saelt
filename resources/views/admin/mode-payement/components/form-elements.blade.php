<div class="form-group row align-items-center">
    <label for="debut" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select name="titre" required class="form-control" custom="" @change="iconPaiement($event,paiementmode)">
            <option value="">--- {{ trans('admin.mode-payement.columns.titre') }} ---</option>
            <option :value="item.titre" v-for="item of paiementmode">@{{item.titre}}</option>
        </select>
    </div>
</div>

<div class="form-group row align-items-center"> 
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.icon') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <span class="icon-upload-form" :style="'background-image: url(\''+(icon.length > 0 ? ($isBase64(icon[0])?icon[0]:`${urlasset}/${icon[0]}`) : '{{asset('images/payement.png')}}')+'\');'" @drop.prevent="uploadIcon($event,true)" @dragover.prevent>
            <input type="text" class="form-control" name="icon" style="display: none;" :value="icon.length > 0 ? icon[0] : ''">
            <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadIcon">
        </span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="base_url_test" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.base_url_test') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="base_url_test" required class="form-control" custom="" placeholder="{{ trans('admin.mode-payement.columns.config.base_url_test') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="base_url_prod" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.base_url_prod') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="base_url_prod" required class="form-control" custom="" placeholder="{{ trans('admin.mode-payement.columns.config.base_url_prod') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="key_test" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.key_test') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="key_test" class="form-control" custom="" placeholder="{{ trans('admin.mode-payement.columns.config.key_test') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="key_prod" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.key_prod') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="key_prod" class="form-control" custom="" placeholder="{{ trans('admin.mode-payement.columns.config.key_prod') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="api_version" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.api_version') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="api_version" maxlength="4" class="form-control" custom="" placeholder="{{ trans('admin.mode-payement.columns.config.api_version') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="mode" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.mode-payement.columns.config.mode') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select name="mode" class="form-control">
            <option value="0">Mode test</option>
            <option value="1">Mode production</option>
        </select>
    </div>
</div>