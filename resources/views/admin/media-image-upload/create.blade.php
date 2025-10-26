@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.media-image-upload.actions.create'))

@section('body')

    <div class="container-xl">

                <div class="card">
        
        <media-image-upload-form
            :action="'{{ url('admin/media-image-uploads') }}'"
            v-cloak
            inline-template>

            <form class="form-horizontal form-create" method="post" @submit.prevent="onSubmit" :action="action" novalidate>
                
                <div class="card-header">
                    <i class="fa fa-plus"></i> {{ trans('admin.media-image-upload.actions.create') }}
                </div>

                <div class="card-body">
                    @include('admin.media-image-upload.components.form-elements')
                </div>
                                
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" :disabled="submiting">
                        <i class="fa" :class="submiting ? 'fa-spinner' : 'fa-download'"></i>
                        {{ trans('brackets/admin-ui::admin.btn.save') }}
                    </button>
                </div>
                
            </form>

        </media-image-upload-form>

        </div>

        </div>

    
@endsection