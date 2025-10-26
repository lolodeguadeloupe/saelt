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
<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.(isset($data[0]->fond_image)?asset($data[0]->fond_image):asset('/assets/img/guadeloupe_creole_Room.jpg')).'\')'}};">
    <div class="container mt-5 pt-4">
        <div class="row">
            <div class="col-md">
                <h1 class="text-uppercase text-center">{{$data[0]['name']}} {{count_etoil($data[0]['etoil'])}}</h1>
            </div>
        </div>
    </div>
</section>
<hebergement-host :url="'{{route('hebergement-host')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" inline-template>
    <section class="py-5">
        <div class="container" v-for="(item,index) in collection">
            <div class="slick-carousel">
                <div v-for="_image in $grouperArrayRepet(item.image,3)">
                    <div class="justify-content-center row">
                        <div class="col-md py-3" v-for="_image_item in _image">
                            <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5 detail-image-modal" :style="`background-image: url('${urlasset}/${_image_item.name}'); min-height: 237px;`">
                                <img :src="`${urlasset}/${_image_item.name}`" class="d-none" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="description mb-5">
                <ul class="nav nav-pills nav-justified mt-5 mb-5">
                    <li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#overview">{{trans('front-hebergement.info_pratique')}}</a></li>
                    <li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#description">{{trans('front-hebergement.descriptif')}}</a></li>
                    <li class="nav-item"><a class="text-secondary nav-link active" role="tab" data-toggle="tab" href="#hosting">{{trans('front-hebergement.les_chambres')}}</a></li>
                    <li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#conditions">{{trans('front-hebergement.conditions_tarifaires')}}</a></li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="overview-tab" id="overview">
                        <div class="text-justify mx-5" v-html="item.info_pratique.info_pratique"></div>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="description-tab" id="description">
                        <div class="text-justify mx-5" v-html="item.descriptif.descriptif"></div>
                    </div>
                    <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="hosting-tab" id="hosting">
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
                                                <option v-if="aside.ile" :value="$getKey(aside.ile,'id')">Tout</option>
                                                <option v-for="item of (aside.ile?aside.ile:[])" :value="item.id">@{{item.name}}</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="price">{{trans('front-hebergement.echelle_prix')}}</label>
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
                                <div class="row" v-if="item.tarif[0] != undefined">
                                    <div class="col-md-6 pb-3" v-for="(tarif_item,tarif_index) in item.tarif">
                                        <div class="border h-100 d-flex flex-column">
                                            <a v-if="tarif_item.quantite_stock == undefined || tarif_item.quantite_stock > 0" @contextmenu.prevent="" @click.prevent="managerRequest($event,tarif_item.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:tarif_item.id})" href="#" class="d-block position-relative"><img :src="tarif_item.type_chambre.image.length > 0 ? `${urlasset}/${tarif_item.type_chambre.image[0].name}`: '{{asset('/assets/img/chambre-vue-mer.jpg')}}'" class="img-fluid w-100" style="max-height: 271px;">
                                            </a>
                                            <a v-if="tarif_item.quantite_stock != undefined && tarif_item.quantite_stock <= 0" @contextmenu.prevent="" href="#" class="d-block position-relative"><img :src="tarif_item.type_chambre.image.length > 0 ? `${urlasset}/${tarif_item.type_chambre.image[0].name}`: '{{asset('/assets/img/chambre-vue-mer.jpg')}}'" class="img-fluid w-100" style="max-height: 271px;">
                                            </a>
                                            <div class="pb-3 pl-4 pr-4 pt-4 d-flex flex-grow-1 flex-column position-relative">
                                                <div class="d-flex flex-column flex-grow-1">
                                                    <div class="pb-1 pt-1 mb-auto">
                                                        <a v-if="tarif_item.quantite_stock == undefined || tarif_item.quantite_stock > 0" @contextmenu.prevent="" @click.prevent="managerRequest($event,tarif_item.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:tarif_item.id})" href="#" class="text-dark text-decoration-none">
                                                            <h5 class="mb-1 text-primary">@{{tarif_item.type_chambre.name}}</h5>
                                                        </a>
                                                        <a v-if="tarif_item.quantite_stock != undefined && tarif_item.quantite_stock <= 0" @contextmenu.prevent="" href="#" class="text-dark text-decoration-none">
                                                            <h5 class="mb-1 text-primary">@{{tarif_item.type_chambre.name}}</h5>
                                                        </a>
                                                        <div class="d-flex">
                                                            <div class="flex-fill font-size-0-8-em mt-2">
                                                                <i class="fas fa-hotel text-primary mr-1"></i>
                                                                <span>@{{item.name}} @{{$countEtoil(item.etoil)}}</span>
                                                            </div>
                                                            <div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
                                                                <span>@{{tarif_item.type_chambre.capacite}} {{trans('front-hebergement.pers_max_1_chambre')}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="mt-3 position-relative">
                                                            <div class="short-definition">
                                                                <div class="more-definition p-2 rounded-sm position-absolute border">
                                                                    <p class="font-size-0-8-em">@{{$textDescription(tarif_item.type_chambre.description)}}</p>
                                                                </div>
                                                                <p class="font-size-0-8-em">@{{$textDescription(tarif_item.type_chambre.description, 100)}}</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr class="w-100">
                                                    <div class="d-flex">
                                                        <div class="flex-fill text-center px-1 border-right">
                                                            <div class="font-size-0-8-em ">
                                                                <i class="fas fa-user-friends mr-1"></i>
                                                                <span>{{trans('front-hebergement.base')}} @{{tarif_item.base_type?tarif_item.base_type.nombre:''}} {{trans('front-hebergement.pers')}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-fill text-center px-1" v-if="tarif_item.type_chambre.formule" style="width: 50%;">
                                                            <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                                <i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}"></i>
                                                                <span style="width: 80%">@{{tarif_item.type_chambre.formule.desc}}</span>
                                                            </div>
                                                        </div>
                                                        <div class="flex-fill text-center px-1" v-if="tarif_item.type_chambre.formule == null" style="width: 50%;">
                                                            <div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
                                                                <span class="m-auto">{{trans('front-hebergement.hebergement_seul')}}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <hr />
                                                <div class="align-items-center d-flex justify-content-between">
                                                    <div>
                                                        <p class="font-size-15-px text-success text-center">{{trans('front-hebergement.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{tarif_item.tarif.prix_vente}}&euro; </span> {{trans('front-hebergement.par_jour')}} (HT)</p>
                                                        <div class="flex-fill font-size-0-8-em pt-1" :class="tarif_item.vol?'text-heb-avec-vol':'text-heb-sans-vol'">
                                                            <i class="fas fa-plane mr-1"></i>
                                                            <span v-if="tarif_item.vol">{{trans('front-hebergement.avec_vol')}}</span>
                                                            <span v-if="!tarif_item.vol">{{trans('front-hebergement.sans_vol')}}</span>
                                                        </div>
                                                    </div>
                                                    <div style="max-width: 50%;">
                                                        <a v-if="tarif_item.quantite_stock == undefined || tarif_item.quantite_stock > 0" class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,tarif_item.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:tarif_item.id})" href="#">{{trans('front-hebergement.voir_cette_offre')}}</a>
                                                        <a v-if="tarif_item.quantite_stock != undefined && tarif_item.quantite_stock <= 0" class="btn" style="background-color: #dc413cb5; color:white;" @contextmenu.prevent="" href="#">@{{$dictionnaire.produit_commande_non_dispo_msg}}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row h-100" v-if="item.tarif[0] == undefined">
                                    <div class="col-md-12 h-100 pb-3">
                                        <div class="border h-100 d-flex">
                                            <div class="m-auto">
                                                <p>{{trans('front-hebergement.aucun_produit_disponible_actuellement')}}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" role="tabpanel" aria-labelledby="conditions-tab" id="conditions">
                        <div class="text-justify mx-5" v-html="item.condition_tarifaire.condition_tarifaire"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</hebergement-host>

@endsection