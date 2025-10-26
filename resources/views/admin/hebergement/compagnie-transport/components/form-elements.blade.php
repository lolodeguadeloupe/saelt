<div class="form-group row align-items-center">
    <label for="nom" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.nom') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="nom" placeholder="{{ trans('admin.compagnie-transport.columns.nom') }}">
</div>
</div>

<div class="form-group row align-items-center" >
    <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.email') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.compagnie-transport.columns.email') }}">
    </div>
</div>

<div class="form-group row align-items-center" >
    <label for="phone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.phone') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" class="form-control" data-ctr="phone" name="phone" placeholder="{{ trans('admin.compagnie-transport.columns.phone') }}">
    </div>
</div>

<div class="form-group row align-items-center" >
    <label for="type_transport" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.type_transport') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" readonly required class="form-control" name="type_transport" value="Aérien" placeholder="{{ trans('admin.compagnie-transport.columns.type_transport') }}">
    </div>
</div>

<div class="form-group row align-items-center" >
    <label for="adresse" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.compagnie-transport.columns.adresse') }}</label>
        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="adresse" placeholder="{{ trans('admin.compagnie-transport.columns.adresse') }}">
    </div> 
</div>

<div class="form-group row align-items-center">
    <label for="ville_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.hebergement.columns.ville_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
        <select required class="form-control" name="ville_id">
            <option v-for="ville in villes" :value="ville.id">@{{ ville.name }}</option>
        </select>
        <div class="form-btn-inline-new" @click.prevent="createVille($event,'{{url('admin/villes/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.ville.actions.create')}}</div>
        </div>
    </div>
</div>