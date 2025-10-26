@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.tarif-transfert-voyage.actions.index'))

@section('body')

<tarif-transfert-voyage-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/tarif-transfert-voyages/'.$tranchePersonneTransfertVoyage->id.'?transfert-voyage') }}'" :action="'{{ url('admin/tarif-transfert-voyages') }}'" :urlbase="'{{base_url('')}}'"  :urlasset="'{{asset('')}}'" :tranchetransfert="{{$tranchePersonneTransfertVoyage->toJson()}}" inline-template>

    <div style="display: contents;position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.trajet-transfert-voyage.actions.index') }}</h3>
                        <a class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="$redirect(urlbase+'/admin/trajet-transfert-voyages')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.trajet-transfert-voyage.actions.create') }}</a>
                        <a style="margin-right: 20px;" class="btn btn-primary btn-sm pull-right m-b-0" href="#" @click.prevent="$redirect(urlbase+'/admin/tranche-personne-transfert-voyages/'+tranchetransfert.type.id+'?transfert-voyage')" role="button"><i class="fa fa-eye"></i>&nbsp; {{ trans('admin.type-transfert-voyage.columns.tranche-personne') }}</a>
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="" class="position-absolute w-100 right-0 px-5">
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

                            <table class="table table-hover table-listing mt-5">
                                <thead>
                                    <tr>
                                        <th is='sortable' :column="'id'">{{ trans('admin.trajet-transfert-voyage.columns.id') }}</th>
                                        <th is='sortable' :column="'titre'">{{ trans('admin.trajet-transfert-voyage.columns.titre') }}</th>
                                        <th is='sortable' :column="'lieu_transfert.titre'">{{ trans('admin.trajet-transfert-voyage.columns.point_depart') }}</th>
                                        <th is='sortable' :column="'arrive.titre'">{{ trans('admin.trajet-transfert-voyage.columns.point_arrive') }}</th>

                                        <th>{{ trans('admin.trajet-transfert-voyage.columns.tarif') }}</th>
                                    </tr>

                                </thead>
                                <tbody>
                                    <tr v-for="(item, index) in collection" :key="item.id" :class="bulkItems[item.id] ? 'bg-bulk' : ''">

                                        <td>@{{ item.id }}</td>
                                        <td>@{{ item.titre }}</td>
                                        <td>@{{ item.point_depart.titre }}</td>
                                        <td>@{{ item.point_arrive.titre }}</td>

                                        <td style="text-align: left;">
                                            <div class="row no-gutters">
                                                <div class="col-auto">
                                                    <a class="btn btn-sm btn-info" style="background-color: #4797b5;" href="#" @click.prevent="editTarif($event,urlbase+'/admin/tarif-transfert-voyages/'+tranchetransfert.id+'/'+item.id)" title="{{ trans('admin.trajet-transfert-voyage.columns.tarif') }}" role="button"><i class="fa fa-eye"></i></a>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>

                            <div class="row" v-if="pagination.state.total > 0">
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
                                <a class="btn btn-primary" href="#" @click.prevent="$redirect(urlbase+'/admin/trajet-transfert-voyages')" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.trajet-transfert-voyage.actions.create') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="create_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.createTarif()" :adaptive="true">
            @include('admin.transfert-voyage.tarif-transfert-voyage.create')
        </modal>
        <modal name="edit_tarif" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="false" @opened="myEvent.editTarif()" :adaptive="true">
            @include('admin.transfert-voyage.tarif-transfert-voyage.edit')
        </modal>

    </div>
</tarif-transfert-voyage-listing>

@endsection