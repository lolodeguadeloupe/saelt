@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.itineraire-description-excursion.actions.index'))

@section('styles')
<style>

</style>
@endsection

@section('body')

<itineraire-description-excursion-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/itineraire-description-excursions/'.$excursion->id.'?excursion='.$excursion->id) }}'" :model="{{$excursion->toJson()}}" :action="'{{ url('admin/itineraire-description-excursions') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.excursion.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.excursion.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.itineraire-description-excursion.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="editDescription($event,'{{url('admin/itineraire-description-excursions/'.$excursion->id)}}')" role="button" v-if="is_edit==false"><i class="fa fa-pencil"></i>&nbsp; {{ trans('admin.itineraire-description-excursion.actions.edit') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="text-justify mx-5" style="max-inline-size: fit-content;" v-parsehtml="form.description" :class="is_edit==true?'d-none':''">

                            </div>
                            <div style="max-inline-size: fit-content; min-width:inherit" v-if="is_edit==true">
                                <wysiwyg v-model="form.description" :config="mediaWysiwygConfig" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" v-if="is_edit==true">
                        <button type="button" class="btn btn-primary" @click.prevent="saveDescription($event,action)">
                            <i class="fa fa-download"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</itineraire-description-excursion-listing>

@endsection