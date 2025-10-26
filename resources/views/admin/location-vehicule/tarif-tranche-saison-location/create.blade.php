                <div class="card">
                    <form class="form-horizontal form-create" id="create-tarif" method="post"  @submit.prevent="storeTarif($event,'create_tarif')" :action="action" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.tarif-tranche-saison-location.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_tarif')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="saisons_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.saison') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" name="vehicule_location_id" required style="display: none;" :value="vehicule.id">
                                    <input type="text" name="saisons_id" required style="display: none;">
                                    <input type="text" class="form-control" required name="saisons_titre" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.saison') }}" v-autocompletion="autocompleteSaison" :action="urlbase+'/admin/autocompletion/saisonnalites?location={{$vehicule->id}}'" :autokey="'id'" :label="'titre'" :inputkey="'saisons_id'" :inputlabel="'saisons_titre'">
                                </div>
                            </div>
                            <div class="form-group row align-items-center">
                                <label for="tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.tarif') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <table v-if="state_tranche_saison.length > 0" class="my-_list-table" style="width: 100%;margin-left: 0;">
                                        <thead>
                                            <tr>
                                                <th class="my-_list-table-title" style="min-width: 230px;">{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }} (Jours)</th>
                                                <th class="my-_list-table-title">{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}</th>
                                                <th class="my-_list-table-title">{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}</th>
                                                <th class="my-_list-table-title">{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(_tranche,index) in state_tranche_saison">
                                                <td>
                                                    <input type="text" :name="'tranche_saison_id_'+index" required style="display: none;" :value="_tranche.id">
                                                    <input type="text" readonly required name="tranche_saison_titre" class="form-control" :value="`${_tranche.titre} (${_tranche.nombre_min} à ${_tranche.nombre_max})`">
                                                </td>
                                                <td>
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_'+index)" :name="'prix_achat_'+index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_'+index)" :name="'marge_'+index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </td>
                                                <td>
                                                    <input type="number" min="0" required class="form-control with-unite" readonly @input="checkMarge($event,'_'+index)" :name="'prix_vente_'+index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div v-if="!state_tranche_saison.length>0" style="background-color:#f0ecec69; padding: 25px;">
                                        <div style="text-align: center;">
                                             <a data-range="2" data-parent="location-vehicule" class="btn btn-primary" href="{{ url('admin/location-vehicule-tranche-saisons?location='.$vehicule->id)}}" role="button"><i class="fa fa-plus"></i>&nbsp;{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ trans('admin-base.btn.save') }}
                            </button>
                        </div>

                    </form>

                </div>