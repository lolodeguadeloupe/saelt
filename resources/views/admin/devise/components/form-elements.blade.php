<div class="form-group row align-items-center" :class="{'has-danger': errors.has('titre'), 'has-success': fields.titre && fields.titre.valid }">
    <label for="titre" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.devise.columns.titre') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.titre" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('titre'), 'form-control-success': fields.titre && fields.titre.valid}" id="titre" name="titre" placeholder="{{ trans('admin.devise.columns.titre') }}">
        <div v-if="errors.has('titre')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('titre') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('symbole'), 'has-success': fields.symbole && fields.symbole.valid }">
    <label for="symbole" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.devise.columns.symbole') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.symbole" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('symbole'), 'form-control-success': fields.symbole && fields.symbole.valid}" id="symbole" name="symbole" placeholder="{{ trans('admin.devise.columns.symbole') }}">
        <div v-if="errors.has('symbole')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('symbole') }}</div>
    </div>
</div>


