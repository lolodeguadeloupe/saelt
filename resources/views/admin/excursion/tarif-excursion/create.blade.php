<div class="card">


    <form class="form-horizontal form-create" id="create-tarif" method="post" @submit.prevent="storeTarif($event,'create_tarif')" action="{{url('admin/tarif-excursions')}}" novalidate>

        <div class="card-header">
            <i class="fa fa-plus"></i>
            <h3>{{ trans('admin.tarif-excursion.actions.create') }}</h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('create_tarif')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            <div class="content-_progres">
                <div class="line"></div>
                <div :class="tarif_form[0]?'progres active':'progres pointer'" @click.prevent="changeFormTarif($event,[false,true])">1 <span class="title">{{ trans('admin.tarif-excursion.columns.titre')}}</span> </div>
                <div :class="tarif_form[1]?'progres active':'progres pointer'" @click.prevent="changeFormTarif($event,[true,false])">2 <span class="title">{{ trans('admin.tarif-excursion.columns.montant')}}</span></div>
            </div>
            @include('admin.excursion.tarif-excursion.components.form-elements')
        </div>

        <div class="card-footer" v-if="tarif_form[0]">
            <button type="button" class="btn btn-primary" @click.prevent="changeFormTarif($event,[true,false])">
                <i class="fa fa-arrow-circle-right"></i>
                {{ trans('admin-base.btn.next') }}
            </button>
        </div>
        <div class="card-footer" v-if="tarif_form[1]">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>