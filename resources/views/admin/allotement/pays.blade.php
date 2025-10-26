<div class="card">

    <form class="form-horizontal form-create" id="create-pays" data-response="pays" method="post" @submit.prevent="storePays" action="{{url('admin/pays')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> <h3>{{ trans('admin.pays.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_pays')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.allotement.components.form-pays')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>