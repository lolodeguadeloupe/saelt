<div style="display: contents;" :class="supplement_form[0]?'_is_show' : '_is_hide'">

    <div class="form-group row align-items-center">
        <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-excursion.columns.type') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <select name="type" class="form-control" name="type" @change="checkSupplement($event.target.value)">
                <option value=""> -- sélectionnez le supplément</option>
                <option :value="_type.id" v-for="_type of typesupplement">@{{_type.label}}</option>
            </select>
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-excursion.columns.titre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.supplement-excursion.columns.titre') }}">
        </div>
    </div>

    <div class="form-group row align-items-center">
        <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-excursion.columns.icon') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <span class="icon-upload-form" :style="'background-image: url(\''+(icon.length > 0 ? ($isBase64(icon[0])?icon[0]:`${urlasset}/${icon[0]}`) : '{{asset('images/icon.png')}}')+'\');'" @drop.prevent="uploadIcon($event,true)" @dragover.prevent>
                <input type="text" class="form-control" name="icon" style="display: none;" :value="icon.length > 0 ? icon[0] : ''">
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
        <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.chambre.columns.description') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
            <textarea class="form-control" name="description" cols="30" rows="3" placeholder="{{ trans('admin.chambre.columns.description') }}"></textarea>
        </div>
    </div>
</div>

<div style="display: flex;align-items: center;position: relative;" id="supplement_excursion_block" :class="supplement_form[1]?'_is_show' : '_is_hide'">

    <table class="table table-hover table-listing" style="margin: auto;">
        <thead>
            <tr>
                <th>{{trans('admin.supplement-excursion.columns.type_personne_id')}}</th>
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
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'marge_'+_index" required class="form-control" style="display: none;" value="0">
                            <input type="number" inputmode="decimal" step="any" min="0" @input="checkMarge($event,'_'+_index)" :name="'prix_achat_'+_index" required class="form-control" style="display: none;" value="0">
                            <input type="number" inputmode="decimal" step="any" min="0" :name="'prix_vente_'+_index" required class="form-control with-unite">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>

<input type="text" name="excursion_id" :value="excursion.id" style="display: none;">