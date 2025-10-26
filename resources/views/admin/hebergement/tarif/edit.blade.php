<div class="card">
    <div class="card-header">
        <i class="fa fa-plus"></i> <h3>{{ trans('admin.tarif.actions.edit') }} {{ trans('admin.tarif.title') }}</h3>
        <a class="float-right text-danger" style="cursor:pointer" @click.prevent="closeModal('edit_tarif')"><i class="fa fa-times"></i></a>
    </div>

    <div class="card-body">
        <div v-if="condition_vol" class="content-_progres">
            <div class="line"></div>
            <div :class="form_tarif_edit[0]?'active progres':'progres pointer'" @click.prevent="editTarif($event,url_resourse_tarif,[false,true],true)">1</div>
            <div :class="form_tarif_edit[1]?'active progres':'progres pointer'" @click.prevent="editTarifVol($event,url_resourse_tarif_vol,[true,false])">2</div>
        </div>
        <div :style="'display:'+ (form_tarif_edit[0]?'contents':'none')">
            <form class="form-horizontal form-create" id="edit-tarif" method="post" :action="actionEditTarif" novalidate v-cloak>
                @include('admin.hebergement.tarif.components.form-elements')
            </form>
        </div>
        <div :style="'display:'+ (form_tarif_edit[1]?'contents':'none')">
            <form class="form-horizontal form-create" id="edit-tarif-vol" method="post" action="{{url('admin/hebergement-vols')}}" novalidate v-cloak>
                @include('admin.hebergement.tarif.components.form-hebergement-vol')
            </form>
        </div>
    </div>

    <div v-if="(condition_vol && form_tarif_edit[0])" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="editTarifVol($event,url_resourse_tarif_vol,[true,false])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>
    <div v-if="((!condition_vol && form_tarif_edit[0]) || form_tarif_edit[1])" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="updateTarifAndVol($event,'edit_tarif')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>
</div>