<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.ville.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.code_postal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="code_postal" placeholder="{{ trans('admin.ville.columns.code_postal') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="pays_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.pays_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="pays_id" style="display: none;">
        <input type="text" name="pays_name" class="form-control" placeholder="{{ trans('admin.vehicule-location.columns.pays_id') }}" v-autocompletion="autocompletePays" :action="urlbase+'/admin/autocompletion/pays'" :autokey="'id'" :label="'nom'" :inputkey="'pays_id'" :inputlabel="'pays_name'">
    </div>
</div>