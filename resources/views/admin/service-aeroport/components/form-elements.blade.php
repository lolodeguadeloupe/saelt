<div class="form-group row align-items-center">
    <label for="code_service" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.code_service') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="code_service" placeholder="{{ trans('admin.service-aeroport.columns.code_service') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.service-aeroport.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="adresse" placeholder="{{ trans('admin.service-aeroport.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.phone') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="phone" name="phone" placeholder="{{ trans('admin.service-aeroport.columns.phone') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.service-aeroport.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.service-aeroport.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.logo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                {{trans('admin.service-aeroport.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
        </figure>
        <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.service-aeroport.actions.uploadLogo')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="calendar" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.service-aeroport.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.service-aeroport.columns.calendar') }}</button>
    </div>
</div>