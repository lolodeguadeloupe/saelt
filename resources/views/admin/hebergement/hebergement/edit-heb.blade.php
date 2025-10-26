<div class="card">

    <form class="form-horizontal form-edit" id="edit-hebergement" method="post" @submit.prevent="storeHeb($event,'edit_hebergement')" :action="actionEditHeb" novalidate>


        <div class="card-header" style="position: relative;">
            <div v-for="(_url, item) in url_resourse_prestataire" style="position: absolute;width: 95%;height: 100%;top: 0;left: 0;display: flex;align-items: center; z-index: 0;">
                <span style="margin: auto;" data-update="" class="pointer" @click.prevent="editPrestataire($event,_url+'/edit')"><i class="fa fa-pencil" style="margin:auto;"></i> {{ trans('admin.prestataire.title') }}</span>
            </div>
            <i class="fa fa-pencil"></i> <h3>{{ trans('admin.hebergement.actions.edit') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_hebergement')"><i class="fa fa-times"></i></a>
        </div>

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

</div>