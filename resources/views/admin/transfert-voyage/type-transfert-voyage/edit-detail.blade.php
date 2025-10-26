<div class="card">
    <div style="width: 100%;padding: 10px;">
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_type')"><i class="fa fa-times"></i></a>
    </div>
    <div class="card-body">
        <form :class="pagination_[0]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-type" method="post" @submit.prevent="updateType($event,'edit_type_')" :action="actionEditType" novalidate>
            @include('admin.transfert-voyage.type-transfert-voyage.components.form-elements')
        </form>
        <form :class="pagination_[1]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-prestataire" method="post" @submit.prevent="" :action="'#'" novalidate>
            @include('admin.transfert-voyage.type-transfert-voyage.components.form-prestataire')
        </form>
    </div>

    <div  class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="storeType($event,'edit_type')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>

    </form>
</div>