<div class="children-nav">
    <div class="nav-hover"></div>
    <ul class="_-nav">
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/hebergements/'.$hebergement->id.'?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="0" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.info.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/hebergement-produit-descriptifs/'.$hebergement->id.'?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.produit-descriptif.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/hebergement-produit-info-pratiques/'.$hebergement->id.'?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.produit-info-pratique.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/hebergement-produit-condition-tarifaires/'.$hebergement->id.'?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.produit-condition-tarifaire.title')}}</p>
            </a>
        </li>
        <li class="parent">
            <a @contextmenu.prevent="" href="#">
                <p>{{trans('admin.nav.type-chambre.title')}} <i class="right fas fa-angle-right"></i></p>
            </a>
            <ul class="children">
                <li class="manager-liens"><a @contextmenu.prevent="" href="{{url('admin/type-chambres?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                        <p class="nav-link-titre">{{trans('admin.nav.type-chambre.childre.tous')}}</p>
                    </a></li>
                <li class="manager-liens"><a @contextmenu.prevent="" href="{{url('admin/base-types?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                        <p class="nav-link-titre">{{trans('admin.nav.type-chambre.childre.base_type')}}</p>
                    </a></li>
            </ul>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/saisons?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.saison.title')}} </p>
            </a>
        </li>
        <!--
        <li class="parent">
            <a @contextmenu.prevent="" href="{{url('admin/type-personnes?heb='.$hebergement->id)}}">
                <p>{{trans('admin.nav.personne.title')}}</p>
            </a>
        </li>
-->
        <!--
        <li class="parent">
            <a @contextmenu.prevent="" href="#">
                <p>{{trans('admin.nav.allotement.title')}} <i class="right fas fa-angle-right"></i></p>
            </a>
            <ul class="children">
                <li><a @contextmenu.prevent="" href="{{url('admin/allotements?heb='.$hebergement->id)}}">
                        <p>{{trans('admin.nav.allotement.childre.tous')}}</p>
                    </a></li>
            </ul>
        </li>
-->

        <li class="parent manager-liens">
            <a href="{{ url('admin/type-personnes-prod?heb='.$hebergement->id) }}" class="lien_child nav-link-manager-liens" data-range="2" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.personne.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/tarifs?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                <p class="nav-link-titre">{{trans('admin.nav.tarif.title')}}</p>
            </a>
        </li>
        <li class="parent">
            <a @contextmenu.prevent="" href="#">
                <p class="nav-link-titre">{{trans('admin.nav.supplement.title')}} <i class="right fas fa-angle-right"></i></p>
            </a>
            <ul class="children">
                <li class="manager-liens"><a @contextmenu.prevent="" href="{{url('admin/supplement-pensions?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                        <p class="nav-link-titre">{{trans('admin.nav.supplement.childre.pension')}}</p>
                    </a></li>
                <li class="manager-liens"><a @contextmenu.prevent="" href="{{url('admin/supplement-activites?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                        <p class="nav-link-titre">{{trans('admin.nav.supplement.childre.activite')}}</p>
                    </a></li>
                <li class="manager-liens"><a @contextmenu.prevent="" href="{{url('admin/supplement-vues?heb='.$hebergement->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="hebergement">
                        <p class="nav-link-titre">{{trans('admin.nav.supplement.childre.vue')}}</p>
                    </a></li>
            </ul>
        </li>

    </ul>
</div>