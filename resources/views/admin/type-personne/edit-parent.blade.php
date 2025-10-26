       <div class="card">

           <form class="form-horizontal form-edit" id="edit-personne" method="post" @submit.prevent="storePersonne($event,'edit_personne')" :action="actionEditPersonne" novalidate>


               <div class="card-header">
                   <i class="fa fa-pencil"></i> <h3>{{ trans('admin.type-personne.actions.edit') }}</h3>
                   <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('edit_personne')"><i class="fa fa-times"></i></a>
               </div>

               <div class="card-body">
                   @include('admin.type-personne.components.form-elements-parent') 
               </div>


               <div class="card-footer">
                   <button type="submit" class="btn btn-primary">
                       <i class="fa fa-download"></i>
                       {{ trans('admin-base.btn.save') }}
                   </button>
               </div>

           </form>
       </div>