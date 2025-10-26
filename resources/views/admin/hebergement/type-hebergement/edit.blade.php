        <div class="card">

            <form class="form-horizontal form-edit" id="edit-type" method="post" @submit.prevent="storeType($event,'edit_type')" :action="actionEditType" novalidate>


                <div class="card-header">
                    <i class="fa fa-pencil"></i> <h3>{{ trans('admin.type-hebergement.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" @click.prevent="closeModal('edit_type')"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.hebergement.type-hebergement.components.form-elements')
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>

        </div>