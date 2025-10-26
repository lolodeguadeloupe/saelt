                <div class="card">
                    <form class="form-horizontal form-create" id="create-marque" data-response="marqueVehicule" method="post" @submit.prevent="storeMarque($event,'create_marque_vehicule')" action="{{url('admin/marque-vehicules')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.marque-vehicule.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_marque_vehicule')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.marque-vehicule.columns.titre') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.marque-vehicule.columns.titre') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="descciption" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.marque-vehicule.columns.description') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <div>
                                        <textarea class="form-control" name="description"></textarea>
                                    </div>
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