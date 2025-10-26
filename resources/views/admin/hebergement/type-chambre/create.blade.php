<div class="card">

    <form class="form-horizontal form-create" id="create-type" method="post" @submit.prevent="storeType($event,'create_type')" action="{{url('admin/type-chambres')}}"  novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.type-chambre.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_type')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.hebergement.type-chambre.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download'"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>