<div class="form-group row align-items-center">
    <label for="type" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.type') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required name="original_id" style="display: none;">
        <input type="text" required name="type" class="form-control" placeholder="{{ trans('admin.type-personne.columns.type') }}" v-autocompletion="autocompleteType" :action="urlbase+'/admin/autocompletion/type-personnes'" :autokey="'id'" :label="'type'" :inputkey="'original_id'" :inputlabel="'type'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.age') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="age" placeholder="{{ trans('admin.type-personne.columns.age') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3"></textarea>
    </div>
</div>