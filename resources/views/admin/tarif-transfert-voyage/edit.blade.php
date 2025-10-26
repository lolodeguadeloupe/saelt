@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.tarif-transfert-voyage.actions.edit', ['name' => $tarifTransfertVoyage->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <tarif-transfert-voyage-form
                :action="'{{ $tarifTransfertVoyage->resource_url }}'"
                :data="{{ $tarifTransfertVoyage->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.tarif-transfert-voyage.actions.edit', ['name' => $tarifTransfertVoyage->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.tarif-transfert-voyage.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </tarif-transfert-voyage-form>

        </div>
    
</div>

@endsection