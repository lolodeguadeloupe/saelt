<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.lieu-transfert.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.lieu-transfert.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="adresse" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.lieu-transfert.columns.adresse') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="adresse" placeholder="{{ trans('admin.lieu-transfert.columns.adresse') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.lieu-transfert.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="ville_id" style="display: none;">
        <input type="text" name="ville_name" class="form-control" placeholder="{{ trans('admin.lieu-transfert.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
    </div>
</div>