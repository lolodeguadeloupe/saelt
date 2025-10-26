<div class="card">

    <form class="form-horizontal form-edit" id="edit-sup-activite" method="post" @submit.prevent="storeSupActivite($event,'edit_sup_activite')" :action="actionEditSupActivite" novalidate>


        <div class="card-header">
            <i class="fa fa-pencil"></i> <h3>{{ trans('admin.supplement-activite.actions.edit')}}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_sup_activite')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.hebergement.supplement-activite.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('brackets/admin-ui::admin.btn.save') }}
            </button>
        </div>

    </form>

</div>