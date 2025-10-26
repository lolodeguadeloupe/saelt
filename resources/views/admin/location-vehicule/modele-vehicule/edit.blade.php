        <div class="card">
            <form class="form-horizontal form-edit" id="edit-modele" data-response="modeleVehicule" method="post" @submit.prevent="storeModele($event,'edit_modele')" :action="actionEditModele" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3>{{ trans('admin.modele-vehicule.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_modele')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.location-vehicule.modele-vehicule.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>
        </div>