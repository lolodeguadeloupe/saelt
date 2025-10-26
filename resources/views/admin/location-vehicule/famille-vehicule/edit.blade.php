        <div class="card">
            
                <form class="form-horizontal form-edit" id="edit-famille-vehicule" data-response="familleVehicule" method="post" @submit.prevent="storeFamilleVehicule($event,'edit_famille_vehicule')" :action="actionEditFamilleVehicule" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> 
                        <h3>{{ trans('admin.famille-vehicule.actions.edit') }}</h3>
                        <a class="float-right text-danger" style="cursor:pointer"  href="#" @click.prevent="closeModal('edit_famille_vehicule')"><i class="fa fa-times"></i></a>
                    </div>

                    <div class="card-body">
                        @include('admin.location-vehicule.famille-vehicule.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" >
                            <i class="fa fa-download"></i>
                            {{ trans('admin-base.btn.save') }}
                        </button>
                    </div>
                    
                </form>    
</div>