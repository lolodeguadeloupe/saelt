        <div class="card">

            <form class="form-horizontal form-create" id="create-tarif" method="post" @submit.prevent="storeTarif($event,'create_tarif')" :action="action" novalidate>


                <div class="card-header">
                    <i class="fa fa-plus"></i>
                    <h3>{{ trans('admin.tarif-transfert-voyage.actions.create') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_tarif')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    <div class="my-_header-info-table" style=" margin-bottom: 4px;background-color:#f0ecec69; padding: 25px; margin-bottom: 30px;">
                        <div class="form-group row align-items-center">
                            <label for="type_transfert_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.type_transfert_voyage') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
                                <input type="text" require name="type_transfert_id" style="display: none;" value="{{$typeTransfertVoyage->id}}">
                                <input type="text" required readonly name="type_transfert_titre" class="form-control" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.type_transfert_voyage') }}" value="{{$typeTransfertVoyage->titre}}">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="trajet_transfert_voyage_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
                                <input type="text" name="trajet_transfert_voyage_id" style="display: none;">
                                <input type="text" required name="trajet_transfert_voyage_titre" class="form-control" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage') }}" v-autocompletion="autocompleteTrajetVoyage" :action="urlbase+'/admin/autocompletion/trajet-transfert-voyages'" :autokey="'id'" :label="'titre'" :inputkey="'trajet_transfert_voyage_id'" :inputlabel="'trajet_transfert_voyage_titre'">
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="tranche_transfert_voyage_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.tranche_personne_transfert_voyage') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
                                <select name="tranche_transfert_voyage_id" class="form-control">
                                    <option v-for="_trancheVoyage of state_tranchetransfertvoyage" :value="_trancheVoyage.id">@{{_trancheVoyage.titre}} (@{{_trancheVoyage.nombre_min}}Pers. - @{{_trancheVoyage.nombre_max}}Pers.) </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row align-items-center">
                            <label for="prime_nuit" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}</label>
                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
                                <input type="number" required inputmode="decimal" step="any" min="0" name="prime_nuit" class="form-control with-unite" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}">
                                <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">%</span>
                            </div>
                        </div>
                    </div>

                    <div v-if="typePersonnes.length > 0" style="margin-bottom: 40px; background-color:#f0ecec69; padding: 25px;">
                        <div>
                            <h4>{{trans('admin.tarif-transfert-voyage.columns.tarif_aller')}}</h4>
                        </div>
                        <div>
                            <table class="my-_list-table" style="margin-top: 20px;">
                                <thead>

                                    <tr>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.type_personne')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.prix_achat_aller')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.marge_aller')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.prix_vente_aller')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(type_personne, _index) in typePersonnes">
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="text" required class="form-control" readonly :value="type_personne.type" :name="'type_personne_type_'+_index">
                                                    <input style="display: none;" type="text" :name="'type_personne_id_'+_index" :value="type_personne.id">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_aller_'+_index)" :name="'prix_achat_aller_'+_index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_aller_'+_index)" :name="'marge_aller_'+_index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" :name="'prix_vente_aller_'+_index" readonly>
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr> 

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <!-----      aller retour   ------->
                    <div v-if="typePersonnes.length > 0" style="background-color:#f0ecec69; padding: 25px;">
                        <div>
                            <h4>{{trans('admin.tarif-transfert-voyage.columns.tarif_aller_retour')}}</h4>
                        </div>
                        <div>
                            <table class="my-_list-table" style="margin-top: 20px;">
                                <thead>

                                    <tr>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.type_personne')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.prix_achat_aller_retour')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.marge_aller_retour')}}
                                        </th>
                                        <th class="my-_list-table-title">
                                            {{trans('admin.tarif-transfert-voyage.columns.prix_vente_aller_retour')}}
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(type_personne, _index) in typePersonnes">
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="text" class="form-control" readonly :value="type_personne.type">
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_aller_retour_'+_index)" :name="'prix_achat_aller_retour_'+_index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'_aller_retour_'+_index)" :name="'marge_aller_retour_'+_index">
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="form-group row align-items-center">
                                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                    <input type="number" min="0" required class="form-control with-unite" :name="'prix_vente_aller_retour_'+_index" readonly>
                                                    <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>

                                </tbody>
                            </table>
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