<footer class="bg-theme-black pt-5 text-white">
    <div class="container">
        <div class="row">
            <div class="col-md-4">
                <h4>INFORMATIONS PRATIQUES</h4>
                <hr class="ml-0 separator" />
                <div>
                    <ul class="list-unstyled">
                        <li>
                            <a href="#" class="text-white">A propos de nous</a>
                        </li>
                        <li>
                            <a href="#" class="text-white">Conditions générales de vente</a>
                        </li>
                        <li>
                            <a href="#" class="text-white">Mentions légales</a>
                        </li>
                        <li>
                            <a href="#" class="text-white">Contact</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-4">
                <h4>NOTRE FLOTTE</h4>
                <hr class="ml-0 separator" />
                <p>SAELT accompagne vos clients tout au long de leur séjour... Voir plus</p>
                <div class="row">
                    @foreach(json_decode($aside)->flot as $_flot)
                    <div class="col-md-4 text-center" title="{{$_flot->titre}}">
                        @if($_flot->vehicule != null)
                        <img src="{{asset($_flot->vehicule)}}" class="w-100">
                        @else
                        <img src="{{asset('/assets/img/autocar.jpg')}}" class="w-100">
                        @endif
                        <p class="mt-3 text-overflow-ellipsis">{{$_flot->titre}}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="col-md-4 social-media">
                <h4>RÉSEAUX SOCIAUX</h4>
                <hr class="ml-0 separator" />
                <div class="d-inline-flex flex-wrap">
                    <a href="#" class="btn btn-primary btn-sm line-height-1 mx-1 p-2 rounded-circle"> <svg viewBox="0 0 24 24" fill="currentColor" width="1.5em" height="1.5em">
                            <path d="M14 13.5h2.5l1-4H14v-2c0-1.03 0-2 2-2h1.5V2.14c-.326-.043-1.557-.14-2.857-.14C11.928 2 10 3.657 10 6.7v2.8H7v4h3V22h4v-8.5z" />
                        </svg> </a>
                    <a href="#" class="btn btn-primary btn-sm line-height-1 mx-1 p-2 rounded-circle"> <svg viewBox="0 0 24 24" fill="currentColor" width="1.5em" height="1.5em">
                            <path d="M22.162 5.656a8.384 8.384 0 0 1-2.402.658A4.196 4.196 0 0 0 21.6 4c-.82.488-1.719.83-2.656 1.015a4.182 4.182 0 0 0-7.126 3.814 11.874 11.874 0 0 1-8.62-4.37 4.168 4.168 0 0 0-.566 2.103c0 1.45.738 2.731 1.86 3.481a4.168 4.168 0 0 1-1.894-.523v.052a4.185 4.185 0 0 0 3.355 4.101 4.21 4.21 0 0 1-1.89.072A4.185 4.185 0 0 0 7.97 16.65a8.394 8.394 0 0 1-6.191 1.732 11.83 11.83 0 0 0 6.41 1.88c7.693 0 11.9-6.373 11.9-11.9 0-.18-.005-.362-.013-.54a8.496 8.496 0 0 0 2.087-2.165z" />
                        </svg> </a>
                    <a href="#" class="btn btn-primary btn-sm line-height-1 mx-1 p-2 rounded-circle"> <svg viewBox="0 0 24 24" fill="currentColor" width="1.5em" height="1.5em">
                            <path d="M6.94 5a2 2 0 1 1-4-.002 2 2 0 0 1 4 .002zM7 8.48H3V21h4V8.48zm6.32 0H9.34V21h3.94v-6.57c0-3.66 4.77-4 4.77 0V21H22v-7.93c0-6.17-7.06-5.94-8.72-2.91l.04-1.68z" />
                        </svg> </a>
                    <a class="btn btn-primary btn-sm line-height-1 mx-1 p-2 rounded-circle" href="#"> <svg viewBox="0 0 24 24" fill="currentColor" width="1.5em" height="1.5em">
                            <path d="M21.543 6.498C22 8.28 22 12 22 12s0 3.72-.457 5.502c-.254.985-.997 1.76-1.938 2.022C17.896 20 12 20 12 20s-5.893 0-7.605-.476c-.945-.266-1.687-1.04-1.938-2.022C2 15.72 2 12 2 12s0-3.72.457-5.502c.254-.985.997-1.76 1.938-2.022C6.107 4 12 4 12 4s5.896 0 7.605.476c.945.266 1.687 1.04 1.938 2.022zM10 15.5l6-3.5-6-3.5v7z" />
                        </svg> </a>
                </div>
            </div>
        </div>
        <div class="mt-4 row">
            <div class="col-md-4">
                <h4>NOS PARTENAIRES</h4>
                <hr class="ml-0 separator" />
                <div>
                    <img src="{{asset('/assets/img/Les-entreprisesdu-voyages.jpg')}}" class="mb-2 mh-120-px mr-2 mw-100">
                    <img src="{{asset('/assets/img/Atout-France.jpg')}}" class="mb-2 mh-120-px mr-2 mw-100">
                    <img src="{{asset('/assets/img/Apst-home.jpg')}}" class="mb-2 mh-120-px mr-2 mw-100">
                </div>
                <!--<div>
                    @foreach(json_decode($aside)->partenaire as $partenaire)
                    @if($partenaire->logo != null)
                    <img src="{{asset($partenaire->logo)}}" class="mb-2 mh-120-px mr-2 mw-100 d-inline-block">
                    @else
                    <div class="mb-2 mh-120-px mr-2 mw-100 d-inline-block">{{$partenaire->name}}</div>
                    @endif
                    @endforeach
                </div>
-->
            </div>
            <div class="col-md">
                <h4>PAIEMENTS ACCEPTES</h4>
                <hr class="ml-0 separator" />
                <div></div>
                <div>
                    @foreach(json_decode($aside)->paiement as $paiement)
                    @if($paiement->icon != null)
                    <img src="{{asset($paiement->icon)}}" class="mb-2 mh-120-px mr-2 mw-100 d-inline-block">
                    @else
                    <div class="mb-2 mh-120-px mr-2 mw-100 d-inline-block">{{$paiement->titre}}</div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
        <div class="mt-4 pb-3 pt-3 small">
            <div class="align-items-center row">
                <div class="col-md pb-2 pt-2">
                    <p class="mb-0 text-center">&copy; Copyright 2017</p>
                </div>
            </div>
        </div>
    </div>
</footer>