<div class="form-group row align-items-center">
    <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.titre') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.allotement.columns.titre') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="quantite" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.quantite') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="number" required class="form-control" name="quantite" placeholder="{{ trans('admin.allotement.columns.quantite') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="date_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.date_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="form-control display-grid-date-heure">
            <input type="date" required name="date_depart" placeholder="{{ trans('admin.allotement.columns.date_depart') }}">
            <span>{{ trans('admin.allotement.columns.heure') }} </span>
            <input type="time" required name="heure_depart">
        </div>
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="lieu_depart" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.lieu_depart') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="lieu_depart_id" style="display: none;">
        <input type="text" required class="form-control" name="lieu_depart" placeholder="{{ trans('admin.allotement.columns.lieu_depart') }}" v-autocompletion="autocompleteAeroport" :action="urlbase+'/admin/autocompletion/service-aeroport'" :autokey="'id'" :label="'name'" :inputkey="'lieu_depart_id'" :inputlabel="'lieu_depart'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="date_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.date_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <div class="form-control display-grid-date-heure">
            <input type="date" required name="date_arrive" placeholder="{{ trans('admin.allotement.columns.date_arrive') }}">
            <span>{{ trans('admin.allotement.columns.heure') }} </span>
            <input type="time" required name="heure_arrive">
        </div>
    </div>
</div>


<div class="form-group row align-items-center">
    <label for="lieu_arrive" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.lieu_arrive') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="text" name="lieu_arrive_id" style="display: none;">
        <input type="text" required class="form-control" name="lieu_arrive" placeholder="{{ trans('admin.allotement.columns.lieu_arrive') }}" v-autocompletion="autocompleteAeroport" :action="urlbase+'/admin/autocompletion/service-aeroport'" :autokey="'id'" :label="'name'" :inputkey="'lieu_arrive_id'" :inputlabel="'lieu_arrive'">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="date_acquisition" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.date_acquisition') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="date" required class="form-control" name="date_acquisition" placeholder="{{ trans('admin.allotement.columns.date_acquisition') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="date_limite" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.date_limite') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <input type="date" class="form-control" name="date_limite" placeholder="{{ trans('admin.allotement.columns.date_limite') }}">
    </div>
</div>

<div class="form-group row align-items-center">
    <label for="compagnie_transport_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.allotement.columns.compagnie_transport_id') }}</label>
    <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
        <select required class="form-control" name="compagnie_transport_id">
            <option value="">-- sélectionner la compagnie --</option>
            <option v-for="compagnie in compagnies" :value="compagnie.id">@{{ compagnie.nom }}</option>
        </select>
        <div class="form-btn-inline-new" @click.prevent="createCompagnie($event,'{{url('admin/compagnie-transports/create')}}')"><i class="fa fa-plus"></i>
            <div class="info--btn">&nbsp;{{trans('admin.compagnie-transport.actions.create')}}</div>
        </div>
    </div>
</div>