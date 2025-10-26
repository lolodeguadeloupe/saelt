<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.app-config.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="nom" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.nom') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="nom" placeholder="{{ trans('admin.app-config.columns.nom') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="adresse" placeholder="{{ trans('admin.app-config.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="site_web" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.site_web') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="site_web" placeholder="{{ trans('admin.app-config.columns.site_web') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="telephone" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.telephone') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="telephone" placeholder="{{ trans('admin.app-config.columns.telephone') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.app-config.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.logo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                {{trans('admin.app-config.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
        </figure>
        <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.app-config.actions.uploadLogo')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
            </span>
        </figure>
    </div>
</div>


