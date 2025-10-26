<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.prestataire.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.phone') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="phone" name="phone" placeholder="{{ trans('admin.prestataire.columns.phone') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" data-ctr="email" class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.prestataire.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="second_email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.second_email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" data-ctr="email" class="form-control" data-ctr="email" name="second_email" placeholder="{{ trans('admin.prestataire.columns.second_email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="adresse" placeholder="{{ trans('admin.prestataire.columns.adresse') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" required name="ville_name" class="form-control" placeholder="{{ trans('admin.prestataire.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_ouverture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.heure_ouverture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_ouverture" placeholder="{{ trans('admin.prestataire.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_fermeture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.heure_fermeture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_fermeture" placeholder="{{ trans('admin.prestataire.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.logo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                {{trans('admin.prestataire.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
        </figure>
        <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.prestataire.actions.uploadLogo')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
            </span>
        </figure>
    </div>
</div>