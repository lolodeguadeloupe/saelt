<div class="card">

    <form class="form-horizontal form-create" id="create-pays" data-response="pays" method="post" @submit.prevent="storePays" action="{{url('admin/pays')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.pays.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_pays')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            <div class="form-group row align-items-center">
                <label for="nom" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.pays.columns.nom') }}</label>
                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                    <input type="text" required class="form-control" name="nom" placeholder="{{ trans('admin.pays.columns.nom') }}">
                </div>
            </div>
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>