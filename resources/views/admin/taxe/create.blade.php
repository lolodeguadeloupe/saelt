<div class="card">

    <form class="form-horizontal form-create" id="create-taxe" method="post" @submit.prevent="storeTaxe($event,'create_taxe')" action="{{url('admin/taxes')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i> 
            <h3>{{ trans('admin.taxe.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_taxe')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            @include('admin.taxe.components.form-elements')
        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

</div>