 <div class="card">
     <form class="form-horizontal form-create" id="create-compagnie" method="post" @submit.prevent="storeCompagnieExcursion($event,'create_compagnie')" action="{{url('admin/compagnie-liaison-excursions')}}" novalidate>

         <div class="card-header">
             <i class="fa fa-plus"></i>
             <h3>{{ trans('admin.compagnie-liaison-excursion.actions.create') }}</h3> 
         </div>

         <div class="card-body">
             @include('admin.excursion.compagnie-liaison-excursion.components.form-elements')
         </div>

         <div class="card-footer">
             <button type="submit" class="btn btn-primary">
                 <i class="fa fa-download"></i>
                 {{ trans('admin-base.btn.save') }}
             </button>
         </div>

     </form>

 </div>