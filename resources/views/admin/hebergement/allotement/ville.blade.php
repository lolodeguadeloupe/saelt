<div class="card">

    <form class="form-horizontal form-create" id="create-ville" data-response="ville" method="post" @submit.prevent="storeVille" action="{{url('admin/villes')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.ville.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_ville')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.hebergement.allotement.components.form-ville')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>