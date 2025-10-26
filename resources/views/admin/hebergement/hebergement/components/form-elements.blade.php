<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.hebergement.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_hebergement_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.type_hebergement') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <select required class="form-control" name="type_hebergement_id">
            <option value="">-- {{ trans('admin.hebergement.columns.type_hebergement') }} --</option>
            <option v-for="type in types" :value="type.id">@{{ type.name }}</option>
        </select>
        <div class="form-btn-inline-new" @click.prevent="createTypeHeb($event,'{{url('admin/type-hebergements/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.type-hebergement.actions.create')}}</div>
        </div>
    </div>
</div>

<div v-if="false" class="form-group row align-items-center">
    <label for="duration_min" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.duration_min') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" name="duration_min" placeholder="{{ trans('admin.hebergement.columns.duration_min') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="adresse" placeholder="{{ trans('admin.hebergement.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.prestataire.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ile_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.ile_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ile_id" style="display: none;">
        <input type="text" name="ile_name" class="form-control" placeholder="{{ trans('admin.hebergement.columns.ile_id') }}" v-autocompletion="autocompleteIle" :action="urlbase+'/admin/autocompletion/iles'" :autokey="'id'" :label="'name'" :inputkey="'ile_id'" :inputlabel="'ile_name'">
    </div>
</div>


<!--
<div class="form-group row align-items-center">
    <label for="heure_ouverture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.heure_ouverture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" required class="form-control" name="heure_ouverture" placeholder="{{ trans('admin.hebergement.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="heure_fermeture" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.heure_fermeture') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="time" required class="form-control" name="heure_fermeture" placeholder="{{ trans('admin.hebergement.columns.adresse') }}">
    </div>
</div>
-->

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.status') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'1'" checked><label for="stauts_active">{{trans('admin.hebergement.columns.ouverte')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'0'"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.hebergement.columns.fermet')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="chambre_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.taxe') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect v-model="form.taxes" :options="taxes" label="titre" track-by="id" placeholder="..." :limit="5" :multiple="true">
        </multiselect>
        <div class="form-btn-inline-new" @click.prevent="createTaxe($event,'{{ url('admin/taxes/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.taxe.actions.create')}}</div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="caution" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.caution') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input min="0" type="number" inputmode="decimal" step="any" class="form-control with-unite" name="caution" value="0.0" placeholder="{{ trans('admin.hebergement.columns.caution') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="etoil" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.etoil') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" class="form-control" name="etoil" placeholder="{{ trans('admin.hebergement.columns.etoil') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.hebergement.columns.calendar') }}</button>
    </div>
</div>


<!--<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.hebergement.columns.description') }}"></textarea>
    </div>
</div>
-->

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" rows="5"></textarea>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="fond_image" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.fond_image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_image,_index) in fond_image" :key="_index+'fond_image'">
            <img :src="$isBase64(_image)?_image: `${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeFondImage(_index)">
                {{trans('admin.hebergement.actions.removeImage')}}
            </span>
            <input type="text" required class="form-control" name="fond_image" style="display: none;" :value="_image">
        </figure>
        <figure v-if="fond_image.length == 0" class="figure-form" @drop.prevent="uploadFondImage($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.hebergement.actions.uploadFondImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadFondImage">
            </span>
        </figure>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: white;">
        <figure class="figure-form" v-for="(_image, _index) in imageServeur" :key="_index+'serveur'">
            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" :alt="_image.name" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="deleteImageServeur($event,_image.resource_url,_index)">
                {{trans('admin.hebergement.actions.removeImage')}}
            </span>
        </figure>

        <!--  -->

        <figure class="figure-form" v-for="(_image,_index) in imageUploads" :key="_index+'local'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeUploadImage(_index)">
                {{trans('admin.hebergement.actions.removeImage')}}
            </span>
        </figure>
        <figure class="figure-form" @drop.prevent="imageUpload($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.hebergement.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" id="" @change="imageUpload">
            </span>
        </figure>
    </div>
</div>

<input type="text" style="display: none;" class="form-control" name="prestataire_id" placeholder="{{ trans('admin.hebergement.columns.prestataire_id') }}">