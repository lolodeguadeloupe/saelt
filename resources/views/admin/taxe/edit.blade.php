        <div class="card">
            <form class="form-horizontal form-edit" id="edit-taxe" method="post" @submit.prevent="storeTaxe($event,'edit_taxe')" :action="actionEditTaxe" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3> {{ trans('admin.taxe.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_taxe')"><i class="fa fa-times"></i></a>
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