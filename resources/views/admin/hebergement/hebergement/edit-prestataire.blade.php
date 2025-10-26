
    <div class="card">

            <form class="form-horizontal form-edit" id="edit-prestataire" data-response="prestataire" method="post" @submit.prevent="updatePrestataire($event,'edit_prestataire')" :action="actionEditPrestataire" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i> <h3>{{ trans('admin.prestataire.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" @click.prevent="closeModal('edit_prestataire')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.hebergement.hebergement.components.form-prestataire')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>

    </div>
