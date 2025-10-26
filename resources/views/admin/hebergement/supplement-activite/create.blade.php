<div class="card">

    <form class="form-horizontal form-create" id="create-sup-activite" method="post" @submit.prevent="storeSupActivite($event,'create_sup_activite')" :action="action"  novalidate>

        <div class="card-header"> 
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.supplement-activite.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_sup_activite')"><i class="fa fa-times"></i></a>
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