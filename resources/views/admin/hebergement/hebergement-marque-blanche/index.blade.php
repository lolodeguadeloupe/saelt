@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.hebergement-marque-blanche.actions.index'))

@section('body')

<hebergement-marque-blanche-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/hebergement-marque-blanches') }}'" :action="'{{ url('admin/hebergement-marque-blanches') }}'" :urltypeheb="'{{url('admin/type-hebergements')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>
    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.hebergement-marque-blanche.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createHebBlanche($event,url+'/create')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.hebergement-marque-blanche.actions.create') }}</a>
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

                                            <th is='sortable' :column="'id'">{{ trans('admin.hebergement-marque-blanche.columns.id') }}</th>
                                            <th is='sortable' :column="'liens'">{{ trans('admin.hebergement-marque-blanche.columns.liens') }}</th>
                                            <th is='sortable' :column="'type_hebergement.name'">{{ trans('admin.hebergement-marque-blanche.columns.type_hebergement_id') }}</th>
                                            <th is='sortable' :column="'description'">{{ trans('admin.hebergement-marque-blanche.columns.description') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="5">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/hebergement-marque-blanches')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/hebergement-marque-blanches/bulk-destroy')">{{ trans('brackets/admin-ui::admin.btn.delete') }}</button>
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
                                                <div class="link" @click.prevent="editHebBlanche($event,item.resource_url + '/edit')"></div>
                                                @{{ item.id }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editHebBlanche($event,item.resource_url + '/edit')"></div>
                                                @{{ item.liens }}

                                            </td>
                                            <td>
                                                <a :href="urltypeheb+'?search='+item.type.name">@{{ item.type.name }}</a>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="editHebBlanche($event,item.resource_url + '/edit')"></div>
                                                @{{ String(item.description??'').substr(0,30) + (String(item.description??'').length>30?' ...':'') }}
                                            </td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editHebBlanche($event,item.resource_url + '/edit')" title="{{ trans('brackets/admin-ui::admin.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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
                                    <span class="pagination-caption">{{ trans('brackets/admin-ui::admin.pagination.overview') }}</span>
                                </div>
                                <div class="col-sm-auto">
                                    <pagination></pagination>
                                </div>
                            </div>

                            <div class="no-items-found" v-if="!collection.length > 0">
                                <i class="icon-magnifier"></i>
                                <h3>{{ trans('brackets/admin-ui::admin.index.no_items') }}</h3>
                                <p>{{ trans('brackets/admin-ui::admin.index.try_changing_items') }}</p>
                                <a class="btn btn-primary" href="#" @click.prevent="createHebBlanche($event,url+'/create')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.hebergement-marque-blanche.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_hebergement_blanche" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editHebBlanche()" :adaptive="true">
            @include('admin.hebergement.hebergement-marque-blanche.edit')
        </modal>

        <modal name="create_hebergement_blanche" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement-marque-blanche.create')
        </modal>

        <modal name="create_type_hebergement" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.hebergement.hebergement-marque-blanche.type')
        </modal>
    </diV>
</hebergement-marque-blanche-listing>

@endsection