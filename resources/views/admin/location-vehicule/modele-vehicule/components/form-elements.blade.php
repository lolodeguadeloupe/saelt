<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.modele-vehicule.columns.titre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.modele-vehicule.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="descciption" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.modele-vehicule.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" name="description"></textarea>
        </div>
    </div>
</div>


