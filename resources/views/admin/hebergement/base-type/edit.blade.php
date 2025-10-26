      <div class="card">

          <form class="form-horizontal form-edit"  id="edit-base-type" method="post" @submit.prevent="storeBaseType($event,'edit_base_type')" :action="actionEditBaseType" novalidate>


              <div class="card-header">
                  <i class="fa fa-pencil"></i> <h3>{{ trans('admin.base-type.actions.edit') }}</h3>
                  <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('edit_base_type')"><i class="fa fa-times"></i></a>
              </div>

              <div class="card-body">
                  @include('admin.hebergement.base-type.components.form-elements')
              </div>


              <div class="card-footer">
                  <button type="submit" class="btn btn-primary">
                      <i class="fa fa-download"></i>
                      {{ trans('admin-base.btn.save') }}
                  </button>
              </div>

          </form>

      </div>