@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.agence-location.actions.index'))

@section('body')
<detail-agence-location-listing :detail="{{$data}}" :datacalendar="{{$agenceLocation->calendar->toJson()}}" :url="'{{ $agenceLocation->resource_url }}'" :action="'{{url('admin/agence-locations') }}'" :urlbase="'{{base_url('')}}'"  :urlasset="'{{asset('')}}'" :urlcalendar="'{{url('admin/event-date-heures')}}'" inline-template>
    <div style="display: contents;position:relative">
        <div class="row ">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.agence-location.actions.index') }}</h3>
                    </div>
                    <div class="card-body" v-cloak style="position: relative;" v-for="(item,index) in data_detail" :key="item.id">

                        <div class="row">
                            <div class="col-12">

                                <div class="form-_label">
                                    <label for="immatriculation" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.name') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.name}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="title" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.code_agence') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.code_agence}}</span>
                                </div>
                                <div class="form-_label"> 
                                    <label for="marque" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.adresse') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.adresse}}</span>
                                </div>
                                <div class="form-_label">
                                    <label for="modele" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.phone') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.phone}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="categorie_vehicule_id" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.email') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.email}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="date_ouverture" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.ville_id') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.ville.name}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="heure_ouverture" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.heure_ouverture') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.heure_ouverture}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="heure_fermeture" class="col-form-label text-md-right col-md-3">{{ trans('admin.agence-location.columns.heure_fermeture') }} </label>
                                    <span class="form-control cliquable" @click.prevent="editAgence($event,item.resource_url + '/edit')">@{{item.heure_fermeture}}</span>
                                </div>

                                <div class="form-_label">
                                    <label for="name" class="col-form-label text-md-right col-md-3">{{trans('admin.agence-location.columns.logo')}} </label>
                                    <span class="form-control  cliquable" style="padding-right: 0.75rem !important;padding-left: 0.75rem !important;" @click.prevent="editAgence($event,item.resource_url + '/edit')">
                                        <span v-if="item.logo" style="display: inline-block; width: calc((50% + 0.5em) - 0.75rem); margin: 0;padding: 5px;">
                                            <img :src="$isBase64(item.logo)?item.logo:`${urlasset}/${item.logo}`" alt="image" style="width: 100px;height: auto; margin:auto">
                                        </span>
                                        <span v-if="!item.logo" style="display: flex; align-items: center;"><i class="image-no-found"></i>@{{$dictionnaire.no_image_avaible}}</span>
                                    </span>
                                </div>

                                <div class="form-_label">
                                    <label for="calendar" class="col-form-label text-md-right col-md-3">{{trans('admin.agence-location.columns.calendar')}} </label>
                                    <span class="form-control  cliquable" style="padding: 0 !important; border-width: 0 !important;">
                                        <v-calendar :attributes="calendaralldates" is-expanded />
                                    </span>
                                </div>
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
</detail-agence-location-listing>

@endsection