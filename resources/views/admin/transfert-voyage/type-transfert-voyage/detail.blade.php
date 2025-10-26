@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.type-transfert-voyage.actions.index'))

@section('styles')
<style>
    .form-_label {
        display: flex;
        margin-bottom: 20px;
    }

    .form-_label>span {
        margin-left: 1em;
        height: auto !important;
    }

    .cliquable:hover {
        cursor: pointer;
        font-weight: 600 !important;
    }
</style>
@endsection

@section('body')
<detail-type-transfert-voyage-listing :detail="{{$data->toJson()}}" :url="'{{ $data->resource_url.'?transfert='.$typeTransfertVoyage->id }}'" :action="'{{ url('admin/type-transfert-voyages') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.transfert-voyage.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.transfert-voyage.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.type-transfert-voyage.title') }}</h3>
                    </div>
                    <div class="card-body" v-cloak style="position: relative;" v-for="(item,index) in data_detail" :key="item.id">
                        <div class="my--tab">
                            <div class="item--tab" :class="pagination_[0]?'active':''" @click.prevent="nextPage([false,true])"><span>{{ trans('admin.type-transfert-voyage.actions.index') }} </span> <i v-if="pagination_[0]" class="fa fa-pencil edit" @click.prevent="editType($event,item.resource_url + '/edit')"></i> </div>
                            <div class="item--tab" :class="pagination_[1]?'active':''" @click.prevent="nextPage([true,false])"><span>{{ trans('admin.prestataire.actions.index') }}</span> <i v-if="pagination_[1]" class="fa fa-pencil edit" @click.prevent="editType($event,item.resource_url + '/edit')"></i> </div>
                        </div>
                        <div class="row">
                            <div class="col-12" v-if="pagination_[0]">
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{ trans('admin.type-transfert-voyage.columns.titre') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.titre}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{ trans('admin.type-transfert-voyage.columns.nombre_min') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.nombre_min}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{ trans('admin.type-transfert-voyage.columns.nombre_max') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.nombre_max}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{ trans('admin.type-transfert-voyage.columns.prestataire_id') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{ trans('admin.type-transfert-voyage.columns.description') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')" v-html="item.description"></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12" v-if="pagination_[1]">
                            <div class="form-_label">
                                <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.name')}} </label>
                                <span class="form-control cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.name}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="phone" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.phone')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.phone}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="email" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.email')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.email}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="second_email" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.second_email')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.second_email}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.adresse')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.adresse}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.ville')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.ville.name}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="adresse" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.pays')}} </label>
                                <span class="form-control  cliquable" @click.prevent="editType($event,item.resource_url + '/edit')">@{{item.prestataire.ville.pays.nom}}</span>
                            </div>
                            <div class="form-_label">
                                <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.prestataire.columns.logo')}} </label>
                                <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editType($event,item.resource_url + '/edit')">
                                    <span v-if="item.prestataire.logo" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                        <img :src="$isBase64(item.prestataire.logo)?item.prestataire.logo:`${urlasset}/${item.prestataire.logo}`" alt="" style="width: 100px;height: auto; margin:auto">
                                    </span>
                                    <span v-if="!item.prestataire.logo" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_type" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editType()" :adaptive="true">
            @include('admin.transfert-voyage.type-transfert-voyage.edit-detail')
        </modal>
        <modal name="create_prestataire" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.transfert-voyage.type-transfert-voyage.create-prestataire')
        </modal>
        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.transfert-voyage.type-transfert-voyage.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.transfert-voyage.type-transfert-voyage.pays')
        </modal>
    </diV>
</detail-type-transfert-voyage-listing>

@endsection