<div class="form-group row align-items-center">
    <label for="prix" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.frais-dossier.columns.prix') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" inputmode="decimal" step="any" min="0" required class="form-control with-unite" name="prix" required placeholder="{{ trans('admin.frais-dossier.columns.prix') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>