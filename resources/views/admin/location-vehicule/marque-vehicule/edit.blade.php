        <div class="card">

            <form class="form-horizontal form-edit" id="edit-marque" data-response="marqueVehicule" method="post" @submit.prevent="storeMarque($event,'edit_marque')" :action="actionEditMarque" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3>{{ trans('admin.marque-vehicule.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_marque')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.location-vehicule.marque-vehicule.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>
        </div>