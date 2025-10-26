<div class="card">

    <div class="card-header">
        <i class="fa fa-plus"></i> {{ trans('admin.vehicule-location.actions.create') }}
        <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_vehicule')"><i class="fa fa-times"></i></a>
    </div>

    <div class="card-body">
        <div class="content-_progres">
            <div class="line"></div>
            <div :class="form_vehicule[0]?'progres active':'progres pointer'" @click.prevent="changeFormVehicule([true,false,false])">1 <span class="title">{{ trans('admin.prestataire.title')}}</span> </div>
            <div :class="form_vehicule[1]?'progres active':'progres pointer'" @click.prevent="changeFormVehicule([false,true,false])">2 <span class="title">{{ trans('admin.vehicule-location.title')}}</span></div>
            <div :class="form_vehicule[2]?'progres active':'progres pointer'" @click.prevent="changeFormVehicule([false,false,true])">2 <span class="title">{{ trans('admin.vehicule-location-info-tech.title')}}</span></div>
        </div>
        <form :style="'display:'+(form_vehicule[0]?'block':'none')" class="form-horizontal form-create" id="create-prestataire" data-response="prestataire" method="post" @submit.prevent="storePrestataire($event)" action="{{url('admin/prestataires')}}" novalidate v-cloak>
            @include('admin.location-vehicule.vehicule-location.components.form-prestataire')
        </form>
        <form :style="'display:'+ (form_vehicule[1]?'block':'none')" class="form-horizontal form-create" id="create-vehicule" method="post" novalidate v-cloak>
            @include('admin.location-vehicule.vehicule-location.components.form-elements')
        </form>
        <form :style="'display:'+ (form_vehicule[2]?'block':'none')" class="form-horizontal form-create" id="create-info-tech" method="post" novalidate v-cloak>
            @include('admin.location-vehicule.vehicule-location.components.form-info-tech')
        </form>
    </div>

    <div v-if="form_vehicule[0]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="changeFormVehicule([false,true,false])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>
    <div v-if="form_vehicule[1]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="changeFormVehicule([false,false,true])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>

    <div v-if="form_vehicule[2]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="storeVehicule($event,'create_vehicule')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>
</div>