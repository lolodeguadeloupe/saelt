<div class="form-group row align-items-center" :class="{'has-danger': errors.has('id_model'), 'has-success': fields.id_model && fields.id_model.valid }">
    <label for="id_model" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.media-image-upload.columns.id_model') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.id_model" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('id_model'), 'form-control-success': fields.id_model && fields.id_model.valid}" id="id_model" name="id_model" placeholder="{{ trans('admin.media-image-upload.columns.id_model') }}">
        <div v-if="errors.has('id_model')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('id_model') }}</div>
    </div>
</div>

<div class="form-group row align-items-center" :class="{'has-danger': errors.has('name'), 'has-success': fields.name && fields.name.valid }">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.media-image-upload.columns.name') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" v-model="form.name" v-validate="'required'" @input="validate($event)" class="form-control" :class="{'form-control-danger': errors.has('name'), 'form-control-success': fields.name && fields.name.valid}" id="name" name="name" placeholder="{{ trans('admin.media-image-upload.columns.name') }}">
        <div v-if="errors.has('name')" class="form-control-feedback form-text" v-cloak>@{{ errors.first('name') }}</div>
    </div>
</div>


