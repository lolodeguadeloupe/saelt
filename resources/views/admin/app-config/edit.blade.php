<div class="card">
    <form class="form-horizontal form-edit" id="edit-app" data-response="app_config" method="post" @submit.prevent="storeApp($event,'edit_app')" :action="actionEditApp" novalidate>


        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.app-config.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_app')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.app-config.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>