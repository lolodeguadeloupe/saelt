<div class="card">
    <form class="form-horizontal form-create" id="create-hebergement-blanche" method="post" @submit.prevent="storeHebBlanche($event,'create_hebergement_blanche')" action="{{url('admin/hebergement-marque-blanches')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.hebergement-marque-blanche.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_hebergement_blanche')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.hebergement.hebergement-marque-blanche.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>