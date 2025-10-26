                <div class="card">

                    <form class="form-horizontal form-create" id="create-personne" method="post" @submit.prevent="storePersonne($event,'create_personne')" action="{{url('admin/type-personnes')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.type-personne.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_personne')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            <div class="form-group row align-items-center">
                                <label for="type" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.type') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="type" placeholder="{{ trans('admin.type-personne.columns.type') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="type" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.age') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <input type="text" required class="form-control" name="age" placeholder="{{ trans('admin.type-personne.columns.age') }}">
                                </div>
                            </div>

                            <div class="form-group row align-items-center">
                                <label for="type" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.type-personne.columns.description') }}</label>
                                <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                    <textarea class="form-control" name="description" cols="30" rows="3"></textarea>
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