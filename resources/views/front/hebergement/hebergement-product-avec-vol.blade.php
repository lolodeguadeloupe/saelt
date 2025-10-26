@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-single-product.css') }}">
<style>
	.calendar>div {
		border-radius: 0;
	}
</style>
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>
@endpush

@section('title', trans('front-hebergement.titre'))

@section('content')

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.(isset($data[0]->hebergement->fond_image)?asset($data[0]->hebergement->fond_image):asset('/assets/img/La_Creole_Beach_Hotel_Spa-Le_Gosier-Schwimmbad.jpg')).'\')'}};">
	<div class="container mt-5 mb-3 py-5">
		<div class="row">
			<div class="col-md text-center">
				<h1 class="main-header" itemprop="name">
					{{$data[0]->type_chambre->name}}
				</h1>
				<h4 class="sub-header">{{$data[0]->hebergement->name}} {{count_etoil($data[0]->hebergement->etoil)}}</h4>
			</div>
		</div>
	</div>
</section>
<hebergement-host-detail-avec-vol :url="'{{route('hebergement-product-avec-vol')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" :personne="{{$personne->toJson()}}" :mycommande="{{$commande_saved->toJson()}}" :editpannier="'{{$edit_pannier==false?'false':'true'}}'" inline-template>
	<section class="py-5">
		<form id="reservetion_form">
			<div class="container" v-if="setItem(item) && item.chambre_dispo > 0" v-for="(item,index) in collection">
				<input type="text" name="id" style="display: none;" :value="item.id">
				<div class="row under-banner">
					<div class="col-md-9 overview-option">
						<div class="slick-carousel-zoom center position-relative">
							<div class="img-preview" v-for="image of item.type_chambre.image">
								<img :src="urlasset+image.name" class="img-fluid w-100 detail-image-modal">
							</div>
							<div class="img-preview" v-if="item.type_chambre.image[0] == undefined">
								<img src="{{asset('/assets/img/bois-joli-bungalow.jpg')}}" class="img-fluid w-100 detail-image-modal">
							</div>
						</div>

						<div class="position-absolute pr-2 w-100" style="bottom: -22px;" v-if="item.type_chambre.image[0] != undefined">
							<div class="ml-3 mr-5 slick-carousel-nav-zoom" style="background-color: #efe6e61c;">
								<div v-for="image of item.type_chambre.image" class="position-relative">
									<img :src="urlasset+image.name" style="width: auto; height: 50px;">
									<!--<div class="btn-zoom align-items-center bottom-0 d-flex h-100 position-absolute top top-0 w-100">
										<div class="p-1 border m-auto">
											<i class="fa fa-plus"></i>
										</div>
									</div>-->
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 overview-price">
						<div>
							<span class="product-tag d-none">{{trans('front-hebergement.en_promos')}}</span>
							<div class="price">
								<span>{{trans('front-hebergement.a_partir_de')}}</span>
								<div class="txt">
									<h3>@{{item.reference_tarif.prix_vente}}<span> €</span> </h3>
									<p>{{trans('front-hebergement.par_jour')}}</p>
									<p>(HT)</p>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="separator">
					<hr>
				</div>

				<div class="description mb-5">
					<ul class="nav nav-pills nav-justified mt-5 mb-5">
						<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#overview">{{trans('front-hebergement.info_pratique')}}</a></li>
						<li class="nav-item"><a class="text-secondary nav-link active" role="tab" data-toggle="tab" href="#booking">{{trans('front-hebergement.reservation')}}</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane fade" role="tabpanel" aria-labelledby="overview-tab" id="overview">
							<div class="row">
								<div class="col-sm-4">
									<div class="border-right mr-5">
										<ul class="trip-overview">
											<li>
												<img class="img-icon" src="{{asset('/assets/img/host.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.etablissement')}}</div>
													<div class="desc">
														<a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('hebergement-host') }}',{id:item.hebergement.id})" href="#" rel=" tag">@{{item.hebergement.name}} @{{$countEtoil(item.hebergement.etoil)}}</a>
													</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/earth.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.destination')}}</div>
													<div class="desc">
														<a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('hebergement-all-hosts') }}',{ile:item.hebergement.ile.id})" href="#" rel="tag">@{{item.hebergement.ile.name}}</a>
													</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/users.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.base')}}</div>
													<div class="desc">@{{item.base_type.nombre}} {{trans('front-hebergement.personnes')}}</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/bed.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.chambres')}}</div>
													<div class="desc">1 {{trans('front-hebergement.chambre')}}</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/plane.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.transport')}}</div>
													<div class="desc">{{trans('front-hebergement.avec_vol')}}</div>
												</div>
											</li>
											<li v-if="item.type_chambre.formule">
												<img class="img-icon" src="{{asset('/images/repas.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.formule')}}</div>
													<div class="desc">@{{item.type_chambre.formule.value}}</div>
												</div>
											</li>
											<li v-if="item.type_chambre.formule == null">
												<img class="img-icon" src="{{asset('/images/repas.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.formule')}}</div>
													<div class="desc">{{trans('front-hebergement.hebergement_seul')}}</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/map-with-a-pin-small-symbol-inside-a-circle.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.aeroport_depart')}}</div>
													<div class="desc">@{{item.vol.allotement.depart.name}}</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/map-with-a-pin-small-symbol-inside-a-circle.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-hebergement.aeroport_arrive')}}</div>
													<div class="desc">@{{item.vol.allotement.arrive.name}}</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-sm-8">
									<div style="text-align: justify;" v-html="item.hebergement.info_pratique.info_pratique"></div>

									<div class="share mt-5">
										<p class="share-text">Partager la publication "Le Bois Joli ★★★"</p>
										<ul>
											<li class="share_icon link_facebook">
												<a href="#" rel="nofollow" target="_blank" title="Partager cet article sur Facebook">
													<i class="fab fa-facebook-f"></i>
												</a>
											</li>
											<li class="share_icon link_linkedin">
												<a href="#" rel="nofollow" target="_blank" title="Partager cet article sur Linkedin">
													<i class="fab fa-linkedin-in"></i>
												</a>
											</li>
											<li class="share_icon link_twitter">
												<a href="#" rel="nofollow" target="_blank" title="Partager cet article sur Twitter">
													<i class="fab fa-twitter"></i>
												</a>
											</li>
											<li class="share_icon link_mail">
												<a href="#" rel="nofollow" target="_blank" title="Partager cette publication avec un ami (e-mail)">
													<i class="far fa-envelope"></i>
												</a>
											</li>
										</ul>
									</div>
									<div class="map">
										<img class="img-map" src="{{asset('/assets/img/Guadeloupe_location_map.png')}}">
									</div>
								</div>
							</div>
						</div>
						<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="booking-tab" id="booking">
							<div class="row">
								<div class="col-md-5 px-5 mb-5 col-calendar">
									<div class="nb-days mb-2 row">
										<div class="col-6">
											<h5>{{trans('front-hebergement.dates_sejour')}} :</h5>
										</div>
										<div class="col-6">
											<p>@{{dateDebutCalendar}} au @{{dateEndCalendar}}</p>
										</div>
									</div>
									<div class="nb-day days-hebergement row mb-4">
										<div class="nb-days day col-6">
											<h5>{{trans('front-hebergement.nbr_jours')}} :</h5>
											<p class="ml-2">@{{nombreJourCalendar}}</p>
										</div>
										<div class="nb-days night col-6">
											<h5>{{trans('front-hebergement.nbr_nuits')}} :</h5>
											<p class="ml-2">@{{nombreNuitCalendar}}</p>
										</div>
									</div>
									<div class="calendar" id="my_calendar">
										<v-calendar is-expanded :from-date="selectCalendarDate.start" :min-date="selectCalendarDate.start" :max-date="selectCalendarDate.end" :available-dates='{ start: selectCalendarDate.start, end: selectCalendarDate.end }' :attributes="calendarRange" />
									</div>

								</div>
								<div class="col-md-4 px-5 mb-5 col-pers">
									<div class="nb-pers">
										<h5 class="required">{{trans('front-hebergement.nombre_personne')}} <span style="color:#ab2e30">*</span> :</h5>
										<div class="block-input" v-for="_personne of item.tarif">
											<div class="label-pers">
												<span class="pers-tarif" :id="'personne_'+_personne.personne.id">0 €</span>
												<label class="form-label">@{{_personne.personne.type}} (@{{_personne.personne.age}})</label>
											</div>
											<input type="number" :name="'personne_'+_personne.personne.id" required class="form-input" step="1" min="0" data-oldValue="0" value="0" @input="checkPersonne($event,'personne_',$getKey(item.tarif,'type_personne_id'),_personne.personne.id)" @focusout="$setDefaultValue">
										</div>
										<h5 class="required">{{trans('front-hebergement.nombre_chambre')}} :</h5>
										<div class="block-input">
											<select :disabled="chambre_ajuster.length == 0 || chambre_ajuster[0] == 0" required name="nb_chambre" id="nb_chambre" class="form-input" step="1" data-oldValue="0" v-model="chambreChecked" @input="checkChambre($event,$getKey(item.tarif,'type_personne_id'))" @focusout="$setDefaultValue">
												<option :value="_val" v-for="_val of chambre_ajuster">@{{_val == 0?'-':_val}}</option>
											</select>
										</div>
										<div class="d-flex detail font-size-0-8-em text-center border-top">
											<div class="flex-fill my-3 mx-2 font-weight-bold">
												<span> {{trans('front-hebergement.une_chambre')}} </span>
											</div>
										</div>
										<div class="d-flex detail font-size-0-8-em text-center border-top border-bottom">
											<div class="flex-fill my-3 mx-2 font-weight-bold">
												{{trans('front-hebergement.base')}} : <span>@{{item.base_type.nombre}} {{trans('front-hebergement.pers')}}</span>
											</div>
											<div class="flex-fill my-3 mx-2 font-weight-bold border-left">
												{{trans('front-hebergement.capacite_max')}} : <span>@{{item.type_chambre.capacite}} {{trans('front-hebergement.pers')}}</span>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 px-5 mb-5 col-option">
									<div class="option-checked" v-if="item.hebergement.supplement_pension[0] != undefined || item.hebergement.supplement_activite[0] != undefined || item.hebergement.supplement_vue[0] != undefined">
										<h5>{{trans('front-hebergement.options')}} :</h5>
										<div class="form-check hover" v-if="item.hebergement.supplement_pension[0] != undefined">
											<input class="form-check-input" type="checkbox" name="pension_" id="pension_" @change="checkSupplement($event,'pension_',$getKey(item.hebergement.supplement_pension,'id'),'supplement_pension')">
											<label class="form-check-label" for="pension_" data-label="0€">
												{{trans('front-hebergement.formules')}}
											</label>
											<div class="ml-4" v-for="_pension of item.hebergement.supplement_pension">
												<input class="form-check-input modal-toggle" type="checkbox" :id="'pension_'+_pension.id" :name="'pension_'+_pension.id" @change="checkSupplement($event,'pension_',[_pension.id],'supplement_pension')" auto-label="supplement-personne">
												<label class="form-check-label modal-show" :for="'pension_'+_pension.id" data-label="0€">
													@{{_pension.titre}}
												</label>
											</div>

										</div>
										<div class="form-check hover" v-if="item.hebergement.supplement_activite[0] != undefined">
											<input class="form-check-input" type="checkbox" name="activite_" id="activite_" @change="checkSupplement($event,'activite_',$getKey(item.hebergement.supplement_activite,'id'),'supplement_activite')">
											<label class="form-check-label" for="activite_" data-label="0€">
												{{trans('front-hebergement.activites')}}
											</label>
											<div class="ml-4" v-for="_activite of item.hebergement.supplement_activite">
												<input class="form-check-input modal-toggle" type="checkbox" :id="'activite_'+_activite.id" :name="'activite_'+_activite.id" @change="checkSupplement($event,'activite_',[_activite.id],'supplement_activite')" auto-label="supplement-personne">
												<label class="form-check-label modal-show" :for="'activite_'+_activite.id" data-label="0€">
													@{{_activite.titre}}
												</label>
											</div>

										</div>
										<div class="form-check hover" v-if="item.hebergement.supplement_vue[0] != undefined">
											<input class="form-check-input" type="checkbox" disabled checked name="vue_" id="vue_">
											<label class="form-check-label" for="vue_" data-label="0€">
												{{trans('front-hebergement.vues')}}
											</label>
											<div class="ml-4" v-for="_vue of item.hebergement.supplement_vue">
												<input class="form-check-input modal-toggle" disabled type="checkbox" :id="'vue_'+_vue.id" :name="'vue_'+_vue.id" checked data-target="#modal-location" auto-label="supplement-chambre">
												<label class="form-check-label modal-show" :for="'vue_'+_vue.id" data-label="0€">
													@{{_vue.titre}}
												</label>
											</div>

										</div>
									</div>
								</div>
							</div>
							<div class="row product-footer">
								<div class="col-md-9 mb-2 vide"></div>
								<div class="col-md-3 py-3 mb-2 text-center price-total">
									<div class="total">
										<p>{{trans('front-hebergement.total')}} : <span class="tarif">@{{prixTotal}} €</span></p>
									</div>
								</div>
								<div class="col-md-9 mb-5 vide"></div>
								<div class="col-md-3 mb-5 btn btn-primary" @click.prevent="validerCommander" :id-commande="item.id" :reference-prix="item.reference_tarif.prix_vente" :titre-commande="item.type_chambre.name" :image-commande="item.type_chambre.image.length > 0? item.type_chambre.image[0].name:'/assets/img/bois-joli-bungalow.jpg'" :produit-url="url">
									<a @contextmenu.prevent="" class="btn text-white text-uppercase">{{trans('front-hebergement.reserver')}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="container" v-if="item == null || item.chambre_dispo <= 0">
				<div class="row">
					<div class="col alert alert-danger text-center" style="height: 100px; display: flex;align-items: center; justify-content: center;">
						@{{$dictionnaire.produit_commande_non_dispo_msg}}
					</div>
				</div>
			</div>
		</form>
	</section>
</hebergement-host-detail-avec-vol>
<hebergement-produit-associer :url="'{{route('hebergement-product-sans-vol')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$produit_associer->toJson()}}" inline-template>
	<section class="product-related pb-5 pt-5">
		<div class="container">
			<div class="mb-4 text-center">
				<h2 class="text-dark">{{trans('front-hebergement.produits_associes')}}</h2>
				<hr class="separator" />
			</div>
			<div class="slick-carousel">
				<div v-for="(item,index) in $grouperArrayRepet(collection,3)">
					<div class="justify-content-center row">
						<div class="col-md pb-3 pt-3" v-for="(chambre_item,chambre_index) in item">
							<div class="border h-100 d-flex flex-column">
								<a v-if="chambre_item.tarif.quantite_stock == undefined || chambre_item.tarif.quantite_stock > 0" @contextmenu.prevent="" @click.prevent="managerRequest($event,chambre_item.tarif.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:chambre_item.tarif.id})" href="#" class="d-block position-relative">
									<img :src="chambre_item.tarif.type_chambre.image.length > 0 ? `${urlasset}/${chambre_item.tarif.type_chambre.image[0].name}`: '{{asset('/assets/img/chambre-vue-mer.jpg')}}'" class="img-fluid w-100" style="max-height: 230px;">
								</a>
								<a v-if="chambre_item.tarif.quantite_stock != undefined && chambre_item.tarif.quantite_stock <= 0" @contextmenu.prevent="" @click.prevent="managerRequest($event,chambre_item.tarif.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:chambre_item.tarif.id})" href="#" class="d-block position-relative">
									<img :src="chambre_item.tarif.type_chambre.image.length > 0 ? `${urlasset}/${chambre_item.tarif.type_chambre.image[0].name}`: '{{asset('/assets/img/chambre-vue-mer.jpg')}}'" class="img-fluid w-100" style="max-height: 230px;">
								</a>
								<div class="pb-3 pl-4 pr-4 pt-4  d-flex flex-grow-1 flex-column position-relative">
									<div class="d-flex flex-column flex-grow-1">
										<div class="pb-1 pt-1 mb-auto">
											<a v-if="chambre_item.tarif.quantite_stock == undefined || chambre_item.tarif.quantite_stock > 0" @contextmenu.prevent="" @click.prevent="managerRequest($event,chambre_item.tarif.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:chambre_item.tarif.id})" href="#" class="text-dark text-decoration-none">
												<h5 class="mb-1 text-primary">@{{chambre_item.tarif.type_chambre.name}}</h5>
											</a>
											<a v-if="chambre_item.tarif.quantite_stock != undefined && chambre_item.tarif.quantite_stock <= 0" @contextmenu.prevent="" href="#" class="text-dark text-decoration-none">
												<h5 class="mb-1 text-primary">@{{chambre_item.tarif.type_chambre.name}}</h5>
											</a>
											<div class="d-flex">
												<div class="flex-fill font-size-0-8-em mt-2">
													<i class="fas fa-hotel text-primary mr-1"></i>
													<span>@{{chambre_item.hebergement.name}} @{{$countEtoil(chambre_item.hebergement.etoil)}}</span>
												</div>
												<div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
													<span>@{{chambre_item.tarif.type_chambre.capacite}} {{trans('front-hebergement.pers_max_1_chambre')}}</span>
												</div>
											</div>
											<div class="mt-3 position-relative">
												<div class="short-definition">
													<div class="more-definition p-2 position-absolute border">
														<p class="font-size-0-8-em">@{{$textDescription(chambre_item.tarif.type_chambre.description)}}</p>
													</div>
													<p class="font-size-0-8-em">@{{$textDescription(chambre_item.tarif.type_chambre.description, 100)}}</p>
												</div>
											</div>
										</div>
										<hr class="w-100">
										<div class="d-flex">
											<div class="flex-fill text-center px-1 border-right">
												<div class="font-size-0-8-em ">
													<i class="fas fa-user-friends mr-1"></i>
													<span>{{trans('front-hebergement.base')}} @{{chambre_item.tarif.base_type?chambre_item.tarif.base_type.nombre:''}} {{trans('front-hebergement.pers')}}</span>
												</div>
											</div>
											<div class="flex-fill text-center px-1" v-if="chambre_item.tarif.type_chambre.formule" style="width: 50%;">
												<div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
													<i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}"></i>
													<span style="width: 80%">@{{chambre_item.tarif.type_chambre.formule.desc}}</span>
												</div>
											</div>
											<div class="flex-fill text-center px-1" v-if="chambre_item.tarif.type_chambre.formule == null" style="width: 50%;">
												<div class="font-size-0-8-em supplement position-relative d-flex align-items-center">
													<span class="m-auto">{{trans('front-hebergement.hebergement_seul')}}</span>
												</div>
											</div>
										</div>
									</div>
									<hr />
									<div class="align-items-center d-flex justify-content-between">
										<div>
											<p class="font-size-15-px text-success">{{trans('front-hebergement.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{chambre_item.tarif.tarif.prix_vente}}&euro;</span> {{trans('front-hebergement.par_jour')}}</p>
											<div class="flex-fill font-size-0-8-em pt-1" :class="chambre_item.tarif.vol?'text-heb-avec-vol':'text-heb-sans-vol'">
												<i class="fas fa-plane mr-1"></i>
												<span v-if="chambre_item.tarif.vol">{{trans('front-hebergement.avec_vol')}}</span>
												<span v-if="!chambre_item.tarif.vol">{{trans('front-hebergement.sans_vol')}}</span>
											</div>
										</div>
										<div style="max-width: 50%;">
											<a v-if="chambre_item.tarif.quantite_stock == undefined || chambre_item.tarif.quantite_stock > 0" class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,chambre_item.tarif.vol?'{{ route('hebergement-product-avec-vol') }}':'{{ route('hebergement-product-sans-vol') }}',{id:chambre_item.tarif.id})" href="#">{{trans('front-hebergement.voir_cette_offre')}}</a>
											<a v-if="chambre_item.tarif.quantite_stock != undefined && chambre_item.tarif.quantite_stock <= 0" class="btn" style="background-color: #dc413cb5; color:white;" @contextmenu.prevent="" href="#">@{{$dictionnaire.produit_commande_non_dispo_msg}}</a>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
</hebergement-produit-associer>

@endsection