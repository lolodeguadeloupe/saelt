<div class="card">
    <form class="form-horizontal form-edit" id="edit-mode-payement" method="post" @submit.prevent="storeModePayement($event,'edit_mode_payement')" :action="actionEditModePayement" novalidate>
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.mode-payement.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_mode_payement')"><i class="fa fa-times"></i></a>
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