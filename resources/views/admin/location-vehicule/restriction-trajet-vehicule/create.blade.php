<div class="card">
    <form class="form-horizontal form-create" id="create-trajet" method="post" @submit.prevent="storeTrajet($event,'create_trajet')" action="{{url('admin/restriction-trajet-vehicules')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.restriction-trajet-vehicule.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_trajet')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.location-vehicule.restriction-trajet-vehicule.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>