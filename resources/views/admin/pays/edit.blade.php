       <div class="card">
           <form class="form-horizontal form-edit" id="edit-pays" data-response="pays" method="post" @submit.prevent="storePays($event,'edit_pays')" :action="actionEditPays"  novalidate>


               <div class="card-header">
                   <i class="fa fa-pencil"></i>
                   <h3>{{ trans('admin.pays.actions.edit') }}</h3>
                   <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_pays')"><i class="fa fa-times"></i></a>
               </div>

               <div class="card-body">
                   @include('admin.pays.components.form-elements')
               </div>


               <div class="card-footer">
                   <button type="submit" class="btn btn-primary">
                       <i class="fa fa-download"></i>
                       {{ trans('admin-base.btn.save') }}
                   </button>
               </div>

           </form>
       </div>