@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.allotement.actions.index'))


@section('body')

<allotement-listing :data="{{ $data->toJson() }}" :action="'{{ url('admin/allotements') }}'" :url="'{{ url('admin/allotements') }}'" :urlcompagnie="'{{url('admin/compagnie-transports')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            @include('admin.hebergement.view-header.header')
        </div>
        <div class="row has--child-nav">
            <div class="col-2 child-_nav" style="height: auto !important;">
                @include('admin.hebergement.view-header.nav-child')
            </div>
            <div class="col-10 content-_nav">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.allotement.actions.index') }}
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createAllotement($event,'{{url('admin/allotements/create')}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.allotement.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
                                            <span class="input-group-append">
                                                <button type="button" class="btn btn-primary" @click.prevent="filter('search', search)"><i class="fa fa-search"></i>&nbsp; {{ trans('brackets/admin-ui::admin.btn.search') }}</button>
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

                            <div class="content-card-body">
                                <table class="table table-hover table-listing mt-5">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                    #
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.allotement.columns.id') }}</th>
                                            <th is='sortable' :column="'titre'">{{ trans('admin.allotement.columns.titre') }}</th>
                                            <th is='sortable' :column="'quantite'">{{ trans('admin.allotement.columns.quantite') }}</th>
                                            <th is='sortable' :column="'date_depart'">{{ trans('admin.allotement.columns.date_depart') }}</th>
                                            <th is='sortable' :column="'heure_depart'">{{ trans('admin.allotement.columns.heure_depart') }}</th>
                                            <th is='sortable' :column="'date_arrive'">{{ trans('admin.allotement.columns.date_arrive') }}</th>
                                            <th is='sortable' :column="'heure_depart'">{{ trans('admin.allotement.columns.heure_arrive') }}</th>
                                            <th is='sortable' :column="'date_acquisition'">{{ trans('admin.allotement.columns.date_acquisition') }}</th>
                                            <th is='sortable' :column="'date_limite'">{{ trans('admin.allotement.columns.date_limite') }}</th>
                                            <th is='sortable' :column="'compagnie_transport.nom'">{{ trans('admin.allotement.columns.compagnie_transport_id') }}</th>
                                            <th is='sortable' :column="'service_aeroport.name'">{{ trans('admin.allotement.columns.lieu_depart') }}</th>
                                            <th is='sortable' :column="'lieu_arrive_id'">{{ trans('admin.allotement.columns.lieu_arrive') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="14">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/allotements')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/allotements/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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

                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.id }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.titre }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.quantite }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.date_depart | date }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.heure_depart | time }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.date_arrive | date }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.heure_arrive | time }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.date_acquisition | date }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editAllotement($event,item.resource_url + '/edit')"></div>
                                                @{{ item.date_limite | date }}
                                            </td>
                                            <td>
                                                <a :href="urlcompagnie+'?search='+item.compagnie.nom">@{{ item.compagnie.nom }}</a>
                                            </td>
                                            <td>
                                                <a :href="urlbase+'/admin/service-aeroports?search='+item.depart.code_service">@{{ item.depart.name }}</a>
                                            </td>
                                            <td>
                                                <a :href="urlbase+'/admin/service-aeroports?search='+item.arrive.code_service">@{{ item.arrive.name }}</a>
                                            </td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editAllotement($event,item.resource_url + '/edit')" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('brackets/admin-ui::admin.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
                                                    </form>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createAllotement($event,'{{url('admin/allotements/create')}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.allotement.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_allotement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editAllotement()" :adaptive="true">
            @include('admin.hebergement.allotement.edit')
        </modal>
        <modal name="create_allotement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createAllotement()" :adaptive="true">
            @include('admin.hebergement.allotement.create')
        </modal>

        <modal name="create_compagnie" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createCompagnie()" :adaptive="true">
            @include('admin.hebergement.allotement.compagnie')
        </modal>

        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.allotement.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.allotement.pays')
        </modal>
    </div>
</allotement-listing>

@endsection