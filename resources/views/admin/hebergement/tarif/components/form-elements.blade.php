<div class="form-group row align-items-center d-none">
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="titre" placeholder="{{ trans('admin.tarif.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_chambre_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.chambre_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="type_chambre_id" @change="checkPersonneBaseType">
            <option value="">-- sélectionnez le type de chambre --</option>
            <option v-for="_typeChambre of typeChambre" :value="_typeChambre.id">@{{ _typeChambre.name }}</option>
        </select>
        <a data-range="2" data-parent="hebergement" class="h-style-none" style="position: absolute; left: 100%; top: 0; width:fit-content;height: 100%;display: flex;align-items: center;" :href="urlchambre"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
            <p style="display: none;">{{trans('admin.type-chambre.title')}}</p>
        </a>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="base_type_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.base_type_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="base_type_id" @change="checkPersonneSupp">
            <option value="">-- sélectionnez le type de chambre --</option>
            <option v-for="basetype in basetypes" :value="basetype.id">@{{ basetype.titre }}</option>
        </select>
        <a data-range="2" data-parent="hebergement" class="h-style-none" style="position: absolute; left: 100%; top: 0; width:fit-content;height: 100%;display: flex;align-items: center;" :href="urlbasetype"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
            <p style="display: none;">{{ trans('admin.tarif.columns.base_type_id') }}</p>
        </a>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="type_personne_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.saison_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="saison_id" @change="checkMaxDays($event.target.value)">
            <option value="">-- sélectionnez la saisonnalité --</option>
            <option v-for="saison in saisons" :value="saison.id">@{{ saison.titre }} (@{{saison.debut_format}} au @{{saison.fin_format}})</option>
        </select>
        <a data-range="2" data-parent="hebergement" class="h-style-none" style="position: absolute; left: 100%; top: 0; width:fit-content;height: 100%;display: flex;align-items: center;" :href="urlsaison"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
            <p style="display: none;">{{trans('admin.saison.title')}}</p>
        </a>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="jour_min" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.jour_min') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="form-control display-grid-mi-colonne">
            <input type="number" class="form-control" name="jour_min" placeholder="{{ trans('admin.tarif.columns.jour_min') }}">
            <span>{{ trans('admin.tarif.columns.nuit_min') }} </span>
            <input type="number" class="form-control" name="nuit_min" placeholder="{{ trans('admin.tarif.columns.nuit_min') }}">
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="jour_max" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.jour_max') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="form-control display-grid-mi-colonne">
            <input type="number" class="form-control" name="jour_max" placeholder="{{ trans('admin.tarif.columns.jour_max') }}">
            <span>{{ trans('admin.tarif.columns.nuit_max') }} </span>
            <input type="number" class="form-control" name="nuit_max" placeholder="{{ trans('admin.tarif.columns.nuit_max') }}">
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.tarif.columns.description') }}"></textarea>
    </div>
</div>
<!--
<div class="form-group row align-items-center">
    <label for="taxe_active" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.taxe_active') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: grid; grid-template-columns: 35px calc(90% - 35px); grid-gap: 10%">
        <input type="checkbox" @input="changeTaxe($event)" value="false" name="taxe_active" class="form-control" style="position: initial !important;">
        <input :class="taxe?'_is_show':'_is_hide'" inputmode="decimal" step="any" value="0.0" type="number" value="false" name="taxe" class="form-control">
        <span :class="taxe?'_is_show':'_is_hide'" style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
    </div>
</div>
-->
<div class="form-group row align-items-center" style="margin-top: 35px;">
    <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.vol') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative" style="display: flex;">
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="condition-vol" :value="'0'" checked @input="checkVoyageVol($event)"><label style="margin-bottom: 0; padding-left: 10px">{{trans('admin.hebergement-vol.columns.sans-vol')}}</label></div>
        <div class="form-control-_chekbox"><input type="radio" class="form-control" name="condition-vol" :value="'1'" @input="checkVoyageVol($event)"><label>{{trans('admin.hebergement-vol.columns.avec-vol')}}</label></div>
    </div>
</div>

<div class="form-group row align-items-center" style="width: 100%;">
    <label for="tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.tarif') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: #f3f3f3; padding: 10px; margin: 10px;" id="tarif-hebergement-type-personne">
        <div v-if="typePersonnes.length == 0">
            <a data-range="2" data-parent="hebergement" class="btn btn-primary btn-sm pull-right m-b-0" style="margin-bottom: 5px;" :href="'{{url('admin/type-personnes-prod?heb='.$hebergement->id)}}'"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
                <p>{{ trans('admin.type-personne.actions.create') }}</p>
            </a>
        </div>
        <table v-if="typePersonnes.length > 0" class="table table-hover table-listing" style="margin: auto;">
            <thead>
                <tr>
                    <th>{{ trans('admin.tarif.columns.type_personne') }}</th>
                    <th>{{ trans('admin.tarif.columns.prix_achat') }}</th>
                    <th>{{ trans('admin.tarif.columns.marge') }}</th>
                    <th>{{ trans('admin.tarif.columns.prix_vente') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(type_personne , _index) in typePersonnes">
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="text" class="form-control" readonly :value="type_personne.type">
                            <input type="text" :name="'type_personne_id_'+_index" required class="form-control" style="display: none;" :value="type_personne.id">
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'prix_achat_'+_index" required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'marge_'+_index" required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_vente_'+_index" readonly required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<div class="form-group row align-items-center" style="width: 100%;" v-if="has_supp_tarif">
    <label for="tarif-supp" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif.columns.tarif_supp') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" style="background-color: #f3f3f3; padding: 10px; margin: 10px;" id="tarif-hebergement-type-personne-supp">
        <table v-if="typePersonnes.length > 0" class="table table-hover table-listing" style="margin: auto;">
            <thead>
                <tr>
                    <th>{{ trans('admin.tarif.columns.type_personne') }}</th>
                    <th>{{ trans('admin.tarif.columns.prix_achat') }}</th>
                    <th>{{ trans('admin.tarif.columns.marge') }}</th>
                    <th>{{ trans('admin.tarif.columns.prix_vente') }}</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(type_personne , _index) in typePersonnes">
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="text" class="form-control" readonly :value="type_personne.type">
                            <input type="text" :name="'type_personne_id_'+_index" required class="form-control" style="display: none;" :value="type_personne.id">
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_supp_'+_index)" :name="'prix_achat_supp_'+_index" required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_supp_'+_index)" :name="'marge_supp_'+_index" required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_vente_supp_'+_index" readonly required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<input type="text" name="hebergement_id" :value="idheb" style="display: none;">