                <div class="card">
                    <form class="form-horizontal form-create" id="create-famille-vehicule" data-response="familleVehicule" method="post" @submit.prevent="storeFamilleVehicule($event,'create_famille_vehicule')" action="{{url('admin/famille-vehicules')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.famille-vehicule.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_famille_vehicule')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.famille-vehicule.columns.titre') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.famille-vehicule.columns.titre') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.famille-vehicule.columns.description') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <div>
                                        <wysiwyg v-model="form.famille_vehicule_description" :config="mediaWysiwygConfig"></wysiwyg>
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