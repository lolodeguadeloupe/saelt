<div class="card">
    <div style="width: 100%;padding: 10px;">
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_hebergement')"><i class="fa fa-times"></i></a>
    </div>
    <div class="tabs-_hebergement">
        <div class="items-tabs" :class="form_heb_edit[0]?'active':''" @click.prevent="editHeb($event,url_resourse_heb,[false,true],true)">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.hebergement.actions.edit') }} {{ trans('admin.hebergement.title') }}</span>
        </div>
        <div class="items-tabs" :class="form_heb_edit[1]?'active':''" @click.prevent="editPrestataire($event,`${url_resourse_prestataire}/edit`,[true,false])">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.prestataire.actions.edit') }} {{ trans('admin.prestataire.title') }}</span>
        </div>
    </div>
    <form :class="form_heb_edit[0]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-hebergement" method="post" @submit.prevent="updateHeb($event,'edit_hebergement_')" :action="actionEditHeb" novalidate>

        <div class="card-body">

            @include('admin.hebergement.hebergement.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

    <form :class="form_heb_edit[1]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-prestataire" method="post" @submit.prevent="updatePrestataire($event,'edit_hebergement')" :action="actionEditPrestataire" novalidate>
        <div class="card-body">
            @include('admin.hebergement.hebergement.components.form-prestataire')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>