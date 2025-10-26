@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.agence-location.actions.index'))

@section('body')

<agence-location-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/agence-locations') }}'" :action="'{{ url('admin/agence-locations') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.agence-location.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="createAgence($event,'{{url('admin/agence-locations/create')}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.agence-location.actions.create') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block position-relative">
                            <form @submit.prevent="" class="w-100">
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
                            </form>

                            <div class="content-card-body">
                                <table class="table table-hover table-listing mt-5">
                                    <thead>
                                        <tr>
                                            <th class="bulk-checkbox">
                                                <input class="form-check-input" id="enabled" type="checkbox" v-model="isClickedAll" v-validate="''" data-vv-name="enabled" name="enabled_fake_element" @click.prevent="onBulkItemsClickedAllWithPagination()">
                                                <label class="form-check-label" for="enabled">
                                                </label>
                                            </th>

                                            <th is='sortable' :column="'id'">{{ trans('admin.agence-location.columns.id') }}</th>
                                            <th is='sortable' :column="'name'">{{ trans('admin.agence-location.columns.name') }}</th>
                                            <th is='sortable' :column="'code_agence'">{{ trans('admin.agence-location.columns.code_agence') }}</th>
                                            <th is='sortable' :column="'adresse'">{{ trans('admin.agence-location.columns.adresse') }}</th>
                                            <th is='sortable' :column="'phone'">{{ trans('admin.agence-location.columns.phone') }}</th>
                                            <th is='sortable' :column="'email'">{{ trans('admin.agence-location.columns.email') }}</th>
                                            <th is='sortable' :column="'ville_id'">{{ trans('admin.agence-location.columns.ville_id') }}</th>
                                            <th is='sortable' :column="'heure_ouverture'">{{ trans('admin.agence-location.columns.heure_ouverture') }}</th>
                                            <th is='sortable' :column="'heure_fermeture'">{{ trans('admin.agence-location.columns.heure_fermeture') }}</th>

                                            <th></th>
                                        </tr>
                                        <tr v-show="(clickedBulkItemsCount > 0) || isClickedAll">
                                            <td class="bg-bulk-info d-table-cell text-center" colspan="11">
                                                <span class="align-middle font-weight-light text-dark">{{ trans('admin-base.listing.selected_items') }} @{{ clickedBulkItemsCount }}. <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAll('/admin/agence-locations')" v-if="(clickedBulkItemsCount < pagination.state.total)"> <i class="fa" :class="bulkCheckingAllLoader ? 'fa-spinner' : ''"></i> {{ trans('admin-base.listing.check_all_items') }} @{{ pagination.state.total }}</a> <span class="text-primary">|</span> <a href="#" class="text-primary" @click.prevent="onBulkItemsClickedAllUncheck()">{{ trans('admin-base.listing.uncheck_all_items') }}</a> </span>

                                                <span class="pull-right pr-2">
                                                    <button class="btn btn-sm btn-danger pr-3 pl-3" @click.prevent="bulkDelete(urlbase+'/admin/agence-locations/bulk-destroy')">{{ trans('admin-base.btn.delete') }}</button>
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
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.id }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span> @{{ item.name }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.code_agence }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.adresse }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.phone }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.email }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.ville.name }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.heure_ouverture }}</span>
                                            </td>
                                            <td>
                                                <div class="link" @click.prevent="detail(item.id)"></div>
                                                <span>@{{ item.heure_fermeture }}</span>
                                            </td>

                                            <td>
                                                <div class="row no-gutters">
                                                    <div class="col-auto">
                                                        <button type="button" class="btn btn-sm btn-info" @click.prevent="detail(item.id)"><i class="fa fa-info"></i></button>
                                                    </div>
                                                    <div class="col-auto">
                                                        <a class="btn btn-sm btn-info" @click.prevent="editAgence($event,action+'/'+item.id + '/edit')" href="#" title="{{ trans('admin-base.btn.edit') }}" role="button"><i class="fa fa-edit"></i></a>
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
                                <a class="btn btn-primary" href="#" @click.prevent="createAgence($event,'{{url('admin/agence-locations/create')}}')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.agence-location.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="edit_agence" :min-width="320" :scrollable="true" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.editAgence()" :adaptive="true">
            @include('admin.location-vehicule.agence-location.edit')
        </modal>
        <modal name="create_agence" :min-width="320" :scrollable="true" :max-width="1000" height="auto" width="100%" :draggable="true" @opened="myEvent.createAgence()" :adaptive="true">
            @include('admin.location-vehicule.agence-location.create')
        </modal>
        <modal name="create_ville" :scrollable="true" :min-width="320" :max-width="600" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.agence-location.ville')
        </modal>

        <modal name="create_pays" :scrollable="true" :min-width="320" :max-width="500" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.agence-location.pays')
        </modal>

        <modal name="calendar" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">
            @include('admin.location-vehicule.agence-location.calendar')
        </modal>
        <modal name="calendar-edit" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">

            <div class="card" style="max-width: max-content;">
                <div class="card-body modifier-data-calendar-table">
                    <a class="float-right text-danger" style="cursor:pointer;" @click.prevent="closeModal('calendar-edit')"><i class="fa fa-times"></i></a>
                    <table>
                        <thead>
                            <tr>
                                <th>{{ trans('admin.event-date-heure.columns.status') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.date') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.time_start') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.time_end') }}</th>
                                <th>{{ trans('admin.event-date-heure.columns.description') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(calendar_item,index) in dataCalendarModifier">
                                <td>@{{calendar_item.etat}}</td>
                                <td>@{{calendar_item.date | date}}</td>
                                <td>@{{calendar_item.time_start}}</td>
                                <td>@{{calendar_item.time_end}}</td>
                                <td>@{{calendar_item.description}}</td>
                                <td>
                                    <div class="row no-gutters">
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-danger" @click.prevent="deleteCalendar($event,calendar_item,index)" href="#" title="{{ trans('admin-base.btn.delete') }}" role="button"><i class="fa fa-trash-o"></i></a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </modal>
    </div>
</agence-location-listing>

@endsection