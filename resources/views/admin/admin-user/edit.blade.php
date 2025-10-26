@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.admin-user.actions.edit', ['name' => $adminUser->first_name]))

@section('body')

    <div class="container-xl">

        <div class="card">

            <admin-user-form
                :action="'{{ $adminUser->resource_url }}'"
                :data="{{ $adminUser->toJson() }}"
                :activation="!!'{{ $activation }}'"
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header">
                        <i class="fa fa-pencil"></i> <h3>{{ trans('admin.admin-user.actions.edit', ['name' => $adminUser->first_name]) }}</h3>
                    </div>

                    <div class="card-body">

                        @include('admin.admin-user.components.form-elements')

                    </div>

                    <div class="card-footer">
	                    <button type="submit" class="btn btn-primary" :disabled="submiting">
		                    <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                            {{ trans('admin-base.btn.save') }}
	                    </button>
                    </div>

                </form>

        </admin-user-form>

    </div>

</div>

@endsection
