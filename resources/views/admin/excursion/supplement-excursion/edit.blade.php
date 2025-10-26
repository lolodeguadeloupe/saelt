     <div class="card">

         <form class="form-horizontal form-edit" id="edit-supplement" method="post" @submit.prevent="storeSupplement($event,'edit_supplement')" :action="actionEditSupplement" novalidate>


             <div class="card-header">
                 <i class="fa fa-pencil"></i>
                 <h3>
                     {{ trans('admin.supplement-excursion.actions.edit') }}
                 </h3>
                 <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_supplement')"><i class="fa fa-times"></i></a>
             </div>

             <div class="card-body">
                 <div class="content-_progres">
                     <div class="line"></div>
                     <div :class="supplement_form[0]?'progres active':'progres pointer'" @click.prevent="changeFormSupplement($event,[false,true])">1 <span class="title">{{ trans('admin.supplement-excursion.columns.titre')}}</span> </div>
                     <div :class="supplement_form[1]?'progres active':'progres pointer'" @click.prevent="changeFormSupplement($event,[true,false])">2 <span class="title">{{ trans('admin.supplement-excursion.columns.tarif')}}</span></div>
                 </div>
                 @include('admin.excursion.supplement-excursion.components.form-elements')
             </div>


             <div class="card-footer" v-if="supplement_form[0]">
                 <button type="button" class="btn btn-primary" @click.prevent="changeFormSupplement($event,[true,false])">
                     <i class="fa fa-arrow-circle-right"></i>
                     {{ trans('admin-base.btn.next') }}
                 </button>
             </div>
             <div class="card-footer" v-if="supplement_form[1]">
                 <button type="submit" class="btn btn-primary">
                     <i class="fa fa-download"></i>
                     {{ trans('admin-base.btn.save') }}
                 </button>
             </div>

         </form>
     </div>