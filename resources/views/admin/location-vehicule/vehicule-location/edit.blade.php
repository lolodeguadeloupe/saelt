<div class="card">
    <div style="width: 100%;padding: 10px;">
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_vehicule')"><i class="fa fa-times"></i></a>
    </div>
    <div class="tabs-_card">
        <div class="items-tabs" :class="form_vehicule_edit[0]?'active':''" @click.prevent="editVehicule($event,url_resourse_vehicule,[true,false,false],true)">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.vehicule-location.actions.edit') }} {{ trans('admin.vehicule-location.title') }}</span>
        </div>
        <div class="items-tabs" :class="form_vehicule_edit[1]?'active':''" @click.prevent="editFicheTechnique($event,`${url_resourse_fiche_technique}/edit`,[false,true,false])">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.vehicule-location-info-tech.actions.edit') }} {{ trans('admin.vehicule-location-info-tech.title') }}</span>
        </div>
        <div class="items-tabs" :class="form_vehicule_edit[2]?'active':''" @click.prevent="editPrestataire($event,`${url_resourse_prestataire}/edit`,[false,false,true])">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.prestataire.actions.edit') }} {{ trans('admin.prestataire.title') }}</span>
        </div>
    </div>
    <form :class="form_vehicule_edit[0]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-vehicule" method="post" @submit.prevent="updateVehicule($event,'edit_vehicule_')" :action="actionEditVehicule" novalidate>

        <div class="card-body">
            @include('admin.location-vehicule.vehicule-location.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

    <form :class="form_vehicule_edit[1]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-info-tech" method="post" @submit.prevent="updateInfoTech($event,'edit_vehicule_')" :action="actionEditInfoTech" novalidate>
        <div class="card-body">
            @include('admin.location-vehicule.vehicule-location.components.form-info-tech')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

    <form :class="form_vehicule_edit[2]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-prestataire" method="post" @submit.prevent="updatePrestataire($event,'edit_vehicule')" :action="actionEditPrestataire" novalidate>
        <div class="card-body">
            @include('admin.location-vehicule.vehicule-location.components.form-prestataire')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>