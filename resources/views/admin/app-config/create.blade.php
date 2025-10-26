<div class="card">
    <form class="form-horizontal form-create" id="create-app" data-response="app_config" method="post" @submit.prevent="storeApp($event,'create_app')" action="{{url('admin/app-configs')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.app-config.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_app')"><i class="fa fa-times"></i></a>
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