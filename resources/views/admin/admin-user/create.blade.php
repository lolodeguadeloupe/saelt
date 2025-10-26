@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.admin-user.actions.create'))

@section('body')

    <div class="container-xl">

        <div class="card">

            <admin-user-form
                :action="'{{ url('admin/admin-users') }}'"
                :activation="!!'{{ $activation }}'"
                
                inline-template>

                <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action">

                    <div class="card-header">
                        <i class="fa fa-plus"></i> <h3>{{ trans('admin.admin-user.actions.create') }}</h3>
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
