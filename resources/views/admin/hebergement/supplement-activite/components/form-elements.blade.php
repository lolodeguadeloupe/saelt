<input type="text" required class="form-control" name="hebergement_id" value="{{$hebergement->id}}" style="display: none;">
<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.supplement-activite.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.icon') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <span class="icon-upload-form" :style="'background-image: url(\''+(icon.length > 0 ? ($isBase64(icon[0])?icon[0]:`${urlasset}/${icon[0]}`) : '{{asset('images/icon.png')}}')+'\');'" @drop.prevent="uploadIcon($event,true)" @dragover.prevent>
            <input type="text" required class="form-control" name="icon" style="display: none;" :value="icon.length > 0 ? icon[0] : ''">
            <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadIcon">
        </span>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="prestataire_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.title') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <input type="text" name="prestataire_id" style="display: none;">
        <input type="text" name="prestataire_name" class="form-control" placeholder="{{ trans('admin.prestataire.columns.name') }}" v-autocompletion="autocompletePrestataire" :action="urlbase+'/admin/autocompletion/prestataires'" :autokey="'id'" :label="'name'" :inputkey="'prestataire_id'" :inputlabel="'prestataire_name'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="regle_tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.regle_tarif') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="regle_tarif">
            <option v-for="application in [appliquer[0]]" :value="application.id">@{{application.value}}</option>
        </select>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-activite.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3"></textarea>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-pension.columns.tarif') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">

        <table class="table table-hover table-listing" style="margin: auto;">
            <thead>
                <tr>
                    <th>{{ trans('admin.supplement-pension.columns.type_personne') }}</th>
                    <th>{{ trans('admin.supplement-pension.columns.tarif') }} / Jour</th>
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
                        <div style="display: unset;">
                            <div class="form-group" style="margin-bottom: 0 !important">
                                <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'marge_'+_index" required class="form-control" :value="0.0" style="display: none;">
                                <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'prix_achat_'+_index" required class="form-control" :value="0.0" style="display: none;">
                                <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_vente_'+_index" required class="form-control with-unite">
                                <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                            </div>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

<!--

<div class="form-group row align-items-center">
    <label for="tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-pension.columns.tarif') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div>
            <a class="btn btn-primary btn-sm pull-right m-b-0" style="margin-bottom: 5px;" role="button" href="#" @click.prevent="createPersonne($event,'{{url('admin/type-personnes/create')}}')"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.type-personne.actions.create') }}</a>
        </div>
        <table class="table table-hover table-listing" style="margin: auto;">
            <thead>
                <tr>
                    <th>{{ trans('admin.supplement-pension.columns.type_personne') }}</th>
                    <th>{{ trans('admin.supplement-pension.columns.marge') }}</th>
                    <th>{{ trans('admin.supplement-pension.columns.prix_achat') }}</th>
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
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'marge_'+_index" required class="form-control">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'prix_achat_'+_index" required class="form-control">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                    <td>
                        <div class="form-group" style="margin-bottom: 0 !important">
                            <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_vente_'+_index" readonly required class="form-control">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

-->