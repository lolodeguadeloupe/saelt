<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="titre" placeholder="{{ trans('admin.vehicule-location.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="immatriculation" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.immatriculation') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control cutomer-format-control" name="immatriculation" placeholder="{{ trans('admin.vehicule-location.columns.immatriculation') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="marque" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.marque') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="marque_vehicule_titre" placeholder="{{ trans('admin.vehicule-location.columns.marque') }}" v-autocompletion="autocompleteMarque" :action="urlbase+'/admin/autocompletion/marque-vehicules'" :autokey="'id'" :label="'titre'" :inputkey="'marque_vehicule_id'" :inputlabel="'marque_vehicule_titre'">
        <input type="text" required class="form-control" name="marque_vehicule_id" style="display: none;">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="modele" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.modele') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="modele_vehicule_titre" placeholder="{{ trans('admin.vehicule-location.columns.modele') }}" v-autocompletion="autocompleteModele" :action="urlbase+'/admin/autocompletion/modele-vehicules'" :autokey="'id'" :label="'titre'" :inputkey="'modele_vehicule_id'" :inputlabel="'modele_vehicule_titre'">
        <input type="text" required class="form-control" name="modele_vehicule_id" style="display: none;">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="categorie_vehicule_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.categorie_vehicule') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="categorie_vehicule_titre" placeholder="{{ trans('admin.vehicule-location.columns.categorie_vehicule') }}" v-autocompletion="autocompleteCategorie" :action="urlbase+'/admin/autocompletion/categorie-vehicules'" :autokey="'id'" :label="'titre'" :inputkey="'categorie_vehicule_id'" :inputlabel="'categorie_vehicule_titre'">
        <input type="text" required class="form-control" name="categorie_vehicule_id" placeholder="{{ trans('admin.vehicule-location.columns.categorie_vehicule') }}" style="display: none;">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="status" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.status') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'1'" checked><label for="stauts_active">{{trans('admin.vehicule-location.columns.ouverte')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'0'"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.vehicule-location.columns.fermet')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="duration_min" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.duration_min') }} (jours)</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="numbre" min="1" required class="form-control" name="duration_min" placeholder="{{ trans('admin.vehicule-location.columns.duration_min') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="franchise" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.franchise') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" inputmode="decimal" step="any" required class="form-control with-unite" name="franchise" placeholder="{{ trans('admin.vehicule-location.columns.franchise') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="franchise_non_rachatable" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.franchise_non_rachatable') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" inputmode="decimal" step="any" required class="form-control with-unite" name="franchise_non_rachatable" placeholder="{{ trans('admin.vehicule-location.columns.franchise_non_rachatable') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="caution" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.caution') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" inputmode="decimal" step="any" required class="form-control with-unite" name="caution" placeholder="{{ trans('admin.vehicule-location.columns.caution') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="calendar" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.vehicule-location.columns.calendar') }}</button>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: white;">
        <figure class="figure-form" v-for="(_image, _index) in imageServeur" :key="_index+'serveur'">
            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" :alt="_image.name" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="deleteImageServeur($event,_image.resource_url,_index)">
                {{trans('admin.vehicule-location.actions.removeImage')}}
            </span>
        </figure>

        <!--  -->

        <figure class="figure-form" v-for="(_image,_index) in imageUploads" :key="_index+'local'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeUploadImage(_index)">
                {{trans('admin.vehicule-location.actions.removeImage')}}
            </span>
        </figure>
        <figure class="figure-form" @drop.prevent="imageUpload($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.vehicule-location.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="imageUpload">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <wysiwyg v-model="form.description" :config="mediaWysiwygConfig" />
    </div>
</div>


<input type="text" class="form-control" name="prestataire_id" placeholder="{{ trans('admin.vehicule-location.columns.prestataire_id') }}" style="display: none;">