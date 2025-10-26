<div class="card">
    <div style="width: 100%;padding: 10px;">
        <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_excursion')"><i class="fa fa-times"></i></a>
    </div>
    <div class="tabs-_card"> 
        <div class="items-tabs" :class="form_excursion_edit[0]?'active':''" @click.prevent="editExcursion($event,url_resourse_excursion,[false,true],true)">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.excursion.actions.edit') }} {{ trans('admin.excursion.title') }}</span>
        </div>
        <div class="items-tabs" :class="form_excursion_edit[1]?'active':''" @click.prevent="editPrestataire($event,`${url_resourse_prestataire}/edit`,[true,false])">
            <span class="item"><i class="fa fa-pencil"></i> {{ trans('admin.prestataire.actions.edit') }} {{ trans('admin.prestataire.title') }}</span>
        </div>
    </div>
    <form :class="form_excursion_edit[0]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-excursion" method="post" @submit.prevent="updateExcursion($event,'edit_excursion')" :action="actionEditExcursion" novalidate>

        <div class="card-body">
            @include('admin.excursion.excursion.components.form-elements')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>

    <form :class="form_excursion_edit[1]?'_is_show':'_is_hide'" class="form-horizontal form-edit" id="edit-prestataire" method="post" @submit.prevent="updatePrestataire($event,'edit_excursion')" :action="actionEditPrestataire" novalidate>
        <div class="card-body">
            @include('admin.excursion.excursion.components.form-prestataire')
        </div>


        <div class="card-footer">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>