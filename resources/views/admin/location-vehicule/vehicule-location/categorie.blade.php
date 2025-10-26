                <div class="card">

                    <form class="form-horizontal form-create" id="create-categorie-vehicule" method="post" @submit.prevent="storeCategorieVehicule($event,'create_categorie_vehicule')" action="{{url('admin/categorie-vehicules')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.categorie-vehicule.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_categorie_vehicule')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="titre" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.categorie-vehicule.columns.titre') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.categorie-vehicule.columns.titre') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="famille_vehicule_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.categorie-vehicule.columns.famille_vehicule_id') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="famille_vehicule_titre" placeholder="{{ trans('admin.categorie-vehicule.columns.famille_vehicule_id') }}" v-autocompletion="autocompleteFamille" :action="urlbase+'/admin/autocompletion/famille-vehicules'" :autokey="'id'" :label="'titre'" :inputkey="'famille_vehicule_id'" :inputlabel="'famille_vehicule_titre'">
                                    <input type="text" class="form-control" required name="famille_vehicule_id" style="display: none;">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="description" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.categorie-vehicule.columns.description') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <div>
                                        <wysiwyg v-model="form.create_categorie_vehicule" :config="mediaWysiwygConfig"></wysiwyg>
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