           <div class="card">
               <form class="form-horizontal form-create" id="create-ile" method="post" @submit.prevent="storeIle($event,'create_ile')" action="{{url('admin/iles')}}" novalidate>

                   <div class="card-header">
                       <i class="fa fa-plus"></i>
                       <h3>{{ trans('admin.ile.actions.create') }}</h3>
                       <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_ile')"><i class="fa fa-times"></i></a>
                   </div>

                   <div class="card-body">
                       @include('admin.ile.components.form-elements')
                   </div>

                   <div class="card-footer">
                       <button type="submit" class="btn btn-primary">
                           <i class="fa fa-download"></i>
                           {{ trans('admin-base.btn.save') }}
                       </button>
                   </div>

               </form>
           </div>