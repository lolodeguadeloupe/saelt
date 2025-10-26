@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-single-product.css') }}">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
@endpush

@section('title', trans('front-hebergement.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/guadeloupe_creole_Room.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase">{{trans('front-hebergement.titre')}}</h1>
                <h4>{{$filter_ile}}</h4>
            </div>
        </div>
    </div>
</section>
<hebergement-all-host :url="'{{route('hebergement-all-hosts')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 pt-3">
                    <div>
                        <form @submit.prevent="searchData" id="search_data" class="form_customer_search">
                            <div class="text-wrap mb-4">
                                <h4>{{trans('front-hebergement.recherche')}}</h4>
                                <hr class="separator ml-0">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{trans('front-hebergement.mot_cle')}}</label>
                                <input class="form-control" type="text" name="mot_cle" id="exampleFormControlSelect1">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{trans('front-hebergement.destination')}}</label>
                                <select class="form-control" name="ile" id="exampleFormControlSelect1">
                                    <option v-if="aside.ile" :value="$getKey(aside.ile,'id')">{{trans('admin-base.filter.all')}}</option>
                                    <option v-for="item of (aside.ile?aside.ile:[])" :value="item.id">@{{item.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">{{trans('front-hebergment.echelle_prix')}}</label>
                                <div>
                                    <div>
                                        <b>€ <span id="price-min">10</span> - </b>
                                        <b>€ <span id="price-max">1000</span></b>
                                    </div>
                                    <input id="price" type="text" class="form-control span2" value="" name="price" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="select_transport">{{trans('front-hebergement.transport')}}</label>
                                <select class="form-control" name="transport" id="select_transport">
                                    <option value="2">{{trans('admin-base.filter.all')}}</option>
                                    <option value="0">{{trans('front-hebergement.sans_vol')}}</option>
                                    <option value="1">{{trans('front-hebergement.avec_vol')}}</option>
                                </select>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                    <span>{{trans('front-hebergement.rechercher')}}</span>&nbsp;
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-sm-9 pt-3">
                    <div class="row" v-if="action_search==true && collection.length > 0">
                        <div class="col-md-12">
                            <div class="h-100 d-flex pb-3 pt-3">
                                <div class="m-auto">
                                    <p class="mb-0 resultat-search">{{trans('front-hebergement.resultat_correspondant_a_votre_recherche')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="collection.length > 0">
                        <div class="col-md-6 pb-3" v-for="(item,index) in collection">
                            <div class="border h-100 d-flex flex-column"> 
                                <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('hebergement-host') }}',{id:item.id,customer_search: (data_request_customer && data_request_customer.customer_search)?data_request_customer.customer_search:null})" href="#" class="d-block position-relative"><img :src="(item.image && item.image[0] != undefined) ? `${urlasset}/${item.image[0].name}`: '{{asset('/assets/img/bois-joli-bungalow.jpg')}}'" class="img-fluid w-100" style="max-height: 271px;">
                                </a>
                                <div class="pb-3 pl-4 pr-4 pt-4 d-flex flex-grow-1 flex-column position-relative">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <div class="pb-1 pt-1 mb-auto">
                                            <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('hebergement-host') }}',{id:item.id,customer_search: (data_request_customer && data_request_customer.customer_search)?data_request_customer.customer_search:null})" href="#" class="text-dark text-decoration-none">
                                                <h5 class="mb-1 text-primary">@{{item.name}} @{{$countEtoil(item.etoil)}}</h5>
                                            </a>
                                            <div class="d-flex">
                                                <div class="flex-fill font-size-0-8-em mt-2">
                                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                                    <span>@{{item.ile.name}}</span>
                                                </div>
                                                <div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
                                                    <span>@{{item.tarif.type_chambre.capacite}} {{trans('front-hebergement.pers_max_1_chambre')}}</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 position-relative">
                                                <div class="short-definition">
                                                    <div class="more-definition p-2 rounded-sm position-absolute border">
                                                        <p class="font-size-0-8-em">@{{$textDescription(item.description)}}</p>
                                                    </div>
                                                    <p class="font-size-0-8-em">@{{$textDescription(item.description, 100)}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <hr class="w-100">
                                        <div class="d-flex">
                                            <div class="flex-fill text-center px-1 border-right">
                                                <div class="font-size-0-8-em ">
                                                    <i class="fas fa-user-friends mr-1"></i>
                                                    <span v-if="item.tarif.base_type">{{trans('front-hebergement.base')}} @{{item.tarif.base_type.nombre}} {{trans('front-hebergement.pers')}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1" v-if="item.tarif.type_chambre.formule" style="width: 50%">
                                                <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}"></i>
                                                    <span class="flex-grow-1" style="width: 80%">@{{item.tarif.type_chambre.formule.desc}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1" v-if="item.tarif.type_chambre.formule == null" style="width: 50%">
                                                <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                    <span class="m-auto">{{trans('front-hebergement.hebergement_seul')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr class="w-100" />
                                    <div class="align-items-center d-flex justify-content-between">
                                        <div>
                                            <p class="font-size-15-px text-success  text-center">{{trans('front-hebergement.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{item.tarif.tarif.prix_vente}}&euro; </span> {{trans('front-hebergement.par_jour')}} (HT)</p>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('hebergement-host') }}',{id:item.id,customer_search: (data_request_customer && data_request_customer.customer_search)?data_request_customer.customer_search:null})" href="#">{{trans('front-hebergement.voir_cette_offre')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row h-100" v-if="collection.length == 0">
                        <div class="col-md-12 h-100 pb-3">
                            <div class="border h-100 d-flex" style="background-color:#eaeaea">
                                <div class="m-auto" v-if="action_search">
                                    <p>{{trans('front-hebergement.aucun_resultat_correspond_a_votre_recherche')}}</p>
                                </div>
                                <div class="m-auto" v-if="action_search==false && sessionrequest.date_debut == undefined  && sessionrequest.date_fin == undefined">
                                    <p class="text-center">{{trans('front-hebergement.aucun_resultat_disponible')}} </p>
                                </div>
                                <div class="m-auto" v-if="action_search==false && sessionrequest.date_debut != undefined  && sessionrequest.date_fin != undefined">
                                    <p class="text-center">{{trans('front-hebergement.aucun_resultat_correspond_a_votre_recherche_dans_cette_saisonnalité')}} <span style="background-color: #dfab1d2e; font-style: italic;">@{{sessionrequest.date_debut}}</span> {{trans('front-hebergement._a_')}} <span style="background-color: #dfab1d2e; font-style: italic;"> @{{sessionrequest.date_fin}}</span></p>
                                    <p class="text-center">
                                        <a class="text-info" @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ url('/') }}',{form:'hebergement',customer_search: (sessionrequest && sessionrequest.customer_search)?sessionrequest.customer_search:null})" href="#">{{trans('front-hebergement.revenir_a_la_barre_de_recherche_precedente')}}</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</hebergement-all-host>

@endsection