<div class="card">

    <form class="form-horizontal form-edit" id="edit-service" method="post" @submit.prevent="storeService($event,'edit_service')" :action="actionEditService" novalidate>


        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.service-port.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('edit_service')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.service-port.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>