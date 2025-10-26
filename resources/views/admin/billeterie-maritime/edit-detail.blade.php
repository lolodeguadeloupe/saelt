<div class="card">

    <form class="form-horizontal form-edit" id="edit-billeterie" method="post" @submit.prevent="storeBilleterie($event,'edit_billeterie')" :action="actionEditBilleterie" novalidate>


        <div class="card-header">
            <i class="fa fa-pencil"></i>
            <h3>
                {{ trans('admin.billeterie-maritime.actions.edit') }}
            </h3>
            <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('edit_billeterie')"><i class="fa fa-times"></i></a>
        </div>

        <div class="card-body">
            <div class="content-_progres">
                <div class="line"></div>
                <div :class="billeterie_form[0]?'progres active':'progres pointer'" @click.prevent="changeFormBilleterie($event,[false,true])">1 <span class="title">{{ trans('admin.billeterie-maritime.columns.titre')}}</span> </div>
                <div :class="billeterie_form[1]?'progres active':'progres pointer'" @click.prevent="changeFormBilleterie($event,[true,false])">2 <span class="title">{{ trans('admin.billeterie-maritime.columns.tarif')}}</span></div>
            </div>
            @include('admin.billeterie-maritime.components.form-elements')
        </div>


        <div class="card-footer" v-if="billeterie_form[0]">
            <button type="button" class="btn btn-primary" @click.prevent="changeFormBilleterie($event,[true,false])">
                <i class="fa fa-arrow-circle-right"></i>
                {{ trans('admin-base.btn.next') }}
            </button>
        </div>
        <div class="card-footer" v-if="billeterie_form[1]">
            <button type="submit" class="btn btn-primary">
                <i class="fa fa-download"></i>
                {{ trans('admin-base.btn.save') }}
            </button>
        </div>

    </form>
</div>