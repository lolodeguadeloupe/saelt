@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tranche-personne-transfert-voyage.actions.index'))

@section('body')

<tranche-personne-transfert-voyage-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/tranche-personne-transfert-voyages?transfert='.$typeTransfertVoyage->id) }}'" :typetransfertvoyage="{{$typeTransfertVoyage->toJson()}}" :action="'{{ url('admin/tranche-personne-transfert-voyages?transfert='.$typeTransfertVoyage->id) }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

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
                        <h3>{{ trans('admin.tranche-personne-transfert-voyage.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-6 col-xl-5 form-group">
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
                            </form>
                            <form id="tranche-personne-transfert-voyage" method="post" @submit.prevent="storeTranche($event)" :action="actionFormUrlTranche">
                                <div class="content-card-body">
                                    <table class="table table-hover table-listing mt-5">
                                        <thead>
                                            <tr>
                                                <th class="bulk-checkbox">
                                                    <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                    <label class="form-check-label" for="enabled">
                                                    </label>
                                                </th>

                                                <th is='sortable' :column="'id'" style="width: 15%;">{{ trans('admin.tranche-personne-transfert-voyage.columns.id') }}</th>
                                                <th is='sortable' :column="'titre'" style="width: 25%;">{{ trans('admin.tranche-personne-transfert-voyage.columns.titre') }}</th>
                                                <th is='sortable' :column="'type.titre'" style="width: 25%;">{{ trans('admin.tranche-personne-transfert-voyage.columns.type_transfert_id') }}</th>
                                                <th is='sortable' :column="'nombre_min'" style="width: 15%;">{{ trans('admin.tranche-personne-transfert-voyage.columns.nombre_min') }}</th>
                                                <th is='sortable' :column="'nombre_max'" style="width: 15%;">{{ trans('admin.tranche-personne-transfert-voyage.columns.nombre_max') }}</th>

                                                <th style="width: 20%;"></th>
                                            </tr>
                                            <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                                <td class="bg-bulk-info d-table-cell text-center" colspan="7">
                                                    <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/tranche-personne-transfert-voyages')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                    <span class="pull-right pr-2">
                                                        <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/tranche-personne-transfert-voyages/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
                                                    </span>

                                                </td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">
                                                <td class="bulk-checkbox">
                                                    <input class="form-check-input" :id="'enabled' + item.id" type="checkbox" v-model="bulkItems[item.id]" v-validate="''" :data-vv-name="'enabled' + item.id" :name="'enabled' + item.id + '_fake_element'" @click.prevent="onBulkItemClicked(item.id)" :disabled="bulkCheckingAllLoader">
                                                    <label class="form-check-label" :for="'enabled' + item.id">
                                                    </label>
                                                </td>

                                                <td :id="'liste-id-'+item.id">@{{ item.id }}</td>
                                                <td :id="'liste-titre-'+item.id">@{{ item.titre }}</td>
                                                <td :id="'liste-type_transfert_titre-'+item.id">@{{ item.type.titre }}</td>
                                                <td :id="'liste-nombre_min-'+item.id">@{{ item.nombre_min }} Pers.</td>
                                                <td :id="'liste-nombre_max-'+item.id">@{{ item.nombre_max }} Pers.</td>

                                                <td :id="'liste-modif-'+item.id">
                                                    <div class="row no-gutters">
                                                        <div class="col-auto">
                                                            <a class="btn btn-sm btn-info" @click.prevent="editTranche($event,item.resource_url+'/edit',item.id)" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                        </div>
                                                        <div class="col">
                                                            <button type="button" @click.prevent="deleteTranche($event,item.resource_url)" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-if="actionForm">
                                                <td></td>
                                                <td>
                                                    <div style="position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white">
                                                        <div class="form-group row align-items-center" style="margin: auto;margin-left: 0;width: 100%;">
                                                            <div class="col-12">
                                                                <input type="text" readonly class="form-control" name="id" placeholder="{{ trans('admin.tranche-personne-transfert-voyage.columns.id') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                                <td>
                                                    <div style="position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white">
                                                        <div class="form-group row align-items-center" style="margin: auto;margin-left: 0;width: 100%;">

                                                            <div class="col-12">
                                                                <input type="text" required class="form-control" name="titre" placeholder="{{ trans('admin.tranche-personne-transfert-voyage.columns.titre') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white">
                                                        <div class="form-group row align-items-center" style="margin: auto;margin-left: 0;width: 100%;">

                                                            <div class="col-12">
                                                                <input type="text" required name="type_transfert_id" value="{{$typeTransfertVoyage->id}}" style="display: none;">
                                                                <input type="text" required readonly name="type_transfert_titre" class="form-control" placeholder="{{ trans('admin.tranche-personne-transfert-voyage.columns.type_transfert_id') }}" value="{{$typeTransfertVoyage->titre}}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white">
                                                        <div class="form-group row align-items-center" style="margin: auto;margin-left: 0;width: 100%;">

                                                            <div class="col-12">
                                                                <input type="number" required class="form-control" name="nombre_min" placeholder="{{ trans('admin.tranche-personne-transfert-voyage.columns.nombre_min') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div style="position:absolute; top:0; left:0;width:100%;height:100%;display:flex;align-items:center;background-color:white">
                                                        <div class="form-group row align-items-center" style="margin: auto;margin-left: 0;width: 100%;">

                                                            <div class="col-12">
                                                                <input type="number" required class="form-control" name="nombre_max" placeholder="{{ trans('admin.tranche-personne-transfert-voyage.columns.nombre_max') }}">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td colspan="2">
                                                    <div class="row no-gutters">
                                                        <button type="submit" class="btn btn-primary" style="display: flex;align-items: center;width: max-content;">
                                                            <i class="fa fa-download"></i> &nbsp;
                                                            {{ trans('admin-base.btn.save') }}
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>
                                            <tr v-if="!actionForm">
                                                <td colspan="8" style="display: table-cell !important;">
                                                    <a class="btn btn-primary" href="#" @click.prevent="createTranche" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.tranche-personne-transfert-voyage.actions.create') }}</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </form>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</tranche-personne-transfert-voyage-listing>

@endsection