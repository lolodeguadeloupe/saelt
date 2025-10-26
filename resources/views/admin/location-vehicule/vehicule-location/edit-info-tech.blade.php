<div class="card">

    <form class="form-horizontal form-edit" id="edit-info-tech" method="post" @submit.prevent="storeInfoTech($event,'edit_vehicule_info_tech')" :action="actionEditInfoTech" novalidate>


        <div class="card-header" style="position: relative;">
            <i class="fa fa-pencil"></i> <h3>{{ trans('admin.vehicule-location-info-tech.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_vehicule_info_tech')"><i class="fa fa-times"></i></a>
        </div>

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

</div>