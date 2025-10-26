@extends('brackets/admin-ui::admin.layout.default')

@section('title', trans('admin.media-image-upload.actions.edit', ['name' => $mediaImageUpload->name]))

@section('body')

    <div class="container-xl">
        <div class="card">

            <media-image-upload-form
                :action="'{{ $mediaImageUpload->resource_url }}'"
                :data="{{ $mediaImageUpload->toJson() }}"
                v-cloak
                inline-template>
            
                <form class="form-horizontal form-edit" method="post" @submit.prevent="onSubmit" :action="action" novalidate>


                    <div class="card-header">
                        <i class="fa fa-pencil"></i> {{ trans('admin.media-image-upload.actions.edit', ['name' => $mediaImageUpload->name]) }}
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