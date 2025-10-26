<div class="card">

    <form class="form-horizontal form-create" id="create-vehicule" method="post" @submit.prevent="storeVehicule($event,'create_vehicule')" :action="action" novalidate>


        <div class="card-header" style="position: relative;">
            <i class="fa fa-pencil"></i> <h3>{{ trans('admin.vehicule-location.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_vehicule')"><i class="fa fa-times"></i></a>
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