@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.billeterie-maritime.actions.index'))

@section('styles')
<style>
    #billeterie_maritime_block .form-control-feedback.form-text {
        bottom: -6px !important;
    }
</style>
@endsection

@section('body')

<billeterie-maritime-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/billeterie-maritimes') }}'" :action="'{{url('admin/billeterie-maritimes') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlcompagnie="'{{url('admin/compagnie-transports')}}'" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            <div class="col-12">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i> {{ trans('admin.billeterie-maritime.actions.index') }}
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createBilleterie($event,'{{ url('admin/billeterie-maritimes/create') }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.billeterie-maritime.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
                                <div class="row justify-content-md-between">
                                    <div class="col col-lg-7 col-xl-5 form-group">
                                        <div class="input-group">
                                            <input class="form-control" placeholder="{{ trans('brackets/admin-ui::admin.placeholder.search') }}" v-model="search" @keyup.enter="filter('search', $event.target.value)" />
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

                                            <th is='sortable' :column="'id'">{{ trans('admin.billeterie-maritime.columns.id') }}</th>
                                            <th is='sortable' :column="'titre'">{{ trans('admin.billeterie-maritime.columns.titre') }}</th>
                                            <th is='sortable' :column="'date_acquisition'">{{ trans('admin.billeterie-maritime.columns.date_acquisition') }}</th>
                                            <th is='sortable' :column="'quantite'">{{ trans('admin.billeterie-maritime.columns.quantite') }}</th>
                                            <!--th is='sortable' :column="'date_depart'">{{ trans('admin.billeterie-maritime.columns.date_depart') }}</th>-->
                                            <th is='sortable' :column="'service_port.name'">{{ trans('admin.billeterie-maritime.columns.lieu_depart') }}</th>
                                            <!--<th is='sortable' :column="'date_arrive'">{{ trans('admin.billeterie-maritime.columns.date_arrive') }}</th>-->
                                            <th is='sortable' :column="'lieu_arrive_id'">{{ trans('admin.billeterie-maritime.columns.lieu_arrive') }}</th>
                                            <th is='sortable' :column="'compagnie_transport.'">{{ trans('admin.billeterie-maritime.columns.compagnie_transport_id') }}</th>
                                            <th>{{ trans('admin.billeterie-maritime.columns.planing_time') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="9">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('brackets/admin-ui::admin.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/billeterie-maritimes')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('brackets/admin-ui::admin.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('brackets/admin-ui::admin.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/billeterie-maritimes/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.id }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.titre }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.date_acquisition | date }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.quantite }}
                                            </td>
                                            <!--<td>
                                            <div class="link" @click.prevent="detail($event,item.id)"></div>
                                            @{{ item.date_depart | date }}
                                        </td>-->
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.depart.name }}
                                            </td>
                                            <!--<td>
                                            <div class="link" @click.prevent="detail($event,item.id)"></div>
                                            @{{ item.date_arrive | date }}
                                        </td>-->
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.arrive.name }}
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail($event,item.id)"></div>
                                                @{{ item.compagnie.nom }}
                                            </td>
                                            <td>
                                                <button class="btn btn-sm btn-info m-auto" type="button" @click.prevent="showPlaningTime(item)"><i class="fa fa-clock"></i></button>
                                            </td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-info" @click.prevent="detail($event,item.id)"><i class="fa fa-info"></i></button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editBilleterie($event,item.resource_url + '/edit')" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
                                                    </div>
                                                    <form class="col" @submit.prevent="deleteItem(item.resource_url)">
                                                        <button type="submit" class="btn btn-sm btn-danger" title="{{ trans('admin-base.btn.delete') }}"><i class="fa fa-trash-o"></i></button>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createBilleterie($event,'{{ url('admin/billeterie-maritimes/create') }}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.billeterie-maritime.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_billeterie" :scrollable="true" :max-width="1000" :min-width="320" height="auto" width="100%" :draggable="true" @opened="myEvent.editBilleterie()" :adaptive="true">
            @include('admin.billeterie-maritime.edit')
        </modal>

        <modal name="create_billeterie" :click-to-close="false" :scrollable="true" :max-width="1000" :min-width="320" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.billeterie-maritime.create')
        </modal>
        <modal name="create_personne" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createPersonne()" :adaptive="true">
            @include('admin.billeterie-maritime.type-personne')
        </modal>
        <modal name="create_compagnie" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createCompagnie()" :adaptive="true">
            @include('admin.billeterie-maritime.compagnie')
        </modal>

        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.billeterie-maritime.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.billeterie-maritime.pays')
        </modal>

        <modal name="create_times" :click-to-close="false" :scrollable="true" :max-width="1000" :min-width="320" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.billeterie-maritime.times')
        </modal>
    </div>
</billeterie-maritime-listing>

@endsection