        <div class="card">
            <form class="form-horizontal form-edit" id="edit-saison" method="post" @submit.prevent="storeSaison($event,'edit_saison')" :action="actionEditSaison" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i><h3>{{ trans('admin.saison.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer"  href="#" @click.prevent="closeModal('edit_saison')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.excursion.saison.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>
        </div>