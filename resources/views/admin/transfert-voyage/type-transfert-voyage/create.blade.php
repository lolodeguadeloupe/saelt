                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-plus"></i>
                        <h3>{{ trans('admin.type-transfert-voyage.actions.create') }}</h3>
                        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_type')"><i class="fa fa-times"></i></a>
                    </div>

                    <div class="card-body">
                        <div class="content-_progres">
                            <div class="line"></div>
                            <div :class="form_type[0]?'progres active':'progres pointer'" @click.prevent="changeFormType([false,true])">1 <span class="title">{{ trans('admin.prestataire.title')}}</span> </div>
                            <div :class="form_type[1]?'progres active':'progres pointer'" @click.prevent="changeFormType([true,false])">2 <span class="title">{{ trans('admin.type-transfert-voyage.title')}}</span></div>
                        </div>
                        <form :style="'display:'+(form_type[0]?'block':'none')" class="form-horizontal form-create" id="create-prestataire" data-response="prestataire" method="post" @submit.prevent="" action="{{url('admin/prestataires')}}" novalidate v-cloak>
                            @include('admin.transfert-voyage.type-transfert-voyage.components.form-prestataire')
                        </form>
                        <form :style="'display:'+ (form_type[1]?'block':'none')" class="form-horizontal form-create" id="create-type" method="post" @submit.prevent="storeType($event,'create_type')" action="{{url('admin/type-transfert-voyages')}}" novalidate v-cloak>
                            @include('admin.transfert-voyage.type-transfert-voyage.components.form-elements')
                        </form>
                    </div>

                    <div v-if="form_type[0]" class="card-footer">
                        <button type="button" class="btn btn-primary" @click.prevent="changeFormType([true,false])">
                            <i class="fa fa-arrow-circle-right"></i>
                            {{ trans('admin-base.btn.next') }}
                        </button>
                    </div>

                    <div v-if="form_type[1]" class="card-footer">
                        <button type="button" class="btn btn-primary" @click.prevent="storeType($event,'create_type')">
                            <i class="fa fa-download"></i>
                            {{ trans('admin-base.btn.save') }}
                        </button>
                    </div>
                </div>