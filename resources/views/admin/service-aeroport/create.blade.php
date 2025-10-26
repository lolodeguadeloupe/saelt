               <div class="card">

                   <form class="form-horizontal form-create" id="create-service" method="post" @submit.prevent="storeService($event,'create_service')" action="{{url('admin/service-aeroports')}}" novalidate>

                       <div class="card-header">
                           <i class="fa fa-plus"></i>
                           <h3>{{ trans('admin.service-aeroport.actions.create') }}</h3>
                           <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_service')"><i class="fa fa-times"></i></a>
                       </div>

                       <div class="card-body">
                           @include('admin.service-aeroport.components.form-elements')
                       </div>

                       <div class="card-footer">
                           <button type="submit" class="btn btn-primary">
                               <i class="fa fa-download"></i>
                               {{ trans('admin-base.btn.save') }}
                           </button>
                       </div>

                   </form>
               </div>