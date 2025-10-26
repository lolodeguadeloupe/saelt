<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.taxe_applique') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="taxe_appliquer" :value="'1'" checked @input="checkTaxeAppliquer($event)"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.taxe.columns.taxe_applique_prix')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="taxe_appliquer" :value="'0'" @input="checkTaxeAppliquer($event)"><label for="stauts_active">{{trans('admin.taxe.columns.taxe_applique_pourcent')}}</label></div>
    </div>
</div>

<div :class="!taxe_prix?'_is_show form-group row align-items-center':'_is_hide'">
    <label for="valeur_pourcent" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.valeur_pourcent') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input min="0" type="number" inputmode="decimal" step="any" required class="form-control" name="valeur_pourcent" value="0.0" placeholder="{{ trans('admin.taxe.columns.valeur_pourcent') }}">
        <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
    </div>
</div>

<div :class="taxe_prix?'_is_show form-group row align-items-center':'_is_hide'">
    <label for="valeur_devises" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.valeur_devises') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input min="0" type="number" inputmode="decimal" step="any" required class="form-control" name="valeur_devises" value="0" placeholder="{{ trans('admin.taxe.columns.valeur_devises') }}">
        <span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="descciption" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" name="description"></textarea>
        </div>
    </div>
</div>