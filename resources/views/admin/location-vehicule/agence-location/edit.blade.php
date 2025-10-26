        <div class="card">

            <form class="form-horizontal form-edit" id="edit-agence" method="post" @submit.prevent="storeAgence($event,'edit_agence')" :action="actionEditAgence" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3>{{ trans('admin.agence-location.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('edit_agence')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.location-vehicule.agence-location.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>

        </div>