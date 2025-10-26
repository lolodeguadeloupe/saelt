        <div class="card">

            <form class="form-horizontal form-edit" id="edit-sup-pension" method="post" @submit.prevent="storeSupPension($event,'edit_sup_pension')" :action="actionEditSupPension" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i> <h3>{{ trans('admin.supplement-pension.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_sup_pension')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.hebergement.supplement-pension.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>

            </form>

        </div>