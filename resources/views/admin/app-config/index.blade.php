@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.prestataire.actions.index'))

@section('body')

<app-config-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/app-configs') }}'" :action="'{{ url('admin/app-configs') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> 
                        <h3>{{ trans('admin.app-config.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form method="post" id="edit-app" @submit.prevent="storeApp($event,'edit_app')" :action="actionEditApp" novalidate>
                                <div class="row">
                                    <div class="col-2"></div>
                                    <div class="col-8 border pt-5">
                                        <div class="form-group row align-items-center">
                                            <label for="nom" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.nom') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <input type="text" required readonly class="form-control" name="nom" placeholder="{{ trans('admin.app-config.columns.nom') }}">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','nom')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="adresse" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.adresse') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <input type="text" readonly class="form-control" name="adresse" placeholder="{{ trans('admin.app-config.columns.adresse') }}">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','adresse')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="telephone" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.telephone') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <input type="text" readonly class="form-control" name="telephone" pattern="^(\+?)((\d{3}|\d{2}|\d{1})?)(\s?)\d{2}(\s?)\d{2}(\s?)\d{3}(\s?)\d{2}" placeholder="{{ trans('admin.app-config.columns.telephone') }}">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','telephone')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="email" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.email') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <input type="text" readonly class="form-control" data-ctr="email" name="email" placeholder="{{ trans('admin.app-config.columns.email') }}">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','email')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="site_web" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.site_web') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <input type="text" readonly class="form-control" name="site_web" placeholder="{{ trans('admin.app-config.columns.site_web') }}">
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','site_web')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="ville_id" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.app-config.columns.ville_id') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'" class="relative">
                                                <input type="text" name="ville_id" style="display: none;">
                                                <input type="text" readonly name="ville_name" class="form-control" placeholder="{{ trans('admin.app-config.columns.ville_id') }}" v-autocompletion="autocompleteVille" :action="urlbase+'/admin/autocompletion/villes'" :autokey="'id'" :label="'name'" :inputkey="'ville_id'" :inputlabel="'ville_name'">
                                                <div id="ville-name-readonly" style="position: absolute; width: 100%; height: 100%; top: 0;left: 0;"></div>
                                            </div>
                                            <div class="col-2">
                                                <a class="btn btn-sm btn-info" @click.prevent="editApp($event,item_url + '/edit','ville_name')" href="#" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                            </div>
                                        </div>

                                        <div class="form-group row align-items-center">
                                            <label for="logo" class="col-form-label text-md-right" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.prestataire.columns.logo') }}</label>
                                            <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                                                <figure class="figure-form" v-for="(_image,_index) in logo" :key="_index+'logo'" style="height: 90px;">
                                                    <img :src="$isBase64(_image)?_image:`${urlasset}/${_image}`" alt="" style="height: 100%;width: auto;">
                                                    <span class="my-_btn-remove" @click.prevent="removeLogo(_index)">
                                                        {{trans('admin.app-config.actions.removeImage')}}
                                                    </span>
                                                    <input type="text" required class="form-control" name="logo" style="display: none;" :value="_image">
                                                </figure>
                                                <figure v-if="logo.length == 0" class="figure-form" @drop.prevent="uploadLogo($event,true)" @dragover.prevent>
                                                    <span class="my-_btn-add">
                                                        {{trans('admin.app-config.actions.uploadLogo')}}
                                                        <input type="file" multiple accept=".jpg, .jpeg, .png" @change="uploadLogo">
                                                    </span>
                                                </figure>
                                            </div>
                                        </div>
                                        <div v-if="isEdit == true" class="row justify-content-end mx-2 mb-2">
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fa fa-download"></i>
                                                {{ trans('admin-base.btn.save') }}
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-2"></div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="create_app" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.app-config.create')
        </modal>

        <modal name="edit_app" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editApp()" :adaptive="true">
            @include('admin.app-config.edit')
        </modal>
        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.app-config.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.app-config.pays')
        </modal>
    </diV>
</app-config-listing>

@endsection