<div class="form-group row align-items-center">
    <label for="nuit" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.saison.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="jour" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.debut') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="date" required class="form-control" name="debut" placeholder="{{ trans('admin.saison.columns.debut') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="jour" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.saison.columns.fin') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="date" required class="form-control" name="fin" placeholder="{{ trans('admin.saison.columns.debut') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chambre.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.chambre.columns.description') }}"></textarea>
    </div>
</div>

<input type="text" name="model_saison" value="excursion" style="display: none;">