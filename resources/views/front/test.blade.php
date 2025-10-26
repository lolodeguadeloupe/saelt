@extends('front.layouts.layout')

@push('after-blocks-css')

@endpush

@push('after-script-js')

@endpush

@section('content')

<excursion-front :momprops="'manitra'" inline-template>
    <div>
        <section class="background-cover bg-dark pb-5 position-relative pt-5 text-white" style="background-image: url('assets/img/ct_sea-418742_1920.jpg');">
            <div class="container mt-5 pt-4">
                <div class="row">
                    <div class="col-md">
                        <h1 class="text-uppercase">Excursions</h1>
                    </div>
                </div>
            </div>
        </section>
        <section class="py-5">
            <div class="container">
                <div class="justify-content-center row">
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Guadeloupe.jpg');">
                            <div>
                                <a href="excursion_guadeloupe.html" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Guadeloupe_location_map-1-110x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Guadeloupe</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Marie-Galante-1.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Marie_Galante_location_map-100x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Marie-Galante</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Les-Saintes.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Les_Saintes_location_map-155x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Les Saintes</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-center row">
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/La-desirade.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/La_Desirade_location_map-150x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">La Desirade</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Martinique-1.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Martinique_location_map-85x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Martinique</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/St-Martin.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Saint_Martin_location_map-150x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Saint-Martin</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="justify-content-center row">
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/La-Dominique-1.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/La_Dominique_location_map-50x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">La Dominique</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Ste-Lucie-1.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Saint_Lucia_location_map-1-50x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">Sainte Lucie</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md py-3">
                        <div class="align-items-center background-center-center background-cover d-flex h-100 justify-content-center px-2 py-5" style="background-image: url('assets/img/Republique_Dominicaine.jpg');">
                            <div>
                                <a href="#" class="text-center text-decoration-none text-white">
                                    <div>
                                        <img src="assets/img/Republique_Dominicaine_location_map-150x100.png" class="mw-100 mx-auto">
                                        <div>
                                            <h3 class="text-shadow">République Dominicaine</h3>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</excursion-front>

@endsection