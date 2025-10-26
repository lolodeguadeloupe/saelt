<div class="card">
    <form class="form-horizontal form-create" id="create-frais" method="post" @submit.prevent="storeFraisDossier($event,'create_frais')" action="{{url('admin/frais-dossiers')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.frais-dossier.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_frais')"><i class="fa fa-times"></i></a>
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