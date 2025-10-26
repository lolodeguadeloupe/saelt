                <div class="card">

                    <form class="form-horizontal form-create" id="create-compagnie" method="post" @submit.prevent="storeCompagnie($event,'create_compagnie')" action="{{url('admin/compagnie-transports')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i> <h3>{{ trans('admin.compagnie-transport.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_compagnie')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            @include('admin.hebergement.allotement.components.form-compagnie')
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ trans('admin-base.btn.save') }}
                            </button>
                        </div> 

                    </form>
                </div>