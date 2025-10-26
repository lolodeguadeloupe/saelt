<div class="form-group row align-items-center">
    <label for="nombre_place" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.nombre_place') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" min="0" name="nombre_place" placeholder="{{ trans('admin.vehicule-location-info-tech.columns.nombre_place') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="nombre_porte" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.nombre_porte') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="0" required class="form-control" name="nombre_porte" placeholder="{{ trans('admin.vehicule-location-info-tech.columns.nombre_porte') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_carburant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.type_carburant') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="type_carburant" checked :value="'Essence'"><label style="margin-bottom: 0; padding-left: 10px" for="essence">{{trans('admin.vehicule-location-info-tech.options-carburant.essence')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="type_carburant" :value="'Diesel'"><label for="diesel">{{trans('admin.vehicule-location-info-tech.options-carburant.diesel')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="type_carburant" :value="'Electrique'"><label for="electrique">{{trans('admin.vehicule-location-info-tech.options-carburant.electrique')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="nombre_vitesse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.nombre_vitesse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="1" required class="form-control" name="nombre_vitesse" placeholder="{{ trans('admin.vehicule-location-info-tech.columns.nombre_vitesse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="vitesse_maxi" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.vitesse_maxi') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="1" inputmode="decimal" step="any" class="form-control" name="vitesse_maxi" placeholder="{{ trans('admin.vehicule-location-info-tech.columns.vitesse_maxi') }}">
        <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; font-size: 18px;">Km/h</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="kilometrage" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.kilometrage') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="0" inputmode="decimal" step="any" class="form-control" name="kilometrage" placeholder="{{ trans('admin.vehicule-location-info-tech.columns.kilometrage') }}">
        <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; font-size: 18px;">Km</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_carburant" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.boite_vitesse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="boite_vitesse" checked :value="'Auto'"><label style="margin-bottom: 0; padding-left: 10px" for="auto">{{trans('admin.vehicule-location-info-tech.options-boite_vitesse.auto')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="boite_vitesse" :value="'Manuelle'"><label for="manuelle">{{trans('admin.vehicule-location-info-tech.options-boite_vitesse.manuelle')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="fiche_technique" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.vehicule-location-info-tech.columns.fiche_technique') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <figure class="figure-form" v-for="(_file,_index) in ficheTechnique" :key="_index+'fiche'">
            <embed :src="$isBase64(_file.fiche_technique)?_file.fiche_technique:`${_file.fiche_technique_b64}`" alt="File" style="height: 100%;width: 100%;">
            <span class="my-_btn-remove" @click.prevent="removeFile(_index)">
                {{trans('admin.vehicule-location-info-tech.actions.removeFile')}}
            </span>
            <input type="text" required class="form-control" name="fiche_technique" style="display: none;" :value="_file.fiche_technique">
        </figure>
        <figure v-if="!ficheTechnique.length > 0" class="figure-form" @drop.prevent="uploadFile($event,true)" @dragover.prevent>
            <span class="my-_btn-add">
                {{trans('admin.vehicule-location-info-tech.actions.uploadFile')}}
                <input type="file" multiple accept=".pdf" @change="uploadFile">
            </span>
        </figure>
    </div>
</div>

<input type="text" name="vehicule_id" style="display: none;">