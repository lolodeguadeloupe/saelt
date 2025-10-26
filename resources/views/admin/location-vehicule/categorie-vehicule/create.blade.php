                <div class="card">

                    <form class="form-horizontal form-create" id="create-categorie-vehicule" method="post" @submit.prevent="storeCategorieVehicule($event,'create_categorie_vehicule')" action="{{url('admin/categorie-vehicules')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i> 
                            <h3>{{ trans('admin.categorie-vehicule.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_categorie_vehicule')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            @include('admin.location-vehicule.categorie-vehicule.components.form-elements')
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ trans('admin-base.btn.save') }}
                            </button>
                        </div>

                    </form>
                </div>