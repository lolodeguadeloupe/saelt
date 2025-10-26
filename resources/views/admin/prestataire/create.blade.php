                <div class="card">
                    <form class="form-horizontal form-create"  id="create-prestataire" data-response="prestataire" method="post" @submit.prevent="storePrestataire($event,'create_prestataire')" action="{{url('admin/prestataires')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.prestataire.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_prestataire')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            @include('admin.prestataire.components.form-elements')
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ trans('admin-base.btn.save') }}
                            </button>
                        </div>

                    </form>
                </div>