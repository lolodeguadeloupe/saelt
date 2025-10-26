@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.island.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <island-form
            :action="'{{ url('admin/islands') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> <h3>{{ trans('admin.island.actions.create') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" href="{{route('admin/islands/index')}}"><i class="fa fa-times"></i></a>
                </div>

                <div class="card-body">
                    @include('admin.island.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>
                
            </form>

        </island-form>

        </div>

        </div>

    
@endsection