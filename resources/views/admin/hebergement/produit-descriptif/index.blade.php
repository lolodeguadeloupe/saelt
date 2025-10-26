@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.produit-descriptif.actions.index'))

@section('styles')
<style>

</style>
@endsection

@section('body')

<produit-descriptif-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/hebergement-produit-descriptifs/'.$hebergement->id.'?heb='.$hebergement->id) }}'" :action="'{{ url('admin/hebergement-produit-descriptifs') }}'" :model="{{$hebergement->toJson()}}" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.hebergement.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.hebergement.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.produit-descriptif.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="editDescriptif($event,'{{url('admin/hebergement-produit-descriptifs/'.$hebergement->id)}}')" role="button" v-if="is_edit==false"><i class="fa fa-pencil"></i>&nbsp; {{ trans('admin.produit-descriptif.actions.edit') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <div class="text-justify mx-5" style="max-inline-size: fit-content;" v-parsehtml="form.descriptif" :class="is_edit==true?'d-none':''">

                            </div>
                            <div style="max-inline-size: fit-content; min-width:inherit" v-if="is_edit==true">
                                <wysiwyg v-model="form.descriptif" :config="mediaWysiwygConfig" />
                            </div>
                        </div>
                    </div>
                    <div class="card-footer" v-if="is_edit==true">
                        <button type="button" class="btn btn-primary" @click.prevent="saveDescriptif($event,action)">
                            <i class="fa fa-download"></i>
                            {{ trans('brackets/admin-ui::admin.btn.save') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</produit-descriptif-listing>

@endsection