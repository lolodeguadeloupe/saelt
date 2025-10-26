<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.name') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="name" placeholder="{{ trans('admin.ville.columns.name') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="name" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.code_postal') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" name="code_postal" placeholder="{{ trans('admin.ville.columns.code_postal') }}">
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="pays_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.ville.columns.pays_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="pays_id">
            <option v-for="_pays in pays" :value="_pays.id">@{{ _pays.nom }}</option>
        </select>
        <div class="form-btn-inline-new" @click.prevent="createPays($event,'{{url('admin/pays/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.pays.actions.create')}}</div>
        </div>
    </div>
</div>