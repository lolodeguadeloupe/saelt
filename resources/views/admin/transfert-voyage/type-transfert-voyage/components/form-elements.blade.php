<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-transfert-voyage.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" custom name="titre" placeholder="{{ trans('admin.type-transfert-voyage.columns.titre') }}">
    </div>
</div>
 
<div class="form-group row align-items-center" >
    <label for="nombre_min" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-transfert-voyage.columns.nombre_min') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="1" required class="form-control" name="nombre_min" placeholder="{{ trans('admin.type-transfert-voyage.columns.nombre_min') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="nombre_max" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-transfert-voyage.columns.nombre_max') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" min="1" class="form-control" name="nombre_max" placeholder="{{ trans('admin.type-transfert-voyage.columns.nombre_max') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-transfert-voyage.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <wysiwyg v-model="form.description" name="description" :config="mediaWysiwygConfig"></wysiwyg>
        </div>
    </div>
</div>

<input type="text" class="form-control" name="prestataire_id" placeholder="{{ trans('admin.vehicule-transfert-voyage.columns.prestataire_id') }}" style="display: none;">