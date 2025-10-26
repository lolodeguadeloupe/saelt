<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.agence-location.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="code_agence" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.code_agence') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="code_agence" placeholder="{{ trans('admin.agence-location.columns.code_agence') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="adresse" placeholder="{{ trans('admin.agence-location.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.phone') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="phone" name="phone" placeholder="{{ trans('admin.agence-location.columns.phone') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.agence-location.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.agence-location.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_ouverture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.heure_ouverture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_ouverture" placeholder="{{ trans('admin.agence-location.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_fermeture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.heure_fermeture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_fermeture" placeholder="{{ trans('admin.agence-location.columns.adresse') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.logo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                {{trans('admin.agence-location.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
        </figure>
        <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.agence-location.actions.uploadLogo')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="calendar" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.agence-location.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.agence-location.columns.calendar') }}</button>
    </div>
</div>