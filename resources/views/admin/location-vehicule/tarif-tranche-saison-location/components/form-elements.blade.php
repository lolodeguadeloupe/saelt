<div class="form-group row align-items-center" :class="{'has-danger': errors.has('marge'), 'has-success': fields.marge && fields.marge.valid }">
    <label for="marge" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.marge" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('marge'), 'form-control-success': fields.marge && fields.marge.valid}" id="marge" name="marge" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}">
        <div v-if="errors.has('marge')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('marge') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_achat'), 'has-success': fields.prix_achat && fields.prix_achat.valid }">
    <label for="prix_achat" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_achat" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_achat'), 'form-control-success': fields.prix_achat && fields.prix_achat.valid}" id="prix_achat" name="prix_achat" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}">
        <div v-if="errors.has('prix_achat')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_achat') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_vente'), 'has-success': fields.prix_vente && fields.prix_vente.valid }">
    <label for="prix_vente" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_vente" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_vente'), 'form-control-success': fields.prix_vente && fields.prix_vente.valid}" id="prix_vente" name="prix_vente" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}">
        <div v-if="errors.has('prix_vente')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_vente') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tranche_saison_id'), 'has-success': fields.tranche_saison_id && fields.tranche_saison_id.valid }">
    <label for="tranche_saison_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.tranche_saison_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('tranche_saison_id'), 'form-control-success': fields.tranche_saison_id && fields.tranche_saison_id.valid}" id="tranche_saison_id" name="tranche_saison_id" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison_id') }}">
        <div v-if="errors.has('tranche_saison_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tranche_saison_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('categorie_vehicule_id'), 'has-success': fields.categorie_vehicule_id && fields.categorie_vehicule_id.valid }">
    <label for="categorie_vehicule_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.categorie_vehicule_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.categorie_vehicule_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('categorie_vehicule_id'), 'form-control-success': fields.categorie_vehicule_id && fields.categorie_vehicule_id.valid}" id="categorie_vehicule_id" name="categorie_vehicule_id" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.categorie_vehicule_id') }}">
        <div v-if="errors.has('categorie_vehicule_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('categorie_vehicule_id') }}</div>
    </div>
</div>


