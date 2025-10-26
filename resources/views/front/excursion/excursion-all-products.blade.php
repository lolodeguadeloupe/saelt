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

@section('title', trans('front-excursion.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/maldives.jpg').'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase">{{trans('front-excursion.titre')}}</h1>
                <h4>{{$filter_ile}}</h4>
            </div>
        </div>
    </div>
</section>
<excursion-all-product :url="'{{route('excursion-all-products')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="py-5">
        <div class="container">
            <div class="row">
                <div class="col-sm-3 pt-3">
                    <div>
                        <form @submit.prevent="searchData" id="search_data" class="form_customer_search">
                            <div class="text-wrap mb-4">
                                <h4>{{trans('front-excursion.recherche')}}</h4>
                                <hr class="separator ml-0">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{trans('front-excursion.mot_cle')}}</label>
                                <input class="form-control" type="text" name="mot_cle" id="exampleFormControlSelect1">
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{trans('front-excursion.destination')}}</label>
                                <select class="form-control" name="ile" id="exampleFormControlSelect1">
                                    <option v-if="aside.ile" :value="$getKey(aside.ile,'id')">Tout</option>
                                    <option v-for="item of (aside.ile?aside.ile:[])" :value="item.id">@{{item.name}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1">{{trans('front-excursion.duree')}}</label>
                                <select class="form-control" name="duration" id="exampleFormControlSelect1">
                                    <option value="*">{{trans('admin-base.filter.all')}}</option>
                                    <option value="Demi-journée">{{trans('front-excursion.une_demi_journée')}}</option>
                                    <option value="Journée">{{trans('front-excursion.une_journee')}}</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="price">{{trans('front-excursion.echelle_prix')}}</label>
                                <div>
                                    <div>
                                        <b>€ <span id="price-min">10</span> - </b>
                                        <b>€ <span id="price-max">1000</span></b>
                                    </div>
                                    <input id="price" type="text" class="form-control span2" name="price" value="" />
                                </div>
                            </div>
                            <div class="text-right">
                                <button type="submit" class="btn btn-primary pl-4 pr-4 rounded-sm text-white">
                                    <span>{{trans('front-excursion.rechercher')}}</span>
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
                                    <p class="mb-0 resultat-search">{{trans('front-excursion.resultat_correspondant_a_votre_recherche')}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" v-if="collection[0] != undefined">
                        <div class="col-md-6 pb-3" v-for="(item,index) in collection">
                            <div class="border h-100 d-flex flex-column">
                                <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:item.id})" href="#" class="d-block position-relative"><img :src="(item.image && item.image[0] != undefined) ? `${urlasset}/${item.image[0].name}`:'{{asset('/assets/img/La_Creole_Beach_Hotel_Spa-Le_Gosier-thumb.jpg')}}'" class="img-fluid w-100">
                                </a>
                                <div class="pb-3 pl-4 pr-4 pt-4 d-flex flex-grow-1 flex-column position-relative">
                                    <div class="d-flex flex-column flex-grow-1">
                                        <div class="pb-1 pt-1 mb-auto">
                                            <a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:item.id})" href="#" class="text-dark text-decoration-none">
                                                <h5 class="mb-1 text-primary">@{{item.title}} </h5>
                                            </a>
                                            <div class="d-flex">
                                                <div class="flex-fill font-size-0-8-em mt-2">
                                                    <i class="fa-map-marker-alt fas text-primary mr-1"></i>
                                                    <span>@{{item.ile.name}}</span>
                                                </div>
                                                <div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
                                                    <i class="fa-clock far mr-1"></i>
                                                    <span>{{trans('front-excursion.une_')}} @{{$lowerCase(item.duration)}}</span>
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
                                                <div class="font-size-0-8-em jour-dispo position-relative">
                                                    <i class="fa-calendar-alt far mr-1"></i>
                                                    <span>@{{availability(item.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
                                                    <div class="jour-dispo-detail rounded-sm p-2 border">
                                                        <i class="fa-calendar-alt far mr-1"></i>
                                                        <span>@{{availability(item.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
                                                        <ul class="mt-2 pt-2 border-top">
                                                            <li v-for="jour of availability(item.availability)">@{{jour}}</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1 d-flex" v-if="(item.lunch == 1 || item.ticket == 1)">
                                                <div class="font-size-0-8-em position-relative d-flex align-items-center m-auto" v-if="item.ticket == 1 || item.lunch == 1">
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}');" v-if="item.lunch == 1"></i>
                                                    <span v-if="item.lunch == 1">{{trans('front-excursion.repas')}}</span>
                                                    <span v-if="item.ticket == 1 && item.lunch == 1">&nbsp; + &nbsp;</span>
                                                    <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/ticket.png')}}');" v-if="item.ticket == 1"></i>
                                                    <span v-if="item.ticket == 1">{{trans('front-excursion.billet_avion')}}</span>
                                                </div>
                                            </div>
                                            <div class="flex-fill text-center px-1 d-flex" v-if="(item.lunch == 0 && item.ticket == 0)">
                                                <div class="font-size-0-8-em position-relative d-flex align-items-center m-auto">
                                                    <span>{{trans('front-excursion.excursion_seule')}}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <hr />
                                    <div class="align-items-center d-flex justify-content-between">
                                        <div>
                                            <p class="font-size-15-px text-success text-center">{{trans('front-excursion.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{item.tarif?item.tarif.prix_vente:0}}&euro;</span> (HT) {{trans('front-excursion.par_personne')}}</p>
                                        </div>
                                        <div>
                                            <a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:item.id})" href="#">{{trans('front-excursion.voir_cette_offre')}}</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row h-100" v-if="collection[0] == undefined">
                        <div class="col-md-12 h-100 pb-3">
                            <div class="border h-100 d-flex" style="background-color:#eaeaea">
                                <div class="m-auto" v-if="action_search || (action_search==false && sessionrequest.date_debut == undefined)">
                                    <p>{{trans('front-excursion.aucun_resultat_correspond_a_votre_recherche')}}</p>
                                </div>
                                <div class="m-auto" v-if="action_search==false && sessionrequest.date_debut != undefined">
                                    <p class="text-center">{{trans('front-excursion.aucun_resultat_correspond_a_votre_recherche_dans_cette_saisonnalité')}} <span style="background-color: #dfab1d2e; font-style: italic;">@{{sessionrequest.date_debut}}</span> {{trans('front-excursion._a_')}} <span style="background-color: #dfab1d2e; font-style: italic;"> @{{sessionrequest.date_fin}}</span></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</excursion-all-product>

@endsection