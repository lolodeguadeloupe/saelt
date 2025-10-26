<div style="display: contents;" :class="billeterie_form[0]?'_is_show' : '_is_hide'">

    <div class="form-group row align-items-center">
        <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.titre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.billeterie-maritime.columns.titre') }}">
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="quantite" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.quantite') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="number" min="0" required class="form-control" name="quantite" placeholder="{{ trans('admin.billeterie-maritime.columns.quantite') }}">
        </div>
    </div>


    <div class="form-group row align-items-center">
        <label for="date_acquisition" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.date_acquisition') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="date" required class="form-control" name="date_acquisition" placeholder="{{ trans('admin.billeterie-maritime.columns.date_acquisition') }}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="date_limite" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.date_limite') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="date" class="form-control" name="date_limite" placeholder="{{ trans('admin.billeterie-maritime.columns.date_limite') }}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="lieu_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.lieu_depart') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" name="lieu_depart_id" style="display: none;">
            <input type="text" required class="form-control" name="lieu_depart" placeholder="{{ trans('admin.billeterie-maritime.columns.lieu_depart') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_depart_id'" :inputlabel="'lieu_depart'">
        </div>
    </div>
    <!--
    <div class="form-group row align-items-center">
        <label for="date_depart" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.date_depart') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="date" class="form-control" name="date_depart" placeholder="{{ trans('admin.billeterie-maritime.columns.date_acquisition') }}">
        </div>
    </div>
-->

    <div class="form-group row align-items-center">
        <label for="lieu_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.lieu_arrive') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" name="lieu_arrive_id" style="display: none;">
            <input type="text" required class="form-control" name="lieu_arrive" placeholder="{{ trans('admin.billeterie-maritime.columns.lieu_arrive') }}" v-autocompletion="autocompletePort" :action="urlbase+'/admin/autocompletion/service-port'" :autokey="'id'" :label="'name'" :inputkey="'lieu_arrive_id'" :inputlabel="'lieu_arrive'">
        </div>
    </div>
    <!--
    <div class="form-group row align-items-center">
        <label for="date_arrive" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.date_arrive') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="date" class="form-control" name="date_arrive" placeholder="{{ trans('admin.billeterie-maritime.columns.date_acquisition') }}">
        </div>
    </div>
-->

    <div class="form-group row align-items-center">
        <label for="fin" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{trans('admin.billeterie-maritime.columns.duree_trajet')}}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="time" class="form-control" name="duree_trajet" placeholder="{{trans('admin.billeterie-maritime.columns.duree_trajet')}}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="lieu_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.parcours') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <div class="d-flex flex-row">
                <div class="form-control d-flex align-items-center mr-1">
                    <input type="radio" required name="parcours" id="parcours_aller" checked value="1" style="height: 20px; width: 20px; margin-right: 15px;" @click="changeParcour(1)">
                    <label for="parcours_aller" class="m-0">Aller simple</label>
                </div>
                <div class="form-control d-flex align-items-center">
                    <input type="radio" required name="parcours" id="parcours_aller_retour" value="2" style="height: 20px; width: 20px; margin-right: 15px;" @click="changeParcour(2)">
                    <label for="parcours_aller_retour" class="m-0">Aller/rétour</label>
                </div>
            </div>
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="compagnie_transport_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.compagnie_transport_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <select required class="form-control" name="compagnie_transport_id">
                <option v-for="compagnie in compagnies" :value="compagnie.id">@{{ compagnie.nom }}</option>
            </select>
            <div class="form-btn-inline-new" @click.prevent="createCompagnie($event,'{{url('admin/compagnie-transports/create')}}')"><i class="fa fa-plus"></i>
                <div class="info--btn">&nbsp;{{trans('admin.billeterie-maritime.actions.create')}}</div>
            </div>
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="card" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.billeterie-maritime.columns.image') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <figure class="figure-form" v-for="(_image,_index) in images" :key="_index+'image'">
                <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="image" style="height: 100%;width: auto;">
                <span class="my-_btn-remove" @click.prevent="removeImage(_index)">
                    {{trans('admin.billeterie-maritime.actions.removeImage')}}
                </span>
                <input type="text" required class="form-control" name="image" style="display: none;" :value="_image">
            </figure>
            <figure v-if="images.length == 0" class="figure-form" @drop.prevent="uploadImage($event,true)" @dragover.prevent>
                <span class="my-_btn-add">
                    {{trans('admin.billeterie-maritime.actions.uploadImage')}}
                    <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadImage">
                </span>
            </figure>
        </div>
    </div>

</div>


<div id="billeterie_maritime_block" :class="billeterie_form[1]?'_is_show' : '_is_hide'">
    <!--<div>
        <a class="btn btn-primary btn-sm pull-right m-b-0" role="button" href="#" @click.prevent="createPersonne($event,'{{url('admin/type-personnes/create')}}')"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.type-personne.actions.create') }}</a>
    </div>
-->
    <div style="padding: 30px 0;">
        <h3>{{trans('admin.billeterie-maritime.columns.tarif_aller')}}</h3>
        <div>
            <table class="table table-hover table-listing" style="margin: auto;">
                <thead>
                    <tr>
                        <th>{{trans('admin.billeterie-maritime.columns.type_personne_id')}}</th>
                        <th>{{trans('admin.billeterie-maritime.columns.prix_achat_aller')}} (€)</th>
                        <th>{{trans('admin.billeterie-maritime.columns.marge_aller')}} (€)</th>
                        <th>{{trans('admin.billeterie-maritime.columns.prix_vente_aller')}} (€)</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(type_personne , _index) in typePersonnes">
                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="text" required class="form-control" readonly :value="type_personne.type" :name="'type_personne_type_'+_index">
                                <input style="display: none;" type="text" :name="'type_personne_age_'+_index" :value="type_personne.age">
                                <input style="display: none;" type="text" :name="'type_personne_description_'+_index" :value="type_personne.description">
                                <input style="display: none;" type="text" :name="'type_personne_reference_prix_'+_index" :value="type_personne.reference_prix">
                                <input style="display: none;" type="text" :name="'type_personne_id_'+_index" :value="type_personne.id">
                                <input style="display: none;" type="text" :name="'type_personne_original_id_'+_index" :value="type_personne.original_id">
                                <div class="position-absolute w-100 h-100 top-0 left-0 d-flex align-items-center">
                                    <div class="align-items-center d-flex h-100 ml-auto mr-0 w-50">
                                        <span class="flex-grow-1">
                                            @{{type_personne.age}}
                                        </span>
                                        <button type="button" class="b-a-0 bg-white" @click.prevent="editPersonne($event,type_personne)">
                                            <i class="fa fa-pencil"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_achat_aller_'+_index" @input="checkMarge($event,'aller_'+_index)" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" :name="'marge_aller_'+_index" @input="checkMarge($event,'aller_'+_index)" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" readonly :name="'prix_vente_aller_'+_index" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>
                        <td style="min-width: 20px !important">
                            <!-- <button v-if="type_personne.reference_prix == 1" class="btn danger btn-danger" disabled><i class="fa fa-times"></i></button>-->
                            <button v-if="type_personne.reference_prix == 0" class="btn-sm danger btn-danger" @click.prevent="deletePersonne($event,_index)"><i class="fa fa-times"></i></button>
                        </td>

                    </tr>
                    <tr>
                        <td class="d-flex">
                            <!--<a class="btn btn-primary btn-sm m-auto m-b-0" role="button" data-parent="billeterie" href="{{url('admin/type-personnes')}}">
                            <i class="fa fa-plus"></i>&nbsp; <p class="mb-0 d-inline-block">{{trans('admin.type-personne.actions.create')}}</p>
                            </a>-->
                            <a class="btn btn-primary btn-sm pull-right m-b-0" role="button" href="#" @click.prevent="createPersonne($event,'{{url('admin/type-personnes/create')}}')"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.type-personne.actions.create') }}</a>
                        </td>
                        <td colspan="4"></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div style="padding: 30px 0;" v-if="parcours == 2">
        <h3>{{trans('admin.billeterie-maritime.columns.tarif_aller_retour')}}</h3>
        <div>
            <table class="table table-hover table-listing" style="margin: auto;">
                <thead>
                    <tr>
                        <th>{{trans('admin.billeterie-maritime.columns.type_personne_id')}}</th>
                        <th>{{trans('admin.billeterie-maritime.columns.prix_achat_aller_retour')}}</th>
                        <th>{{trans('admin.billeterie-maritime.columns.marge_aller_retour')}}</th>
                        <th>{{trans('admin.billeterie-maritime.columns.prix_vente_aller_retour')}}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(type_personne , _index) in typePersonnes">
                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="text" class="form-control" readonly :value="type_personne.type">
                                <div class="position-absolute w-100 h-100 top-0 left-0 d-flex align-items-center">
                                    <div class="align-items-center d-flex h-100 ml-auto mr-0 w-50">
                                        <span class="flex-grow-1">
                                            @{{type_personne.age}}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_achat_aller_retour_'+_index" @input="checkMarge($event,'aller_retour_'+_index)" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" :name="'marge_aller_retour_'+_index" @input="checkMarge($event,'aller_retour_'+_index)" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>

                        <td>
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" readonly :name="'prix_vente_aller_retour_'+_index" required class="form-control">
                                <!--<span style="position: absolute; right: 25px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">@{{devises.symbole}}</span>-->
                            </div>
                        </td>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>