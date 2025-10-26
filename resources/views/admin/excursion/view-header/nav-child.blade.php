<div class="children-nav">
    <div class="nav-hover"></div>
    <ul class="_-nav">
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/excursions/'.$excursion->id.'?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="0" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.info.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/excursion-produit-descriptifs/'.$excursion->id.'?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.produit-descriptif.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/excursion-produit-info-pratiques/'.$excursion->id.'?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.produit-info-pratique.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/excursion-produit-condition-tarifaires/'.$excursion->id.'?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.produit-condition-tarifaire.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/itineraire-description-excursions/'.$excursion->id.'?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.itineraire-description-excursion.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/supplement-excursions?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.supplement_excursion.title')}} </p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/compagnie-liaison-excursions?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.compagnie-liaison-excursion.title')}} </p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a href="{{ url('admin/type-personnes-prod?excursion='.$excursion->id) }}" class="lien_child nav-link-manager-liens" data-range="2" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.personne.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/saisons?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.saison.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/tarif-excursions?excursion='.$excursion->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="excursion">
                <p class="nav-link-titre">{{trans('admin.nav.tarif-excursion.title')}}</p>
            </a>
        </li>
        <!--
        <li class="parent">
            <a @contextmenu.prevent="" href="{{url('admin/type-personnes?excursion='.$excursion->id)}}">
                <p>{{trans('admin.nav.personne.title')}}</p>
            </a>
        </li>
        <li class="parent">
            <a @contextmenu.prevent="" href="#">
                <p>{{trans('admin.nav.allotement.title')}} <i class="right fas fa-angle-right"></i></p>
            </a>
            <ul class="children">
                <li><a @contextmenu.prevent="" href="{{url('admin/allotements?excursion='.$excursion->id)}}">
                        <p>{{trans('admin.nav.allotement.childre.tous')}}</p>
                    </a></li>
                <li><a @contextmenu.prevent="" href="{{url('admin/compagnie-transports?excursion='.$excursion->id)}}">
                        <p>{{trans('admin.nav.allotement.childre.compagnie')}}</p>
                    </a></li>
            </ul>
        </li>
        <li class="parent">
            <a @contextmenu.prevent="" href="{{url('admin/tarifs?excursion='.$excursion->id)}}">
                <p>{{trans('admin.nav.tarif.title')}}</p>
            </a>
        </li>
        <li class="parent">
            <a @contextmenu.prevent="" href="#">
                <p>{{trans('admin.nav.supplement.title')}} <i class="right fas fa-angle-right"></i></p>
            </a>
            <ul class="children">
                <li><a @contextmenu.prevent="" href="{{url('admin/supplement-pensions?excursion='.$excursion->id)}}">
                        <p>{{trans('admin.nav.supplement.childre.pension')}}</p>
                    </a></li>
                <li><a @contextmenu.prevent="" href="{{url('admin/supplement-activites?excursion='.$excursion->id)}}">
                        <p>{{trans('admin.nav.supplement.childre.activite')}}</p>
                    </a></li>
                <li><a @contextmenu.prevent="" href="{{url('admin/supplement-vues?excursion='.$excursion->id)}}">
                        <p>{{trans('admin.nav.supplement.childre.vue')}}</p>
                    </a></li>
            </ul>
        </li>
-->
    </ul>
</div>