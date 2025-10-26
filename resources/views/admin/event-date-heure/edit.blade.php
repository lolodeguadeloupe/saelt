@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.event-date-heure.actions.edit', ['name' => $eventDateHeure->id]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <event-date-heure-form
                :action="'{{ $eventDateHeure->resource_url }}'"
                :data="{{ $eventDateHeure->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.event-date-heure.actions.edit', ['name' => $eventDateHeure->id]) }}
                    </div>

                    <div class="card-body">
                        @include('admin.event-date-heure.components.form-elements')
                    </div>
                    
                    
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary" :disabled="submiting">
                            <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                    
                </form>

        </event-date-heure-form>

        </div>
    
</div>

@endsection