<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.supplement-vue.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.icon') }}</label>
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
    <label for="prix_vente" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.tarif') }} / Jour</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input required type="text" class="form-control"  @input="checkMarge($event,'')" name="marge" placeholder="{{ trans('admin.supplement-vue.columns.marge') }}" :value="0.0" style="display: none;">
        <input required type="text" class="form-control"  @input="checkMarge($event,'')" name="prix_achat" placeholder="{{ trans('admin.supplement-vue.columns.prix_achat') }}" :value="0.0" style="display: none;">
        <input required type="text" class="form-control with-unite" name="prix_vente" placeholder="{{ trans('admin.supplement-vue.columns.tarif') }}">
        <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
    </div>
</div>

<div class="form-group row align-items-center" >
    <label for="regle_tarif" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.regle_tarif') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="regle_tarif">
            <option v-for="application in [appliquer[1]]" :value="application.id">@{{application.value}}</option>
        </select>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="chambre_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.chambre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <multiselect name="chambre" v-model="form.chambre" :options="chambre" label="name" track-by="id" placeholder="..." :limit="5" :multiple="true">
        </multiselect>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.supplement-vue.columns.description') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <textarea class="form-control" name="description" cols="30" rows="3"></textarea>
    </div>
</div>