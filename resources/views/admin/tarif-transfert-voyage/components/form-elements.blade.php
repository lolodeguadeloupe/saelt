<div class="form-group row align-items-center" :class="{'has-danger': errors.has('trajet_transfert_voyage_id'), 'has-success': fields.trajet_transfert_voyage_id && fields.trajet_transfert_voyage_id.valid }">
    <label for="trajet_transfert_voyage_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.trajet_transfert_voyage_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('trajet_transfert_voyage_id'), 'form-control-success': fields.trajet_transfert_voyage_id && fields.trajet_transfert_voyage_id.valid}" id="trajet_transfert_voyage_id" name="trajet_transfert_voyage_id" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.trajet_transfert_voyage_id') }}">
        <div v-if="errors.has('trajet_transfert_voyage_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('trajet_transfert_voyage_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('tranche_transfert_voyage_id'), 'has-success': fields.tranche_transfert_voyage_id && fields.tranche_transfert_voyage_id.valid }">
    <label for="tranche_transfert_voyage_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.tranche_transfert_voyage_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.tranche_transfert_voyage_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('tranche_transfert_voyage_id'), 'form-control-success': fields.tranche_transfert_voyage_id && fields.tranche_transfert_voyage_id.valid}" id="tranche_transfert_voyage_id" name="tranche_transfert_voyage_id" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.tranche_transfert_voyage_id') }}">
        <div v-if="errors.has('tranche_transfert_voyage_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('tranche_transfert_voyage_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('type_personne_id'), 'has-success': fields.type_personne_id && fields.type_personne_id.valid }">
    <label for="type_personne_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.type_personne_id') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.type_personne_id" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('type_personne_id'), 'form-control-success': fields.type_personne_id && fields.type_personne_id.valid}" id="type_personne_id" name="type_personne_id" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.type_personne_id') }}">
        <div v-if="errors.has('type_personne_id')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('type_personne_id') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_achat_aller'), 'has-success': fields.prix_achat_aller && fields.prix_achat_aller.valid }">
    <label for="prix_achat_aller" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_achat_aller" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_achat_aller'), 'form-control-success': fields.prix_achat_aller && fields.prix_achat_aller.valid}" id="prix_achat_aller" name="prix_achat_aller" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller') }}">
        <div v-if="errors.has('prix_achat_aller')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_achat_aller') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_achat_aller_retour'), 'has-success': fields.prix_achat_aller_retour && fields.prix_achat_aller_retour.valid }">
    <label for="prix_achat_aller_retour" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller_retour') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_achat_aller_retour" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_achat_aller_retour'), 'form-control-success': fields.prix_achat_aller_retour && fields.prix_achat_aller_retour.valid}" id="prix_achat_aller_retour" name="prix_achat_aller_retour" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prix_achat_aller_retour') }}">
        <div v-if="errors.has('prix_achat_aller_retour')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_achat_aller_retour') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('marge_aller'), 'has-success': fields.marge_aller && fields.marge_aller.valid }">
    <label for="marge_aller" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.marge_aller') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.marge_aller" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('marge_aller'), 'form-control-success': fields.marge_aller && fields.marge_aller.valid}" id="marge_aller" name="marge_aller" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.marge_aller') }}">
        <div v-if="errors.has('marge_aller')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('marge_aller') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('marge_aller_retour'), 'has-success': fields.marge_aller_retour && fields.marge_aller_retour.valid }">
    <label for="marge_aller_retour" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.marge_aller_retour') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.marge_aller_retour" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('marge_aller_retour'), 'form-control-success': fields.marge_aller_retour && fields.marge_aller_retour.valid}" id="marge_aller_retour" name="marge_aller_retour" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.marge_aller_retour') }}">
        <div v-if="errors.has('marge_aller_retour')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('marge_aller_retour') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_vente_aller'), 'has-success': fields.prix_vente_aller && fields.prix_vente_aller.valid }">
    <label for="prix_vente_aller" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_vente_aller" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_vente_aller'), 'form-control-success': fields.prix_vente_aller && fields.prix_vente_aller.valid}" id="prix_vente_aller" name="prix_vente_aller" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller') }}">
        <div v-if="errors.has('prix_vente_aller')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_vente_aller') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prix_vente_aller_retour'), 'has-success': fields.prix_vente_aller_retour && fields.prix_vente_aller_retour.valid }">
    <label for="prix_vente_aller_retour" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller_retour') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prix_vente_aller_retour" v-validate="'required|decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prix_vente_aller_retour'), 'form-control-success': fields.prix_vente_aller_retour && fields.prix_vente_aller_retour.valid}" id="prix_vente_aller_retour" name="prix_vente_aller_retour" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prix_vente_aller_retour') }}">
        <div v-if="errors.has('prix_vente_aller_retour')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prix_vente_aller_retour') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('prime_nuit'), 'has-success': fields.prime_nuit && fields.prime_nuit.valid }">
    <label for="prime_nuit" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.prime_nuit" v-validate="'decimal'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('prime_nuit'), 'form-control-success': fields.prime_nuit && fields.prime_nuit.valid}" id="prime_nuit" name="prime_nuit" placeholder="{{ trans('admin.tarif-transfert-voyage.columns.prime_nuit') }}">
        <div v-if="errors.has('prime_nuit')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('prime_nuit') }}</div>
    </div>
</div>


