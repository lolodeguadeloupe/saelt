                <div class="card">

                    <form class="form-horizontal form-create"  id="create-personne" method="post" @submit.prevent="storePersonne($event,'create_personne')" action="{{url('admin/type-personnes')}}" novalidate>

                        <div class="card-header">
                            <i class="fa fa-plus"></i> <h3>{{ trans('admin.type-personne.actions.create') }}</h3>
                            <a class="float-right text-danger" style="cursor:pointer"  href="#" @click.prevent="closeModal('create_personne')"><i class="fa fa-times"></i></a>
                        </div>

                        <div class="card-body">
                            @include('admin.excursion.supplement-excursion.components.form-type-personne')
                        </div>

                        <div class="card-footer">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-download"></i>
                                {{ trans('admin-base.btn.save') }}
                            </button>
                        </div>

                    </form>


                </div>