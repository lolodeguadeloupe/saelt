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

<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.(isset($data[0]['fond_image'])?asset($data[0]['fond_image']):asset('/assets/img/La_Creole_Beach_Hotel_Spa-Le_Gosier-Schwimmbad.jpg')).'\')'}};">
	<div class="container mt-5 mb-3 py-5">
		<div class="row">
			<div class="col-md text-center">
				<h1 class="main-header" itemprop="name">
					{{$data[0]['title']}}
				</h1>
				<h4 class="sub-header">{{$data[0]['description']}}</h4>
			</div>
		</div>
	</div>
</section>
<excursion-product :url="'{{route('excursion-product')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" :personne="{{$personne->toJson()}}" :mycommande="{{$commande_saved->toJson()}}" :editpannier="'{{$edit_pannier==false?'false':'true'}}'" inline-template>
	<section class="py-5">
		<form id="reservetion_form">
			<div class="container" v-if="setItem(item) == true" v-for="(item,index) in collection">
				<div class="row under-banner">
					<div class="col-md-9 overview-option">
						<div class="slick-carousel-zoom center position-relative">
							<div class="img-preview" v-for="(image,index) in item.image">
								<img :src="`${urlasset}/${image.name}`" class="img-fluid w-100 detail-image-modal">
							</div>
							<div class="img-preview" v-if="item.image[0] == undefined">
								<img src="{{asset('/assets/img/4x4.jpg')}}" class="img-fluid w-100 detail-image-modal">
							</div>
						</div>

						<div class="position-absolute pr-2 w-100" style="bottom: -22px;"  v-if="item.image[0] != undefined">
							<div class="ml-3 mr-5 slick-carousel-nav-zoom" style="background-color: #efe6e61c;">
								<div v-for="(image,index) in item.image" class="position-relative">
									<img :src="`${urlasset}/${image.name}`" style="width: auto; height: 50px;">
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
							<span class="product-tag d-none">{{trans('front-excursion.en_promos')}}</span>
							<div class="price">
								<span>{{trans('front-excursion.a_partir_de')}}</span>
								<div class="txt">
									<h3>@{{item.reference_tarif?item.reference_tarif.prix_vente:0}}<span> €</span></h3> 
									<p>{{trans('front-excursion.par_personne')}}</p>
									<p> (HT)</p>
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
						<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#overview">{{trans('front-excursion.info_pratique')}}</a></li>
						<!--<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#conditions">{{trans('front-excursion.conditions_tarifaires')}}</a></li>-->
						<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#itinerary">{{trans('front-excursion.itineraire')}}</a></li>
						<li class="nav-item"><a class="text-secondary nav-link active" role="tab" data-toggle="tab" href="#booking">{{trans('front-excursion.reservation')}}</a></li>
					</ul>

					<div class="tab-content">
						<div class="tab-pane fade" role="tabpanel" aria-labelledby="overview-tab" id="overview">
							<div class="row">
								<div class="col-sm-4">
									<div class="border-right mr-5">
										<ul class="trip-overview mr-5">
											<li>
												<img class="img-icon" src="{{asset('/assets/img/earth.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.ile')}}</div>
													<div class="desc">
														<a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-all-products') }}',{ile:item.ile.id})" href="#" rel="tag">@{{item.ile.name}}</a>
													</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/clock.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.duree')}}</div>
													<div class="desc">{{trans('front-excursion.une_')}} @{{$lowerCase(item.duration)}}</div>
												</div>
											</li>
											<li>
												<img class="img-icon" src="{{asset('/assets/img/calendar.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.jours_disponibles')}}</div>
													<div class="desc d-flex text-center date-dispo">
														<div class="flex-fill border text-white" :class="$stringIncludesArray(availability(item.availability),index)?'dispo':''" :title="week" v-for="(week ,index) in $dictionnaire.week_list">@{{$getPositionString(week,0,1)}}</div>
													</div>
												</div>
											</li>
											<li class="d-none">
												<img class="img-icon" src="{{asset('/assets/img/map-with-a-pin-small-symbol-inside-a-circle.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.depart')}}</div>
													<div class="desc">@{{item.ile.name}}</div>
												</div>
											</li>
											<li v-if="item.lunch == 1">
												<img class="img-icon" src="{{asset('/assets/img/clipboard.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.formule')}}</div>
													<div class="desc">{{trans('front-excursion.repas')}}</div>
												</div>
											</li>
											<li v-if="item.ticket == 1">
												<img class="img-icon" src="{{asset('/assets/img/clipboard.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.inclus')}}</div>
													<div class="desc">{{trans('front-excursion.billet_avion')}}</div>
												</div>
											</li>
											<li v-if="(item.ticket == 0 && item.lunch == 0)">
												<img class="img-icon" src="{{asset('/assets/img/clipboard.png')}}" width="24">
												<div class="detail">
													<div class="title">{{trans('front-excursion.formule')}}</div>
													<div class="desc">{{trans('front-excursion.excursion_seule')}}</div>
												</div>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-sm-8">
									<div style="text-align: justify;" v-html="item.info_pratique.info_pratique"></div>

									<div class="share mt-5">
										<p class="share-text">Partager la publication "Aventure tout terrain"</p>
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
						<!--<div class="tab-pane fade" role="tabpanel" aria-labelledby="conditions-tab" id="conditions">
							<div class="text-justify mx-5" v-html="item.condition_tarifaire.condition_tarifaire"></div>
						</div>-->
						<div class="tab-pane fade" role="tabpanel" aria-labelledby="itinerary-tab" id="itinerary">
							<div class="text-justify mx-5" v-if="item.itineraire" v-html="item.itineraire.description"></div>
						</div>
						<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="booking-tab" id="booking">
							<div class="row">
								<div class="col-md-5 px-5 mb-5 col-calendar">
									<div class="nb-days mb-3 row">
										<div class="col-6">
											<h5 class="required">{{trans('front-excursion.date_excursion')}} :</h5>
										</div>
										<div class="col-6">
											<p>@{{$getArrayDateString(selectCalendarDate)}}</p>
										</div>
									</div>
									<div class="calendar" id="my_calendar" :data-calendarexclusive="$toJson(item.calendar)" :date-disponible="$toJson(availability(item.availability))">
										<v-calendar is-expanded :from-page="fromDate" :attributes="attributes" :min-date='$maxDate(new Date(),min_saison)' :max-date='max_saison' :disabled-dates='disabledDates' @dayclick="onDayClick">
										</v-calendar>
									</div>
									<div class="mb-3 mt-3 float-left d-none" style="width: 100%;">
										<div class="detail">
											<div class="title pb-3 d-flex align-items-center">
												<img class="img-icon" src="{{asset('/assets/img/calendar.png')}}" width="24">
												<span class="ml-2">{{trans('front-excursion.jours_disponibles')}}</span>
											</div>
											<div class="desc d-flex text-center date-dispo">
												<div class="flex-fill border text-white" :class="$stringIncludesArray(availability(item.availability),index)?'dispo':''" :title="week" v-for="(week ,index) in $dictionnaire.week_list">@{{$getPositionString(week,0,1)}}</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 pl-3 pr-5 mb-5 col-pers">
									<div class="nb-pers">
										<h5 class="required">{{trans('front-excursion.nombre_de_personnes')}} :</h5>
										<div class="block-input" v-for="_personne of item.tarif">
											<div class="label-pers">
												<span class="pers-tarif" :id="'personne_'+_personne.personne.id">0 €</span>
												<label class="form-label">@{{_personne.personne.type}} (@{{_personne.personne.age}})</label>
											</div>
											<input type="number" :name="'personne_'+_personne.personne.id" class="form-input" required :min="_personne.personne.id == '1'?1:0" step="1" data-oldValue="0" value="0" :data-tarif="_personne.prix_vente" @input="checkPersonne($event,'personne_',$getKey(item.tarif,'type_personne_id'),_personne.personne.id)" @focusout="$setDefaultValue" :data-capacite="item.participant_min">
										</div>
									</div>
								</div>
								<div class="col-md-4 px-5 mb-5 col-option">
									<div class="text-justify mx-0">
										<h5>{{trans('front-excursion.conditions_tarifaires')}} :</h5>
										<div v-html="item.condition_tarifaire.condition_tarifaire"></div>
									</div>
									<hr v-if="!(item.supplement.dejeneur == undefined && item.supplement.activite == undefined && item.supplement.autres == undefined)">
									<div class="option-checked" v-if="!(item.supplement.dejeneur == undefined && item.supplement.activite == undefined && item.supplement.autres == undefined)">
										<h5>{{trans('front-excursion.options')}} :</h5>
										<div class="form-check" :class="item.supplement.dejeneur != undefined ? 'hover':''" v-if="((item.supplement.dejeneur != undefined && item.supplement.dejeneur[0] != undefined))">
											<input class="form-check-input" type="checkbox" :id="'dejeneur_'" :name="'dejeneur_'" @change="checkSupplement($event,'dejeneur_',$getKey(item.supplement.dejeneur,'id'),'dejeneur')">
											<label class="form-check-label" for="dejeneur_" data-label="0€">
												{{trans('admin.supplement-excursion.type.dejeneur')}}s
											</label>
											<div class="ml-4" v-if="item.supplement.dejeneur != undefined" v-for="_supplement of item.supplement.dejeneur">
												<input class="form-check-input modal-toggle" type="checkbox" :id="'dejeneur_'+_supplement.id" :name="'dejeneur_'+_supplement.id" :data-prix="$toJson(_supplement)" @change="checkSupplement($event,'dejeneur_',[_supplement.id],'dejeneur')" auto-label="supplement-personne">
												<label class="form-check-label modal-show" :for="'dejeneur_'+_supplement.id" data-label="0€">
													@{{_supplement.titre}}
												</label>
											</div>
										</div>
										<div class="form-check" :class="item.supplement.activite != undefined ? 'hover':''" v-if="(item.supplement.activite != undefined && item.supplement.activite[0] != undefined)">
											<input class="form-check-input" type="checkbox" :id="'activite_'" :name="'activite_'" @change="checkSupplement($event,'activite_',$getKey(item.supplement.activite,'id'),'activite')">
											<label class="form-check-label" for="activite_" data-label="0€">
												{{trans('admin.supplement-excursion.type.activite')}}s
											</label>
											<div class="ml-4" v-if="item.supplement.activite != undefined" v-for="_supplement of item.supplement.activite">
												<input class="form-check-input modal-toggle" type="checkbox" :id="'activite_'+_supplement.id" :name="'activite_'+_supplement.id" :data-prix="$toJson(_supplement)" @change="checkSupplement($event,'activite_',[_supplement.id],'activite')" auto-label="supplement-personne">
												<label class="form-check-label modal-show" :for="'activite_'+_supplement.id" data-label="0€">
													@{{_supplement.titre}}
												</label>
											</div>
										</div>
										<div class="form-check" :class="item.supplement.autres != undefined ? 'hover':''" v-if="(item.supplement.autres != undefined && item.supplement.autres[0] != undefined)">
											<input class="form-check-input" type="checkbox" :id="'autres_'" :name="'autres_'" @change="checkSupplement($event,'autres_',$getKey(item.supplement.autres,'id'),'autres')">
											<label class="form-check-label" for="autres_" data-label="0€">
												{{trans('admin.supplement-excursion.type.autres')}}
											</label>
											<div class="ml-4" v-if="item.supplement.autres != undefined" v-for="_supplement of item.supplement.autres">
												<input class="form-check-input modal-toggle" type="checkbox" :id="'autres_'+_supplement.id" :name="'autres_'+_supplement.id" :data-prix="$toJson(_supplement)" @change="checkSupplement($event,'autres_',[_supplement.id],'autres')" auto-label="supplement-personne">
												<label class="form-check-label modal-show" :for="'autres_'+_supplement.id" data-label="0€">
													@{{_supplement.titre}}
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
										<p>{{trans('front-excursion.total')}} : <span class="tarif">@{{prixTotal}} €</span></p>
									</div>
								</div>
								<div class="col-md-9 mb-5 vide"></div>
								<div class="col-md-3 mb-5 btn btn-primary" v-if="selectCalendarDate[0] != undefined" @click.prevent="validerCommander" :id-commande="item.id" :reference-prix="item.reference_tarif.prix_vente" :titre-commande="item.title" :image-commande="item.image.length > 0? item.image[0].name:'/assets/img/4x4.jpg'" :produit-url="url">
									<a @contextmenu.prevent="" class="btn text-white text-uppercase" href="#">{{trans('front-excursion.reserver')}}</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</section>
</excursion-product>
<excursion-produit-associer :url="'{{route('excursion-product')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$produit_associer->toJson()}}" inline-template>
	<section class="product-related pb-5 pt-5">
		<div class="container">
			<div class="mb-4 text-center">
				<h2 class="text-dark">{{trans('front-hebergement.produits_associes')}}</h2>
				<hr class="separator" />
			</div>
			<div class="slick-carousel slick-product">
				<div v-for="(item,index) in $grouperArrayRepet(collection,3)">
					<div class="justify-content-center row">
						<div class="col-md-4 pb-3 pt-3" v-for="(excursion_item,excursion_index) in item">
							<div class="border h-100 d-flex flex-column">
								<a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:excursion_item.id})" href="#" class="d-block position-relative">
									<img :src="(excursion_item.image && excursion_item.image[0] != undefined) ? `${urlasset}/${excursion_item.image[0].name}`:'{{asset('/assets/img/La_Creole_Beach_Hotel_Spa-Le_Gosier-thumb.jpg')}}'" class="img-fluid w-100">
								</a>
								<div class="pb-3 pl-4 pr-4 pt-4 d-flex flex-grow-1 flex-column position-relative">
									<div class="d-flex flex-column flex-grow-1">
										<div class="pb-1 pt-1 mb-auto">
											<a @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:excursion_item.id})" href="#" class="text-dark text-decoration-none">
												<h5 class="mb-1 text-primary">@{{excursion_item.title}}</h5>
											</a>
											<div class="d-flex">
												<div class="flex-fill font-size-0-8-em mt-2">
													<i class="fa-map-marker-alt fas text-primary mr-1"></i>
													<span>@{{excursion_item.ile.name}}</span>
												</div>
												<div class="flex-fill font-size-0-8-em mt-2 border-left text-center">
													<span>{{trans('front-excursion.une_')}} @{{$lowerCase(excursion_item.duration)}}</span>
												</div>
											</div>
											<div class="mt-3 position-relative">
												<div class="short-definition">
													<div class="more-definition p-2 rounded-sm position-absolute border">
														<p class="font-size-0-8-em">@{{$textDescription(excursion_item.description)}}</p>
													</div>
													<p class="font-size-0-8-em">@{{$textDescription(excursion_item.description, 100)}}</p>
												</div>
											</div>
										</div>
										<hr class="w-100">
										<div class="d-flex">
											<div class="flex-fill text-center px-1 border-right">
												<div class="font-size-0-8-em jour-dispo position-relative">
													<i class="fa-calendar-alt far mr-1"></i>
													<span>@{{$availability(excursion_item.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
													<div class="jour-dispo-detail rounded-sm p-2 border">
														<i class="fa-calendar-alt far mr-1"></i>
														<span>@{{$availability(excursion_item.availability).length}} {{trans('front-excursion.jours_sur_7')}}</span>
														<ul class="mt-2 pt-2 border-top">
															<li v-for="jour of $availability(excursion_item.availability)">@{{jour}}</li>
														</ul>
													</div>
												</div>
											</div>
											<div class="flex-fill text-center px-1 d-flex" v-if="(excursion_item.lunch == 1 || excursion_item.ticket == 1)">
												<div class="font-size-0-8-em position-relative d-flex align-items-center m-auto" v-if="excursion_item.ticket == 1 || excursion_item.lunch == 1">
													<i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/repas.png')}}');" v-if="excursion_item.lunch == 1"></i>
													<span v-if="excursion_item.lunch == 1">{{trans('front-excursion.repas')}}</span>
													<span v-if="excursion_item.ticket == 1 && excursion_item.lunch == 1">&nbsp; + &nbsp;</span>
													<i class="fas fa-supp-icon mr-1" style="background-image: url('{{asset('images/ticket.png')}}');" v-if="excursion_item.ticket == 1"></i>
													<span v-if="excursion_item.ticket == 1">{{trans('front-excursion.billet_avion')}}</span>
												</div>
											</div>
											<div class="flex-fill text-center px-1 d-flex" v-if="(excursion_item.lunch == 0 && excursion_item.ticket == 0)">
												<div class="font-size-0-8-em position-relative d-flex align-items-center m-auto">
													<span>{{trans('front-excursion.excursion_seule')}}</span>
												</div>
											</div>
										</div>
									</div>
									<hr />
									<div class="align-items-center d-flex justify-content-between">
										<div>
											<p class="font-size-15-px text-success">{{trans('front-excursion.a_partir_de')}}<br><span class="font-size-1-3-em font-weight-bold">@{{excursion_item.tarif?excursion_item.tarif.prix_vente:0}}&euro;</span> {{trans('front-excursion.par_personne')}}</p>
										</div>
										<div>
											<a class="btn btn-primary text-white" @contextmenu.prevent="" @click.prevent="managerRequest($event,'{{ route('excursion-product') }}',{id:excursion_item.id})" href="#">{{trans('front-excursion.voir_cette_offre')}}</a>
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
</excursion-produit-associer>

@endsection