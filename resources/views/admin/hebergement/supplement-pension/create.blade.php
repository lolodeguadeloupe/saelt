<div class="card">

    <form class="form-horizontal form-create" id="create-sup-pension" method="post" @submit.prevent="storeSupPension($event,'create_sup_pension')" :action="action"  novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.supplement-pension.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_sup_pension')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.hebergement.supplement-pension.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('brackets/admin-ui::admin.btn.save') }}
            </button>
        </div>

    </form>

</div>