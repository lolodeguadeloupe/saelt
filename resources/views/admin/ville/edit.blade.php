<div class="card">
    <form class="form-horizontal form-edit" id="edit-ville" data-response="ville" method="post" @submit.prevent="storeVille($event,'edit_ville')" :action="actionEditVille" novalidate>


        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.ville.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_ville')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.ville.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>