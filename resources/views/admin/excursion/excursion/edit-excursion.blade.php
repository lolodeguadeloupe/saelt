<div class="card">

    <form class="form-horizontal form-edit" id="edit-excursion" method="post" @submit.prevent="storeExcursion($event,'edit_excursion')" :action="actionEditExcursion" novalidate>


        <div class="card-header" style="position: relative;">
            <div v-if="url_resourse_prestataire" style="position: absolute;width: 95%;height: 100%;top: 0;left: 0;display: flex;align-items: center; z-index: 0;">
               <span style="margin: auto;" data-update="" class="pointer" @click.prevent="editPrestataire($event,url_resourse_prestataire+'/edit')"><i class="fa fa-pencil" style="margin:auto;"></i> {{ trans('admin.prestataire.title') }}</span>
            </div>
            <i class="fa fa-pencil"></i>
            <h3>{{ trans('admin.excursion.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_excursion')"><i class="fa fa-times"></i></a>
        </div>

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

</div>