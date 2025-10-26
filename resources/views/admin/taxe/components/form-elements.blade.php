<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.frais_applique') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="row form-control h-auto d-flex ml-0">
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="tva_transfert" type="radio" name="sigle" @click="changeTva('tva_transfert')" :value="'tva_transfert'">
                <label class="form-check-label d-inline" for="tva_transfert">
                    {{ trans('admin.taxe.columns.tva_transfert') }}
                </label>
            </div>
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="tva_excursion" type="radio" name="sigle" @click="changeTva('tva_excursion')" :value="'tva_excursion'">
                <label class="form-check-label d-inline" for="tva_excursion">
                    {{ trans('admin.taxe.columns.tva_excursion') }}
                </label>
            </div>
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="tva_hebergement_pack" type="radio" name="sigle" @click="changeTva('tva_hebergement_pack')" :value="'tva_hebergement_pack'">
                <label class="form-check-label d-inline" for="tva_hebergement_pack">
                    {{ trans('admin.taxe.columns.tva_hebergement_pack') }}
                </label>
            </div>
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="tva_location" type="radio" name="sigle" @click="changeTva('tva_location')" :value="'tva_location'">
                <label class="form-check-label d-inline" for="tva_location">
                    {{ trans('admin.taxe.columns.tva_location') }}
                </label>
            </div>
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="tva_billetterie" type="radio" name="sigle" @click="changeTva('tva_billetterie')" :value="'tva_billetterie'">
                <label class="form-check-label d-inline" for="tva_billetterie">
                    {{ trans('admin.taxe.columns.tva_billetterie') }}
                </label>
            </div>
            <div class="form-control-_chekbox col-auto">
                <input class="form-control" custom id="autres" type="radio" name="sigle" @click="changeTva('autres')" :value="'autres'">
                <label class="form-check-label d-inline" for="tva_autre">
                    {{ trans('admin.taxe.columns.tva_autre') }}
                </label>
            </div>
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input v-if="TVA=='tva_transfert'" type="text" readonly required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="'{{trans('admin.taxe.columns.tva_transfert')}}'">
        <input v-if="TVA=='tva_excursion'" type="text" readonly required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="'{{trans('admin.taxe.columns.tva_excursion')}}'">
        <input v-if="TVA=='tva_location'" type="text" readonly required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="'{{trans('admin.taxe.columns.tva_location')}}'">
        <input v-if="TVA=='tva_billetterie'" type="text" readonly required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="'{{trans('admin.taxe.columns.tva_billetterie')}}'">
        <input v-if="TVA=='tva_hebergement_pack'" type="text" readonly required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="'{{trans('admin.taxe.columns.tva_hebergement_pack')}}'">
        <input v-if="TVA=='autres'" type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.taxe.columns.titre') }}" :value="EDIT_TVA">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.taxe_applique') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="taxe_appliquer" :value="'1'" checked @input="checkTaxeAppliquer($event)" id="stauts_desactive"><label style="margin-bottom: 0; padding-left: 10px" for="stauts_desactive">{{trans('admin.taxe.columns.taxe_applique_prix')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="taxe_appliquer" :value="'0'" @input="checkTaxeAppliquer($event)" id="stauts_active"><label for="stauts_active">{{trans('admin.taxe.columns.taxe_applique_pourcent')}}</label></div>
    </div>
</div>

<div :class="!taxe_prix?'_is_show form-group row align-items-center':'_is_hide'">
    <label for="valeur_pourcent" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.valeur_pourcent') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input min="0" type="number" inputmode="decimal" step="any" required class="form-control with-unite" name="valeur_pourcent" value="0.0" placeholder="{{ trans('admin.taxe.columns.valeur_pourcent') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
    </div>
</div>

<div :class="taxe_prix?'_is_show form-group row align-items-center':'_is_hide'">
    <label for="valeur_devises" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.valeur_devises') }} </label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input min="0" type="number" inputmode="decimal" step="any" required class="form-control with-unite" name="valeur_devises" value="0" placeholder="{{ trans('admin.taxe.columns.valeur_devises') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>


<div class="form-group row align-items-center" v-if="TVA==false">
    <label for="descciption" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.taxe.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <textarea class="form-control" name="description"></textarea>
        </div>
    </div>
</div>