<div class="card">
        <form class="form-horizontal form-edit" id="edit-hebergement-blanche" method="post" @submit.prevent="storeHebBlanche($event,'edit_hebergement_blanche')" :action="actionEditHebBlanche" novalidate>


            <div class="card-header">
                <i class="fa fa-pencil"></i> <h3>{{ trans('admin.hebergement-marque-blanche.actions.edit') }}</h3>
                <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_hebergement_blanche')"><i class="fa fa-times"></i></a>
            </div>

            <div class="card-body">
                @include('admin.hebergement.hebergement-marque-blanche.components.form-elements')
            </div>


            <div class="card-footer">
                <button type="submit" class="btn btn-primary" >
                    <i class="fa fa-download"></i>
                    {{ trans('brackets/admin-ui::admin.btn.save') }}
                </button>
            </div>

        </form>

</div>