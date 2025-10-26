<div class="card">
    <form class="form-horizontal form-edit" id="edit-frais" method="post" @submit.prevent="storeFraisDossier($event,'edit_frais')" :action="actionEditFraisDossier" novalidate>
        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.frais-dossier.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_frais')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.frais-dossier.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>