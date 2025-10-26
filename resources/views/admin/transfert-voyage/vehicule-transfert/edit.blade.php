<div class="card">

    <form class="form-horizontal form-edit" id="edit-vehicule" method="post" @submit.prevent="storeVehicule($event,'edit_vehicule')" :action="actionEditVehicule" novalidate>


        <div class="card-header" style="position: relative;">
            <i class="fa fa-pencil"></i> <h3>{{ trans('admin.vehicule-location.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_vehicule')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.transfert-voyage.vehicule-transfert.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>