@extends('admin.customer-layout.layout.default')

@section('title', trans('admin.planing-vehicule.actions.index'))

@section('body')

<planing-vehicule-listing :data="{{ $data->toJson() }}" :url="'{{ url('admin/planing-vehicules') }}'" :action="'{{ url('admin/planing-vehicules') }}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" inline-template>

    <diV style="display:contents; position:relative">
        <div class="row">
            <div class="col">
                <div class="card position-relative">
                    <div class="card-header">
                        <i class="fa fa-align-justify"></i>
                        <h3>{{ trans('admin.planing-vehicule.actions.index') }}</h3>
                        <!--<button class="btn btn-primary btn-sm pull-right m-b-0" href="#" role="button"><i class="fa fa-plus"></i>&nbsp; {{ trans('admin.planing-vehicule.actions.create') }}</button>-->
                    </div>
                    <div class="card-body" v-cloak>
                        <div class="card-block">
                            <form @submit.prevent="">
                                <div class="card">
                                    <div class="card-header border">
                                        <div class="row px-3">
                                            <div class="d-flex align-items-center pr-4 my-1">
                                                <span style="color: black;">Filtre par </span>
                                            </div>
                                            <div class="col-auto border mr-4 d-flex align-items-center p-0 my-1">
                                                <span class="pr-3 pl-2">{{trans('admin-base.any.month')}} : </span>
                                                <select v-model="month" class="outline-0 border-0 flex-grow-1" style="height: 30px;">
                                                    <option :value="index_month" v-for="(item_month, index_month) in $dictionnaire.short_month">@{{item_month}}</option>
                                                </select>
                                            </div>
                                            <div class="col-auto border mr-4 d-flex align-items-center p-0 my-1">
                                                <span class="pr-3 pl-2">{{trans('admin-base.any.year')}} : </span>
                                                <select v-model="year" class="outline-0 border-0 flex-grow-1" style="height: 30px;">
                                                    <option :value="item_year" v-for="(item_year, index_year) in $incrementeTo(8,$date.getFullYear()-7)">@{{item_year}}</option>
                                                </select>
                                            </div>
                                            <div class="col-auto border mr-4 d-flex align-items-center p-0 my-1">
                                                <span class="pr-3 pl-2">{{trans('admin-base.any.on')}} : </span>
                                                <select v-model="length_month" class="outline-0 border-0 flex-grow-1" style="height: 30px;">
                                                    @foreach([1,2,3] as $count_month)
                                                    <option value="{{$count_month}}">{{$count_month}} {{trans('admin-base.any.month')}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-auto border mr-4 d-flex align-items-center p-0 custom-planing-autoccomple my-1">
                                                <span class="pr-3 pl-2">{{trans('admin-base.any.categorie')}} : </span>
                                                <input type="text" required class="outline-0 border-0 flex-grow-1" style="height: 30px;" :value="vehicule_categorie" name="vehicule_categorie" v-autocompletion="autocompleteCategorie" :action="urlbase+'/admin/autocompletion/categorie-vehicules'" :autokey="'id'" :label="'titre'" :inputkey="'categorie_id'" :inputlabel="'vehicule_categorie'">
                                                <input type="text" required v-model="categorie_id" style="display: none;">
                                                <span class="px-2" @click="deleteCategorieFiltre">
                                                    <i class="fa fa-times text-danger"></i>
                                                </span>
                                            </div>
                                            <div class="col-auto border mr-4 d-flex align-items-center p-0 custom-planing-autoccomple my-1" v-for="updated_sate in state_change">
                                                <span class="pr-3 pl-2">{{trans('admin-base.any.car')}} : </span>
                                                <input type="text" required class="outline-0 border-0 flex-grow-1" style="height: 30px;" :value="vehicule_immatriculation" name="vehicule_immatriculation" v-autocompletion="autocompleteVehicule" :action="urlbase+'/admin/autocompletion/vehicule-locations'" :autokey="'id'" :label="'immatriculation'" :inputkey="'location_id'" :inputlabel="'vehicule_immatriculation'">
                                                <input type="text" required v-model="location_id" style="display: none;">
                                                <span class="px-2" @click="deleteVehiculeFiltre">
                                                    <i class="fa fa-times text-danger"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body d-flex align-items-center" id="calendar" style="overflow: auto;">

                                        <div class="d-flex flex-column m-auto" :style="`min-width: ${width_calendar + 100}px;`">
                                            <div class="d-flex flex-row align-items-stretch position-relative">
                                                <div class="flex-grow-1 m-auto">
                                                    <span class="d-block text-center" style="transform: rotate(45deg);">Calendrier</span>
                                                </div>
                                                <div class="d-flex flex-column ml-auto mr-0" :style="`min-width: ${width_calendar}px;`">
                                                    <div class="d-flex flex-row py-1">
                                                        <div class="d-flex align-items-center" :style="`width:${(100/day_in_year.month.length)}%;height:27px;border: 1px solid gray;`" class="text-center" v-for="(item_month,index_month) in day_in_year.month">
                                                            <span class="m-auto font-weight-bold">@{{item_month.month_string}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row pt-1">
                                                        <div class="d-flex flex-row" :style="`width:${(100/day_in_year.month.length)}%;height:27px;`" class="text-center" v-for="(item_month,index_month) in day_in_year.month">
                                                            <div class="d-flex align-items-center" :style="`width:${(100/item_day.length_day)}%;height:27px;border: 1px solid gray;`" class="text-center" v-for="(item_day,index_day) in day_in_year.day[index_month]">
                                                                <span class="m-auto font-weight-bold">@{{item_day.day_string}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex flex-row pb-1">
                                                        <div class="d-flex flex-row" :style="`width:${(100/day_in_year.month.length)}%;height:27px;`" class="text-center" v-for="(item_month,index_month) in day_in_year.month">
                                                            <div class="d-flex align-items-center" :style="`width:${(100/item_day.length_day)}%;height:27px;border: 1px solid gray;`" class="text-center" v-for="(item_day,index_day) in day_in_year.day[index_month]">
                                                                <span class="m-auto font-weight-bold">@{{item_day.day}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex flex-column position-relative align-items-stretch" v-for="(item_cat, index_cat) in categorie_calendar">
                                                <div class="d-flex flex-row position-relative border-bottom">
                                                    <span :data-id="item_cat.titre.id" class="text-uppercase text-bold">@{{item_cat.titre.titre}}</span>
                                                </div>
                                                <div class="d-flex flex-row position-relative align-items-stretch ml-auto mr-0 w-100" style="height: 50px;" v-for="(item_veh,index_veh) in item_cat.value">
                                                    <div class="d-flex flex-column flex-grow-1 pl-2 py-1 align-items-center h-100">
                                                        <span class="m-auto" :data-id="item_veh.titre.id">@{{item_veh.titre.titre}}</span>
                                                    </div>
                                                    <div class="d-flex flex-column ml-auto mr-0 position-relative" :style="`min-width: ${width_calendar}px;`">
                                                        <div class="d-flex flex-row py-1 position-relative h-100">
                                                            <div class="d-flex flex-row position-relative h-100" :style="`width:${(100/day_in_year.month.length)}%;`" class="text-center" v-for="(item_month,index_month) in day_in_year.month">
                                                                <div v-if="displayDate(item_day.planing, item_day.vehicule)" class="d-flex align-items-center position-relative h-100 text-center" :style="`width:${((100  * item_day.planing)/item_day.length_day)}%;border: 1px solid gray;`" :class="item_day.vehicule != undefined ? 'planing-occupe':'planing-libre'" v-for="(item_day,index_day) in item_veh.value[index_month]">
                                                                    <span class="btn m-auto font-weight-bold" v-if="item_day.vehicule != undefined" :title="`Contrat location &#8470; ${item_day.vehicule.id} pour ${item_day.vehicule.commande.facture.nom}  ${item_day.vehicule.commande.facture.prenom} du ${$formatDateString(item_day.vehicule.date_recuperation)} à ${$formatTime(item_day.vehicule.heure_recuperation)} au ${$formatDateString(item_day.vehicule.date_restriction)} à ${$formatTime(item_day.vehicule.heure_restriction)}`" @click.prevent="detail($event,item_day.vehicule.resource_url)"> <i class="fa fa-calendar" style="color: green;"></i></span>
                                                                    <span class="m-auto font-weight-bold" v-if="item_day.vehicule == undefined"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-center py-2" v-if="categorie_calendar[0] == undefined">
                                                <span class="d-block m-auto">{{trans('admin-base.index.no_items')}}</span>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="planing" :class="'min-width'" :click-to-close="false" :scrollable="true" :min-width="320" :max-width="1000" height="auto" width="100%" :draggable="true" :adaptive="true">

            <div class="card w-100">
                <div class="card-header p-2">
                    <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="$modal.hide('planing')"><i class="fa fa-times"></i></a>
                </div>
                <div class="card-body p-2">
                    <div class="d-flex flex-column position-relative" v-for="item_location in detail_location">
                        <div class="d-flex flex-column px-4 py-2 border">
                            <div class="d-flex flex-row pb-1">
                                <div class="mr-2"><b>{{trans('front-location.reference_contrat')}} :</b></div>
                                <div>@{{item_location.commande.id}}</div>
                            </div>
                            <div class="d-flex flex-row pb-1">
                                <div class="mr-2"><b>{{trans('front-location.modifier_par')}} :</b></div>
                                <div>{{name()}}</div>
                            </div>
                            <div class="d-flex flex-row pb-1">
                                <div class="mr-2"><b>{{trans('front-location.dernier_modification')}} :</b></div>
                                <div>@{{$formatDateString(item_location.updated_at,true)}}</div>
                            </div>
                        </div>
                        <div class="d-flex flex-column mt-2 border">
                            <div class="d-flex flex-row position-relative w-100">
                                <div class="d-flex border-left border-right border-bottom py-2 btn-outline-info shadow-sm" :class="tab[0]?'active':''" @click="changeTab(0)" :style="`width: ${100/3}%;margin: 1px`">
                                    <span class="m-auto">{{trans('front-location.information_location')}}</span>
                                </div>
                                <div class="d-flex border-left border-right border-bottom py-2 btn-outline-info shadow-sm" :class="tab[1]?'active':''" @click="changeTab(1)" :style="`width: ${100/3}%;margin: 1px`">
                                    <span class="m-auto">{{trans('front-location.locataire')}} / {{trans('front-location.conducteur')}}</span>
                                </div>
                                <div class="d-flex border-left border-right border-bottom py-2 btn-outline-info shadow-sm" :class="tab[2]?'active':''" @click="changeTab(2)" :style="`width: ${100/3}%;margin: 1px`">
                                    <span class="m-auto">{{trans('front-location.condition_et_franchise')}}</span>
                                </div>
                                <div v-if="false" class="d-flex border-left border-right border-bottom py-2 btn-outline-info shadow-sm" :class="tab[3]?'active':''" @click="changeTab(3)" :style="`width: ${100/4}%;margin: 1px`">
                                    <span class="m-auto">{{trans('front-location.contraventions')}}</span>
                                </div>
                            </div>

                            <!-- -->

                            <div class="d-flex flex-column px-2 py-4" v-if="tab[3] && false">
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        <!-- titre section -->
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>
                                                    <!-- item : -->
                                                </b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                <!-- value -->
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.supplement_deplacements')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.supplement_deplacements')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.deplacement_lieu_tarif}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- -->
                            <div class="d-flex flex-column px-2 py-4" v-if="tab[2]">
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.caution_et_franchise')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.caution')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.caution}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.franchise')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.franchise}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.franchise_non_rachatable')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.franchise_non_rachatable}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.supplement_deplacements')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.supplement_deplacements')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.deplacement_lieu_tarif}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--  -->
                            <div class="d-flex flex-column px-2 py-4" v-if="tab[1]">
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.locataire_vehicule')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.nom')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.nom}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.prenom')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.prenom}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.adresse')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.adresse}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.ville')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.ville}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.code_postal')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.code_postal}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.telephone')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.telephone}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-panier.email')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.commande.facture.email}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.conducteur_vehicule')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.nom')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.nom_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.prenom')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.prenom_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.adresse')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.adresse_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.ville')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.ville_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.code_postal')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.code_postal_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.telephone')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.telephone_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.email')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.email_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.date_naissance')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.date_naissance_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.lieu_naissance')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.lieu_naissance_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.numero_permis')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.num_permis_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.date_permis')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.date_permis_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.lieu_delivrance_permis')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.lieu_deliv_permis_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.numero_piece_identite')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.num_identite_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.date_delivrance_identite')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.date_emis_identite_conducteur}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.lieu_delivrance_identite')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.lieu_deliv_identite_conducteur}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- -->
                            <div class="d-flex flex-column px-2 py-4" v-if="tab[0]">
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.vehicule')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.model_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.modele_vehicule_titre}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.categorie_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.categorie_vehicule_titre}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.famille_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.famille_vehicule_titre}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.marque_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.marque_vehicule_titre}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.immatriculation_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.immatriculation}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.titre_vehicule')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.titre}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.reservation')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.lieu_depart')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.agence_recuperation_name}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.lieu_retour')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.agence_restriction_name}}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.date_et_heure_depart')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{$formatDateString(item_location.date_recuperation,true)}} à @{{item_location.heure_recuperation | formatTime}}
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.date_et_heure_retour')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{$formatDateString(item_location.date_restriction,true)}} à @{{item_location.heure_restriction | formatTime}}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column position-relative border pb-2 pt-4 px-2 mt-4" style="border-radius: 5px;">
                                    <div class="position-absolute bg-white px-2 text-uppercase" style="top: -13px;left: 22px">
                                        {{trans('front-location.information_tarif')}}
                                    </div>
                                    <div class="d-flex flex-row w-100 pb-2 justify-content-around">
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.tarif_agence')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.prix_total}} €
                                            </div>
                                        </div>
                                        <div class="d-flex flex-row" style="width: 45%;">
                                            <div>
                                                <b>{{trans('front-location.total_a_payer')}}:</b>
                                            </div>
                                            <div class="flex-grow-1 text-center">
                                                @{{item_location.prix_total}} €
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </modal>
    </div>
</planing-vehicule-listing>

@endsection

<!--

<div class="d-flex flex-column">
                                            <div class="d-flex flex-row border-bottom py-1 mb-4">
                                                <div class="d-flex align-items-center" style="width: 14.28%;height:27px" class="text-center" v-for="(item_week , index_month) in $dictionnaire.short_week_list">
                                                    <span class="m-auto font-weight-bold">@{{item_week}}</span>
                                                </div>
                                            </div>
                                            <div class="d-flex flex-column position-relative my-2" style="background-color: #edeaea;" v-for="(item_date, index_date) in day_in_year">
                                                <div class="d-flex flex-row w-100">
                                                    <div class="d-flex align-items-center" style="width: 14.28%;height:70px;border: 1px solid #f4f6f9;" class="text-center" :class="item_date_item.isDate != 0?'text-black-50':''" v-for="(item_date_item, index_date_item) in item_date">
                                                        <span :class="( item_date_item.vehicule != undefined || item_date_item.planing == undefined) ? 'mt-0' : ''" style="margin: auto;">@{{item_date_item.date}}</span>
                                                    </div>
                                                </div>
                                                <div class="d-flex flex-row w-100 position-absolute bottom">
                                                    <div v-if="item_date_item.planing != undefined && item_date_item.vehicule != undefined" class="d-flex align-items-center bg-success" :style="`width: ${(14.28 *item_date_item.planing )}%;height:30px; border-radius: 20px;margin-bottom: 10px;`" class="text-center" v-for="(item_date_item, index_date_item) in item_date">
                                                        <span class="m-auto" :class="item_date_item.isDate != 0?'text-black-50':''">@{{item_date_item.vehicule.immatriculation }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

-->