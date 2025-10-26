<div class="card">
    <div style="width: 100%;padding: 10px;">
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_type')"><i class="fa fa-times"></i></a>
    </div>
    <div class="tabs-_card">
        <div class="items-tabs" :class="form_type_edit[0]?'active':''" @click.prevent="editType($event,url_resourse_type,[false,true],true)">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.type-transfert-voyage.actions.edit') }} {{ trans('admin.type-transfert-voyage.title') }}</span>
        </div>
        <div class="items-tabs" :class="form_type_edit[1]?'active':''" @click.prevent="editPrestataire($event,`${url_resourse_prestataire}/edit`,[true,false])">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.prestataire.actions.edit') }} {{ trans('admin.prestataire.title') }}</span>
        </div>
    </div>


    <div class="card-body">
        <form :class="form_type_edit[0]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-type" method="post" @submit.prevent="updateType($event,'edit_type_')" :action="actionEditType" novalidate>
            @include('admin.transfert-voyage.type-transfert-voyage.components.form-elements')
        </form>
        <form :class="form_type_edit[1]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-prestataire" method="post" @submit.prevent="" :action="'#'" novalidate>
            @include('admin.transfert-voyage.type-transfert-voyage.components.form-prestataire')
        </form>
    </div>

    <div v-if="form_type_edit[0]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="editPrestataire($event,`${url_resourse_prestataire}/edit`,[true,false])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>

    <div v-if="form_type_edit[1]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="updateType($event,'edit_type')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>

    </form>
</div>