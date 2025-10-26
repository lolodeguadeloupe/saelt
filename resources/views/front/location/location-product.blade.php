@extends('front.layouts.layout')

@push('after-blocks-css')
<link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-slider/css/bootstrap-slider.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick.css') }}">
<link rel="stylesheet" href="{{ asset('assets/vendor/slick-1.8.1/slick-theme.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/style-single-product.css') }}">

<!--Flatpickr - datepicker css-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@endpush

@push('after-script-js')
<script src="{{ asset('assets/vendor/bootstrap-slider/bootstrap-slider.min.js') }}"></script>
<script src="{{ asset('assets/vendor/slick-1.8.1/slick.min.js') }}"></script>
<script src="{{ asset('assets/js/slick-script.js') }}"></script>
<script src="{{ asset('assets/js/slide-script.js') }}"></script>

<!--Flatpickr - datepicker js-->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<script>
	config = {
		dateFormat: "d-m-Y",
		minDate: "today"
	}

	flatpickr("input[type=datetime-local]", config);
</script>
@endpush

@section('title', trans('front-location.titre'))

@section('content')

@if(count($data) > 0)
<section class="banner page banner-overlay background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: {{'url(\''.asset('/assets/img/Mountain_Road.jpg').'\')'}};">
	<div class="container mt-5 mb-3 py-5">
		<div class="row">
			<div class="col-md">
				<h1 class="text-uppercase text-center">{{$data[0]['modele']['titre']}}</h1>
			</div>
		</div>
	</div>
</section>
@else
<section class=" mt-5 page banner-overlay pb-2 position-relative pt-5">
	<div class="container mt-5 mb-3 py-5">
		<div class="row h-100">
			<div class="col-md-12 h-100">
				<div class="border h-100 d-flex pb-3 pt-3" style="background-color:#eaeaea">
					<div class="m-auto">
						<p class="mb-0">Aucun produit disponible</p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
@endif
<location-product :url="'{{route('location-product')}}'" :urlbase="'{{base_url('')}}'" :urlasset="'{{asset('')}}'" :data="{{$data->toJson()}}" :saisons="{{$saisons->toJson()}}" :aside="{{$aside}}" :sessionrequest="{{$session_request}}" :keysessionrequest="'{{app('request')->has('key_')?app('request')->key_:''}}'" :mycommande="{{$commande_saved->toJson()}}" :editpannier="'{{$edit_pannier==false?'false':'true'}}'" inline-template>
	<section class="py-5">
		<div class="container" v-if="setItem(item)" v-for="(item,index) in collection">
			<div class="row under-banner detail-location">
				<div class="col-md-9 overview-option">
					<div class="slick-carousel-zoom center position-relative">
						<div class="img-car-preview" v-for="image of item.image">
							<img :src="urlasset+image.name" class="img-fluid w-100 detail-image-modal">
						</div>
						<div class="img-preview" v-if="item.image[0] == undefined">
							<img src="{{asset('/assets/img/c3-slide.jpg')}}" class="img-fluid w-100 detail-image-modal">
						</div>
					</div>

					<div class="position-absolute pr-2 w-100" style="bottom: -22px;" v-if="item.image[0] != undefined">
						<div class="ml-3 mr-5 slick-carousel-nav-zoom" style="background-color: #efe6e61c;">
							<div v-for="image of item.image" class="position-relative">
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
						<div class="price">
							<span>à partir de</span>
							<div class="txt">
								<h3>@{{item.tarif_location.prix_vente}}<span> €</span></h3>
								<p>/ jour</p>
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
					<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#overview">Vue d'ensemble</a></li>
					<li class="nav-item"><a class="text-secondary nav-link" role="tab" data-toggle="tab" href="#conditions">Conditions tarifaires</a></li>
					<li class="nav-item"><a class="text-secondary nav-link active" role="tab" data-toggle="tab" href="#booking">Réservation</a></li>
				</ul>

				<div class="tab-content">
					<div class="tab-pane fade" role="tabpanel" aria-labelledby="overview-tab" id="overview">
						<div class="row">
							<div class="col-sm-4">
								<div class="border-right mr-5">
									<ul class="trip-overview">
										<li v-if="item.info_tech.nombre_place">
											<img class="img-icon" src="{{asset('/assets/img/car-chair.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.nombre_place')}}</div>
												<div class="desc">@{{item.info_tech.nombre_place}} places</div>
											</div>
										</li>
										<li v-if="item.info_tech.nombre_porte">
											<img class="img-icon" src="{{asset('/assets/img/car-door.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.nombre_porte')}}</div>
												<div class="desc">@{{item.info_tech.nombre_porte}} portes</div>
											</div>
										</li>
										<li v-if="item.info_tech.type_carburant">
											<img class="img-icon" src="{{asset('/assets/img/fuel.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.type_carburant')}}</div>
												<div class="desc">@{{item.info_tech.type_carburant}}</div>
											</div>
										</li>
										<li v-if="item.info_tech.vitesse_maxi">
											<img class="img-icon" src="{{asset('/assets/img/tachometer.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.vitesse_maxi')}}</div>
												<div class="desc">@{{item.info_tech.vitesse_maxi}} km/h</div>
											</div>
										</li>
										<li v-if="item.info_tech.boite_vitesse">
											<img class="img-icon" src="{{asset('/assets/img/gearbox_.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.boite_vitesse')}}</div>
												<div class="desc">@{{item.info_tech.boite_vitesse}}</div>
											</div>
										</li>
										<li v-if="item.info_tech.kilometrage">
											<img class="img-icon" src="{{asset('/assets/img/road.png')}}" width="24">
											<div class="detail">
												<div class="title">{{trans('front-location.kilometrage')}}</div>
												<div class="desc">@{{item.info_tech.kilometrage}} km</div>
											</div>
										</li>
										<li class="mt-4 mr-1 pt-2" v-if="item.info_tech && item.info_tech.fiche_technique">
											<a class="text-success" style="cursor: pointer;" :href="`${urlasset}/${item.info_tech.fiche_technique}`" :download="item.modele_vehicule_titre"><i class="fa fa-download font-size-1-3-em float-left mr-4"></i> {{trans('front-location.fiche_technique')}} </a>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-sm-8">
								<div style="text-align: justify;">
									<p>La petite Citroën C3 Origins est très certainement la citadine la plus adaptée pour circuler en ville. Elle n’en reste pas là, elle conserve beaucoup d’atouts pour son gabarit compact. Elle possède une habitabilité ingénieuse permettant d’accueillir confortablement 4 adultes. Le volume du coffre est modulable en fonction des besoins grâce à la banquette coulissante de série. Son faible encombrement, son agilité et sa direction souple permettent à la Citroën C3 Origins de se faufiler partout et de se garer même dans un mouchoir de poche.</p>
								</div>

								<div class="share mt-5">
									<p class="share-text">Partager la publication "Citroën C3 Origins"</p>
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
								<!--div class="map">
    								<img class="img-map" src="{{asset('/assets/img/Guadeloupe_location_map.png')}}">
    							</div-->
							</div>
						</div>
					</div>
					<div class="tab-pane fade" role="tabpanel" aria-labelledby="conditions-tab" id="conditions">
						<div class="text-justify mx-5">
							<h5><strong>Le prix comprend :</strong></h5>
							<ul>
								<li>Les transferts et circuit en mini bus</li>
								<li>La location d'un véhicule</li>
								<li>Les services d'un chauffeur-guide</li>
							</ul>
							&nbsp;
							<h5><strong>Le prix ne comprend pas :</strong></h5>
							<ul>
								<li>Les déjeuners composés d'un menu complet : Entrée, plat, dessert et boissons (<em>Apéritif local, ¼ de vin, eau minérale, café</em>) <strong>(en option)</strong></li>
								<li>Les assurances facultatives</li>
								<li>Les entrées non prévues au programme</li>
								<li>Les pourboires et dépenses personnelles</li>
								<li>Les frais de dossier</li>
							</ul>
							&nbsp;
							<h5><strong>A savoir :</strong></h5>
							<em>(Article 12 des CGV) Les prix, horaires, itinéraires mentionnés dans nos programmes peuvent être modifiés du fait de l’organisateur par suite de circonstances indépendantes de sa volonté ou par suite d’événements dus à un cas de force majeure. Certaines excursions ou randonnées n'ont lieu que si un nombre suffisant de participants est inscrit. Se renseigner au préalable auprès de l'agence.</em>
						</div>
					</div>
					<div class="tab-pane fade show active" role="tabpanel" aria-labelledby="booking-tab" id="booking">
						<form id="reservetion_form">
							<div class="row">
								<div class="col-lg-9 px-5">
									<div class="mb-5 pb-4 border-bottom">
										<h4>Extras & Frees</h4>
										<hr class="separator mb-4 ml-0">
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="lieu-depart">Lieu de départ</label>
													<select class="form-control" id="lieu-depart" name="lieu_recuperation" required @change="selectLieu($event,(aside && aside.agence_location)?aside.agence_location:[])">
														<option value="">Sélectionner un lieu de départ</option>
														<option v-for="recuperation of (aside && aside.agence_location)?aside.agence_location:[]" :value="recuperation.id">@{{recuperation.name}}</option>
													</select>
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="lieu-retour">Lieu de retour</label>
													<select class="form-control" id="lieu-retour" name="lieu_restriction" required @change="selectLieu($event,(aside && aside.agence_location)?aside.agence_location:[])">
														<option value="">Sélectionner un lieu de retour</option>
														<option v-for="restriction of (aside && aside.agence_location)?aside.agence_location:[]" :value="restriction.id">@{{restriction.name}}</option>
													</select>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="date-depart">Date et heure de départ</label>
													<div class="row">
														<v-date-picker class="col-md form-group" :min-date="$maxDate(new Date(),min_calendar)" :max-date="$plusDays(max_calendar,-1)" :disabled-dates='calendarExclude.lieu_recuperation' v-model="lieu_recuperation">
															<template v-slot="{ inputValue, togglePopover }">
																<div class="input-group">
																	<input class="form-control" readonly type="date" required id="exampleFormControlSelect3" style="background-color: #fff" placeholder="-- / -- / ----" name="date_recuperation" :value='parseDateToString(inputValue)'>
																	<div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
																		<i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
																	</div>
																</div>
															</template>
														</v-date-picker>
														<vue-timepicker required tabindex="9999" class="col-md form-group" name="heure_recuperation" input-class="form-control" hide-clear-button :hour-range="heures.lieu_recuperation" :minute-interval="15" close-on-complete v-model="times_model.lieu_recuperation"></vue-timepicker>
													</div>
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="date-retour">Date et heure de retour</label>
													<div class="row">
														<v-date-picker class="col-md" :min-date="$maxDate(min_calendar,lieu_recuperation==''?new Date():lieu_recuperation)" :max-date="max_calendar" :disabled-dates='calendarExclude.lieu_restriction' v-model="lieu_restriction">
															<template v-slot="{ inputValue, togglePopover }">
																<div class="input-group">
																	<input class="form-control" readonly required type="date" id="exampleFormControlSelect4" style="background-color: #fff" placeholder="-- / -- / ----" name="date_restriction" :value='parseDateToString(inputValue)'>
																	<div class="input-group-append d-flex align-items-start mt-2" @click.prevent="togglePopover()">
																		<i class="fa fa-calendar" style="margin-left: -20px;z-index:5;color: black"></i>
																	</div>
																</div>
															</template>
														</v-date-picker>
														<vue-timepicker required tabindex="9999" class="col-md" name="heure_restriction" input-class="form-control" hide-clear-button :hour-range="heures.lieu_restriction" :minute-interval="15" close-on-complete v-model="times_model.lieu_restriction">
														</vue-timepicker>
													</div>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-6">
												<div class="form-group">
													<label>{{trans('admin.vehicule-location.columns.caution')}}</label>
													<div class="row">
														<div class="col-md">
															<input class="form-control" readonly type="text" style="background-color: #fff" name="caution" required :value="`${item.caution}€`">
														</div>
													</div>
												</div>
											</div>
											<div class="col-md-6">
												<div class="form-group">
													<label>Supplément lieu de restitution</label>
													<div class="row">
														<div class="col-md">
															<input class="form-control" readonly type="text" style="background-color: #fff" name="caution" required :value="`${item.categorie.supplement != null ? item.categorie.supplement.tarif:0}€`">
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-lg-3 mb-5 col-option price-total price-location">
									<div class="total">
										<p>Total : </p>
										<p><span class="tarif">@{{prixTotal }}€</span></p>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md mb-5 px-5">
									<div class="pb-4 border-bottom">
										<h4>Assurances</h4>
										<hr class="separator mb-4 ml-0">
										<div class="row">
											<div class="col-md detail-info">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="franchise" @change="checkAssurance($event,'franchise')">
													<label class="form-check-label" for="franchise" role="button">
														{{trans('admin.vehicule-location.columns.franchise')}} (@{{item.franchise}}€/jour)
													</label>
												</div>
												<div class="detail-block position-absolute">
													<ul class="list-info">
														<li><span>@{{item.franchise}}€/jour</span></li>
													</ul>
												</div>
											</div>
											<div class="col-md detail-info">
												<div class="form-check">
													<input class="form-check-input" type="checkbox" value="" id="franchise_non_rachatable" @change="checkAssurance($event,'franchise_non_rachatable')">
													<label class="form-check-label" for="franchise_non_rachatable" role="button">
														{{trans('admin.vehicule-location.columns.franchise_non_rachatable')}} (@{{item.franchise_non_rachatable}}€/jour)
													</label>
												</div>
												<div class="detail-block position-absolute">
													<ul class="list-info">
														<li><span>@{{item.franchise_non_rachatable}}€/jour</span></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md mb-5 px-5">
									<div class="pb-4 border-bottom">
										<h4>Informations du conducteur</h4>
										<hr class="separator mb-4 ml-0">
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="nom">Nom <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Z\sa-z]*" class="form-control" required type="text" id="nom" name="nom">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="prenom">Prénom(s) <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Z\sa-z]*" class="form-control" required type="text" id="prenom" name="prenom">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="adresse">Adresse <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Za-z0-9\s]*" class="form-control" required type="text" id="adresse" name="adresse">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="ville">Ville <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Za-z0-9\s]*" class="form-control" required type="text" id="ville" name="ville">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="code-postal">Code postal <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[0-9]*" class="form-control" required type="text" id="code-postal" name="code-postal">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="telephone">Téléphone <span style="color:#ab2e30">*</span> :</label>
													<input data-ctr="phone" placeholder="+261 xx xx xxx xx" class="form-control" required type="text" id="telephone" name="telephone">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="email">Email <span style="color:#ab2e30">*</span> :</label>
													<input data-ctr="email" class="form-control" required type="email" id="email" name="email">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="date-naissance">Date de naissance <span style="color:#ab2e30">*</span> : <span class="text-success">( Age minimum : 21 ans )</span></label>
													<input class="form-control" :min="$parseDateToString($plusYears(new Date(), -70))" :max="$parseDateToString($plusYears(new Date(),-21))" required type="date" id="date-naissance" name="date-naissance" style="background-color: #fff" placeholder="..-..-....">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="lieu-naissance">Lieu de naissance <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Za-z0-9\s]*" class="form-control" required type="text" id="lieu-naissance" name="lieu-naissance">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="num-permis">Numero de permis <span style="color:#ab2e30">*</span> :</label>
													<input pattern="\d*" class="form-control" required type="text" id="num-permis" name="num-permis">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="date-permis">Date de permis <span style="color:#ab2e30">*</span> : <span class="text-success">( Année de permis + 2ans )</span></label>
													<input :min="$parseDateToString($plusYears(new Date(), -70))" :max="$parseDateToString($plusYears(new Date(),-2))" class="form-control" required type="date" id="date-permis" name="date-permis" style="background-color: #fff" placeholder="..-..-....">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="lieu-deliv-permis">Lieu de délivrance du permis <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Za-z0-9\s]*" class="form-control" required type="text" id="lieu-deliv-permis" name="lieu-deliv-permis">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md">
												<div class="form-group">
													<label for="num-identite">Numero de pièce d'identité <span style="color:#ab2e30">*</span> :</label>
													<input pattern="\d*" class="form-control" required type="text" id="num-identite" name="num-identite">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="date-emis-identite">Date émission pièce d'identité <span style="color:#ab2e30">*</span> :</label>
													<input :min="$parseDateToString($plusYears(new Date(), -20))" :max="$parseDateToString($plusYears(new Date(),0))" class="form-control" required type="date" id="date-emis-identite" name="date-emis-identite" style="background-color: #fff" placeholder="..-..-....">
												</div>
											</div>
											<div class="col-md">
												<div class="form-group">
													<label for="lieu-deliv-identite">Lieu de délivrance pièce d'identité <span style="color:#ab2e30">*</span> :</label>
													<input pattern="[A-Za-z0-9\s]*" class="form-control" required type="text" id="lieu-deliv-identite" name="lieu-deliv-identite">
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="row">
								<div class="col-md-12 px-5">
									<h4>Informations additionnelles</h4>
									<hr class="separator mb-4 ml-0">
									<div class="form-group">
										<label for="info-add">Informations additionnelles</label>
										<textarea class="form-control" name="order_comments" id="info-add" name="info-add" cols="30" rows="10"></textarea>
									</div>
								</div>
							</div>
							<div class="row product-footer">
								<div class="col-md-9 px-5 my-3">
									<div class="checkbox">
										<input id="checkboxa1" type="checkbox" v-model="accepted" class="mr-2 input-checked-confirm">
										<label for="checkboxa1" class="label-checked-confirm">J'accepte toutes les informations et </label>&nbsp;<span class="label-checked-confirm link-checked-confirm" @click.prevent="$modal.show('terme-condition')"> les conditions.</span>
									</div>
								</div>
								<div class="col-md-3 px-5 mb-5" @click.prevent="validerCommander($event)" :id-commande="item.id" :reference-prix="item.tarif_location.prix_vente" :titre-commande="item.modele.titre" :image-commande="item.image.length > 0? item.image[0].name:'/assets/img/c3-slide.jpg'" :produit-url="url">
									<a v-if="accepted" @contextmenu.prevent="" class="btn btn-primary text-white" href="#">Réserver maintenant</a>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<modal name="terme-condition" :class="'max-width'" :click-to-close="false" :scrollable="true" height="auto" width="100%" :draggable="true" :adaptive="true">
			@include('front.terme-condition')
		</modal>
	</section>
</location-product>
<section class="product-related pb-5 pt-5 d-none">
	<div class="container">
		<div class="mb-4 text-center">
			<h2 class="text-dark">Produits associés</h2>
			<hr class="separator" />
		</div>
		<div class="slick-carousel">
			<div>
				<div class="row">
					<div class="col-md-4 pb-3 pt-3">
						<div class="border">
							<a href="#" class="d-block position-relative"><img src="{{asset('/assets/img/duster.jpg')}}" class="img-fluid w-100"></a>
							<div class="pb-3 pl-4 pr-4 pt-4">
								<div>
									<div class="pt-1">
										<a href="#" class="text-dark text-decoration-none">
											<h5 class="mb-1 text-primary">Dacia Duster</h5>
										</a>
										<div class="font-size-0-8-em mt-2">
											<i class="fa fa-list-ul text-primary mr-1"></i>
											<span>Catégorie B SUV</span>
										</div>
										<div class="mt-3">
											<p class="font-size-0-8-em">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
									<hr />
									<div class="d-flex font-size-0-8-em">
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-chair.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-door.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/fuel.png')}}" width="12">
											<span>Essence</span>
										</div>
										<div class="flex-fill text-center img-icon">
											<img class="mr-1" src="{{asset('/assets/img/gearbox.png')}}" width="13">
											<span>Manuel</span>
										</div>
									</div>
								</div>
								<hr />
								<div class="align-items-center d-flex justify-content-between">
									<div>
										<p class="font-size-15-px text-success"><span class="font-size-1-3-em font-weight-bold">32&euro;</span> / jour</p>
									</div>
									<div>
										<a class="btn btn-primary text-white" href="#" data-dismiss="modal">Voir l'offre</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 pb-3 pt-3">
						<div class="border">
							<a href="#" class="d-block position-relative"><img src="{{asset('/assets/img/duster.jpg')}}" class="img-fluid w-100"></a>
							<div class="pb-3 pl-4 pr-4 pt-4">
								<div>
									<div class="pt-1">
										<a href="#" class="text-dark text-decoration-none">
											<h5 class="mb-1 text-primary">Dacia Duster</h5>
										</a>
										<div class="font-size-0-8-em mt-2">
											<i class="fa fa-list-ul text-primary mr-1"></i>
											<span>Catégorie B SUV</span>
										</div>
										<div class="mt-3">
											<p class="font-size-0-8-em">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
									<hr />
									<div class="d-flex font-size-0-8-em">
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-chair.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-door.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/fuel.png')}}" width="12">
											<span>Essence</span>
										</div>
										<div class="flex-fill text-center img-icon">
											<img class="mr-1" src="{{asset('/assets/img/gearbox.png')}}" width="13">
											<span>Manuel</span>
										</div>
									</div>
								</div>
								<hr />
								<div class="align-items-center d-flex justify-content-between">
									<div>
										<p class="font-size-15-px text-success"><span class="font-size-1-3-em font-weight-bold">32&euro;</span> / jour</p>
									</div>
									<div>
										<a class="btn btn-primary text-white" href="#" data-dismiss="modal">Voir l'offre</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-4 pb-3 pt-3">
						<div class="border">
							<a href="#" class="d-block position-relative"><img src="{{asset('/assets/img/duster.jpg')}}" class="img-fluid w-100"></a>
							<div class="pb-3 pl-4 pr-4 pt-4">
								<div>
									<div class="pt-1">
										<a href="#" class="text-dark text-decoration-none">
											<h5 class="mb-1 text-primary">Dacia Duster</h5>
										</a>
										<div class="font-size-0-8-em mt-2">
											<i class="fa fa-list-ul text-primary mr-1"></i>
											<span>Catégorie B SUV</span>
										</div>
										<div class="mt-3">
											<p class="font-size-0-8-em">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
										</div>
									</div>
									<hr />
									<div class="d-flex font-size-0-8-em">
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-chair.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/car-door.png')}}" width="12">
											<span>5</span>
										</div>
										<div class="flex-fill text-center img-icon border-right">
											<img class="mr-1" src="{{asset('/assets/img/fuel.png')}}" width="12">
											<span>Essence</span>
										</div>
										<div class="flex-fill text-center img-icon">
											<img class="mr-1" src="{{asset('/assets/img/gearbox.png')}}" width="13">
											<span>Manuel</span>
										</div>
									</div>
								</div>
								<hr />
								<div class="align-items-center d-flex justify-content-between">
									<div>
										<p class="font-size-15-px text-success"><span class="font-size-1-3-em font-weight-bold">32&euro;</span> / jour</p>
									</div>
									<div>
										<a class="btn btn-primary text-white" href="#" data-dismiss="modal">Voir l'offre</a>
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
@endsection