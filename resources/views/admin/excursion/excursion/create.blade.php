<div class="card">

    <div class="card-header">
        <i class="fa fa-plus"></i> {{ trans('admin.excursion.actions.create') }}
        <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('create_excursion')"><i class="fa fa-times"></i></a>
    </div>

    <div class="card-body">
        <div class="content-_progres">
            <div class="line"></div>
            <div :class="form_excursion[0]?'progres active':'progres pointer'" @click.prevent="changeFormExcursion([false,true])">1 <span class="title">{{ trans('admin.prestataire.title')}}</span> </div>
            <div :class="form_excursion[1]?'progres active':'progres pointer'" @click.prevent="changeFormExcursion([true,false])">2 <span class="title">{{ trans('admin.excursion.title')}}</span></div>
        </div>
        <form :style="'display:'+(form_excursion[0]?'block':'none')" class="form-horizontal form-create" id="create-prestataire" data-response="prestataire" method="post" @submit.prevent="storePrestataire($event)" action="{{url('admin/prestataires')}}" novalidate v-cloak>
            @include('admin.excursion.excursion.components.form-prestataire')
        </form>
        <form :style="'display:'+ (form_excursion[1]?'block':'none')" class="form-horizontal form-create" id="create-excursion" method="post" @submit.prevent="storeHeb($event,'create_excursion')" action="{{url('admin/excursions')}}" novalidate v-cloak>
            @include('admin.excursion.excursion.components.form-elements')
        </form>
    </div>

    <div v-if="form_excursion[0]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="changeFormExcursion([true,false])">
            <i class="fa fa-arrow-circle-right"></i>
            {{ trans('admin-base.btn.next') }}
        </button>
    </div>

    <div v-if="form_excursion[1]" class="card-footer">
        <button type="button" class="btn btn-primary" @click.prevent="storeExcursion($event,'create_excursion')">
            <i class="fa fa-download"></i>
            {{ trans('admin-base.btn.save') }}
        </button>
    </div>
</div>