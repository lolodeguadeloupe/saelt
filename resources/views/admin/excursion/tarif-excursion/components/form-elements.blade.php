<div style="display: contents;" :class="tarif_form[0]?'_is_show' : '_is_hide'">

    <div class="form-group row align-items-center">
        <label for="saison_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-excursion.columns.saison') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <select required class="form-control" name="saison_id" v-if="readonly" @change="editTarifSaison($event,'{{ url('admin/tarif-excursions/'.$excursion->id) }}')">
                <option v-for="saison in saisons" :value="saison.id">@{{ saison.titre }} ( @{{saison.debut_format}} - @{{saison.fin_format}})</option>
            </select>
            <select required class="form-control" name="saison_id" v-if="!readonly">
                <option v-for="saison in saisons" :value="saison.id">@{{ saison.titre }} (@{{saison.debut_format}} - @{{saison.fin_format}})</option>
            </select>
            <div>
                <a data-range="2" data-parent="excursion" class="btn-primary form-btn-inline-new" :href="'{{url('admin/saisons?excursion='.$excursion->id)}}'"><i class="fa fa-arrow-circle-right pointer" style="font-size: 20px;"></i>
                    <p style="display: none !important;">{{trans('admin.saison.actions.create')}}</p>
                </a>
            </div>
            <!--<div v-if="!readonly" class="form-btn-inline-new" @click.prevent="createSaison($event,'{{url('admin/saisons/create')}}')"><i class="fa fa-plus"></i>
                <div class="info--btn">&nbsp;{{trans('admin.saison.actions.create')}}</div>
            </div>-->
        </div>
    </div>
</div>

<div style="display: flex;align-items: center;position: relative;" id="tarif_excursion_block" :class="tarif_form[1]?'_is_show' : '_is_hide'">
    <table class="table table-hover table-listing" style="margin: auto;">
        <thead>
            <tr>
                <th>{{trans('admin.tarif-excursion.columns.type_personne_id')}}</th>
                <th>{{ trans('admin.supplement-pension.columns.prix_achat') }}</th>
                <th>{{ trans('admin.supplement-pension.columns.marge') }}</th>
                <th>{{ trans('admin.supplement-pension.columns.prix_vente') }}</th>
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

<div class="form-group" style="margin-bottom: 0 !important">
    <input type="text" required class="form-control" name="excursion_id" :value="excursion.id" style="display: none;">
</div>