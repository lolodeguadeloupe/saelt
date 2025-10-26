<div class="card">
    <form class="form-horizontal form-create" id="create-mode-payement" method="post" @submit.prevent="storeModePayement($event,'create_mode_payement')" action="{{url('admin/mode-payements')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.mode-payement.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_mode_payement')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.mode-payement.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>