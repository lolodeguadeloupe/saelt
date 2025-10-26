<div class="card">
    <div class="card-header">
        <i class="fa fa-plus"></i> <h3> {{ trans('admin.tarif.actions.create') }}</h3>
        <a class="float-right text-danger" style="cursor:pointer" @click.prevent="closeModal('create_tarif')"><i class="fa fa-times"></i></a>
    </div>

    <div class="card-body">
        <div v-if="condition_vol" class="content-_progres">
            <div class="line"></div>
            <div :class="form_tarif[0]?'active progres':'progres pointer'" @click.prevent="changeFormTarif([false,true])">1</div>
            <div :class="form_tarif[1]?'active progres':'progres pointer'" @click.prevent="changeFormTarif([true,false])">2</div>
        </div>
        <div :style="'display:'+ (form_tarif[0]?'contents':'none')">
            <form class="form-horizontal form-create" id="create-tarif" method="post" action="{{url('admin/tarifs')}}" novalidate v-cloak>
                @include('admin.hebergement.tarif.components.form-elements')
            </form>
        </div>
        <div :style="'display:'+ (form_tarif[1]?'contents':'none')">
            <form class="form-horizontal form-create" id="create-tarif-vol" method="post" action="{{url('admin/hebergement-vols')}}" novalidate v-cloak>
                @include('admin.hebergement.tarif.components.form-hebergement-vol')
            </form>
        </div>
    </div>

    <div v-if="(condition_vol && form_tarif[0])" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="changeFormTarif([true,false])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>
    <div v-if="((!condition_vol && form_tarif[0]) || form_tarif[1])" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="storeTarifAndVol($event,'create_tarif')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>
</div>