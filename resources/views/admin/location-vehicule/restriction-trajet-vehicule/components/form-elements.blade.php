<div class="form-group row align-items-center">
    <label for="agence_location_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.restriction-trajet-vehicule.columns.agence_location_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="agence_location_depart" style="display: none;">
        <input type="text" required name="agence_location_depart_titre" class="form-control" placeholder="{{ trans('admin.restriction-trajet-vehicule.columns.agence_location_depart') }}" v-autocompletion="autocompleteAgenceLocation" :action="urlbase+'/admin/autocompletion/agence-locations'" :autokey="'id'" :label="'name'" :inputkey="'agence_location_depart'" :inputlabel="'agence_location_depart_titre'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="agence_location_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.restriction-trajet-vehicule.columns.agence_location_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="agence_location_arrive" style="display: none;">
        <input type="text" required name="agence_location_arrive_titre" class="form-control" placeholder="{{ trans('admin.restriction-trajet-vehicule.columns.agence_location_arrive') }}" v-autocompletion="autocompleteAgenceLocation" :action="urlbase+'/admin/autocompletion/agence-locations'" :autokey="'id'" :label="'name'" :inputkey="'agence_location_arrive'" :inputlabel="'agence_location_arrive_titre'">
    </div>
</div>

<div class="form-group row align-items-center" >
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.restriction-trajet-vehicule.columns.titre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="titre" placeholder="{{ trans('admin.restriction-trajet-vehicule.columns.titre') }}">
    </div>
</div>

