@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif-tranche-saison-location.actions.index'))

@section('body')

<tarif-tranche-saison-location-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/tarif-tranche-saison-locations/'.$vehicule->id) }}'" :action="'{{ url('admin/tarif-tranche-saison-locations') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :tranchesaison="{{$tranche_saison->toJson()}}" :saison="{{$saison->toJson()}}" :vehicule="{{$vehicule->toJson()}}" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.location-vehicule.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.location-vehicule.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.tarif-tranche-saison-location.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createTarif($event,'{{ url('admin/tarif-tranche-saison-locations/create/'.$vehicule->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.vehicule-location.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block" style="background-color: #f8f8f8;">
                            <div class="container m-0">
                                <div class="row">
                                    <div class="col-4">
                                        <dl class="dl-horizontal">
                                            <dt>{{ trans('admin.vehicule-location.columns.immatriculation') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->immatriculation}}</dd>
                                            <dt>{{ trans('admin.vehicule-location.columns.titre') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->titre}}</dd>
                                        </dl>
                                    </div>

                                    <div class="col-4">
                                        <dl class="dl-horizontal">
                                            <dt>{{ trans('admin.vehicule-location.columns.marque') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->marque->titre}}</dd>
                                            <dt>{{ trans('admin.vehicule-location.columns.modele') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->modele->titre}}</dd>
                                        </dl>
                                    </div>

                                    <div class="col-4">
                                        <dl class="dl-horizontal">
                                            <dt>{{ trans('admin.vehicule-location.columns.categorie_vehicule') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->categorie->titre}}</dd>
                                            <dt>{{ trans('admin.vehicule-location.columns.famille_vehicule') }}&nbsp;:</dt>
                                            <dd>{{$vehicule->categorie->famille->titre}}</dd>
                                            </dd>
                                        </dl>
                                    </div>

                                    <!--<h4 style="display: inline-block; margin-bottom: 0; ">
                                    <span>{{ trans('admin.vehicule-location.columns.immatriculation') }} &nbsp;:</span> <span>{{$vehicule->immatriculation}}</span>
                                </h4>-->
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="w-100 p-4">
                                    <div class="row border py-4 position-relative">
                                        <span class="position-absolute bg-white px-2" style="top: -14px;left: 5px;">
                                            {{trans('admin-base.filter.with')}}&nbsp;:
                                        </span>
                                        <div class="col-md-6 py-2">
                                            <div class="input-group">
                                                <span class="input-group-append">
                                                    <span style="background-color: #8080804f;padding: 5px 15px;"><i class="fa fa-filter"></i>&nbsp; {{ trans('admin.tarif-tranche-saison-location.columns.saison') }}</span>
                                                </span>
                                                <select class="form-control" v-model="data_request_customer.saisons_id">
                                                    <option :value="''"> {{ trans('admin-base.filter.all') }}</option>
                                                    <option v-for="_saisons of state_saisons" :value="_saisons.id">@{{_saisons.titre}} (@{{_saisons.debut_format}} - @{{_saisons.fin_format}})</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6 py-2">
                                            <div class="input-group">
                                                <span class="input-group-append">
                                                    <span style="background-color: #8080804f;padding: 5px 15px;"><i class="fa fa-filter"></i>&nbsp; {{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }} (Jours)</span>
                                                </span>
                                                <select class="form-control" v-model="data_request_customer.tranche_saison_id">
                                                    <option :value="''"> {{ trans('admin-base.filter.all') }}</option>
                                                    <option v-for="_tranche_saison of state_tranche_saison" :value="_tranche_saison.id">@{{_tranche_saison.titre}} (@{{_tranche_saison.nombre_min}} à @{{_tranche_saison.nombre_max}})</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="px-2">
                                    <div class="row justify-content-md-between">
                                        <div class="col col-lg-7 col-xl-5 form-group">
                                            <div class="input-group">
                                                <input class="form-control" placeholder="{{ trans('admin-base.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                                <span class="input-group-append">
                                                    <button type="button" class="btn btn-primary" @click.prevent="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('admin-base.btn.search') }}</button>
                                                </span>
                                            </div>
                                        </div>
                                        <div class="col-sm-auto form-group ">
                                            <select class="form-control" v-model="pagination.state.per_page">

                                                <option value="10">10</option>
                                                <option value="25">25</option>
                                                <option value="100">100</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>

                            <div class="content-card-body">
                                <table class="table table-hover table-listing" style="margin-top: 10rem !important;">
                                    <thead>
                                        <tr>

                                            <th is='sortable' :column="'id'" style="width: 100px;">{{ trans('admin.tarif-tranche-saison-location.columns.id') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'saisons.titre'">{{ trans('admin.tarif-tranche-saison-location.columns.saison') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'tranche_saison.titre'">{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }} (Jours)</th>
                                            <th style="width: 20%;" is='sortable' :column="'prix_achat'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'marge'">{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}</th>
                                            <th style="width: 20%;" is='sortable' :column="'prix_ventet'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                            <td>@{{ item.id }}</td>
                                            <td>@{{ item.saison.titre }} (@{{ item.saison.debut_format }} - @{{ item.saison.fin_format }})</td>
                                            <td>@{{ item.tranche_saison.titre }} (@{{item.tranche_saison.nombre_min}} à @{{item.tranche_saison.nombre_max}})</td>
                                            <td>@{{ item.prix_achat }}</td>
                                            <td>@{{ item.marge }}</td>
                                            <td>@{{item.prix_vente}}</td>
                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editTarif($event,item.resource_url+'/edit')" href="#" title="{{trans('admin-base.btn.edit')}}" role="button-detail"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <div class="row justify-content-md-between align-items-center mb-2 pt-5" v-if="pagination.state.total > 0">
                                <div class="col-sm">
                                    <span class="pagination-caption">{{ trans('admin-base.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('admin-base.index.no_items') }}</h3>
                                <p>{{ trans('admin-base.index.try_changing_items') }}</p>
                                <a class="btn btn-primary" href="#" @click.prevent="createTarif($event,'{{ url('admin/tarif-tranche-saison-locations/create/'.$vehicule->id) }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tarif-tranche-saison-location.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_tarif" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.location-vehicule.tarif-tranche-saison-location.edit')
        </modal>
        <modal name="create_tarif" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createTarif()" :adaptive="true">
            @include('admin.location-vehicule.tarif-tranche-saison-location.create')
        </modal>
    </div>
</tarif-tranche-saison-location-listing>

@endsection