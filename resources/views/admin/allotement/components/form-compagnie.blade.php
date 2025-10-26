<div class="form-group row align-items-center">
    <label for="nom" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.nom') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="nom" placeholder="{{ trans('admin.compagnie-transport.columns.nom') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.email') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.compagnie-transport.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.phone') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" data-ctr="phone" class="form-control" name="phone" placeholder="{{ trans('admin.compagnie-transport.columns.phone') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_transport" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.type_transport') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" readonly required class="form-control" name="type_transport" value="Aérien " placeholder="{{ trans('admin.compagnie-transport.columns.type_transport') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="adresse" placeholder="{{ trans('admin.compagnie-transport.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" required name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.prestataire.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="heure_ouverture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.heure_ouverture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_ouverture" placeholder="{{ trans('admin.compagnie-transport.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_fermeture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.heure_fermeture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" class="form-control" name="heure_fermeture" placeholder="{{ trans('admin.compagnie-transport.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.logo') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'">
            <img :src="_image" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                {{trans('admin.compagnie-transport.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
        </figure>
        <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.compagnie-transport.actions.uploadLogo')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
            </span>
        </figure>
    </div>
</div>