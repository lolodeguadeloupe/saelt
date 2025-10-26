                <div class="card">

                    <form class="form-horizontal form-create" id="create-agence" method="post" @submit.prevent="storeAgence($event,'create_agence')" action="{{url('admin/agence-locations')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i>
                            <h3>{{ trans('admin.agence-location.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_agence')"><i class="fa fa-times"></i></a>
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