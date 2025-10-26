<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.type-chambre.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center"> 
    <label for="nombre_chambre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.nombre_chambre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" name="nombre_chambre" placeholder="{{ trans('admin.type-chambre.columns.nombre_chambre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="nombre_adulte_max" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.nombre_adulte_max') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" class="form-control" name="nombre_adulte_max" placeholder="{{ trans('admin.type-chambre.columns.nombre_adulte_max') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="capacite" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.capacite') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" name="capacite" placeholder="{{ trans('admin.type-chambre.columns.capacite') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="prix_vente" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.cout_supplementaire') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control with-unite" name="cout_supplementaire" placeholder="{{ trans('admin.type-chambre.columns.cout_supplementaire') }}" :value="0.0">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="capacite" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.formule') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select name="formule" class="form-control">
            <option value="0">Hébergement seul</option>
            <option v-for="item_formule of formules" :value="item_formule.id">@{{item_formule.value}}</option>
        </select>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" rows="5"></textarea>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.status') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'1'" checked><label for="stauts_active">{{trans('admin.type-chambre.columns.ouverte')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="status" :value="'0'"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.type-chambre.columns.fermet')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.calendar') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <button type="button" class="btn btn-primary" @click.prevent="calendar"><i class="fa fa-calendar"></i>&nbsp;{{ trans('admin.type-chambre.columns.calendar') }}</button>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-chambre.columns.image') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: white;">
        <figure class="figure-form" v-for="(_image, _index) in imageServeur" :key="_index+'serveur'">
            <img :src="$isBase64(_image.name)?_image.name:`${urlasset}/${_image.name}`" :alt="_image.name" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="deleteImageServeur($event,_image.resource_url,_index)">
                {{trans('admin.type-chambre.actions.removeImage')}}
            </span>
        </figure>

        <!--  -->

        <figure class="figure-form" v-for="(_image,_index) in imageUploads" :key="_index+'local'">
            <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
            <span class="my-_btn-remove" @click.prevent="removeUploadImage(_index)">
                {{trans('admin.type-chambre.actions.removeImage')}}
            </span>
        </figure>
        <figure class="figure-form" @drop.prevent="imageUpload($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.type-chambre.actions.uploadImage')}}
                <input type="file" multiple accept=".jpg, .jpeg, .png" id="" @change="imageUpload">
            </span>
        </figure>
    </div>
</div>

<input type="text" style="display: none;" required class="form-control" name="hebergement_id" placeholder="{{ trans('admin.type-chambre.columns.hebergement_id') }}">