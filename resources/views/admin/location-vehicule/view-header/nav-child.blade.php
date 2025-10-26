<div class="children-nav">
    <div class="nav-hover"></div>
    <ul class="_-nav">
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/vehicule-locations/'.$vehiculeLocation->id.'?location='.$vehiculeLocation->id) }}" class="lien_child nav-link-manager-liens" data-range="0" data-parent="location">
                <p class="nav-link-titre">{{trans('admin.nav.info.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/vehicule-locations-produit-condition-tarifaires/'.$vehiculeLocation->id.'?location='.$vehiculeLocation->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="location">
                <p class="nav-link-titre">{{trans('admin.nav.produit-condition-tarifaire.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/saisons?location='.$vehiculeLocation->id) }}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="location">
                <p class="nav-link-titre">{{trans('admin.nav.location-voiture.childre.saisonnalite')}}</p>
            </a>
        </li>

        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/location-vehicule-tranche-saisons?location='.$vehiculeLocation->id) }}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="location">
                <p class="nav-link-titre">{{trans('admin.nav.location-voiture.childre.tranche-saisonnalite')}}</p>
            </a>
        </li>

        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/tarif-tranche-saison-locations/'.$vehiculeLocation->id.'?location='.$vehiculeLocation->id) }}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="location">
                <p class="nav-link-titre">{{ trans('admin.vehicule-location.actions.edition_tarif') }}</p>
            </a>
        </li>

        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/supplement-location-vehicules/'.$vehiculeLocation->id.'?location='.$vehiculeLocation->id) }}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="location">
                <p class="nav-link-titre">{{trans('admin.nav.location-voiture.childre.supplement_location')}}</p>
            </a>
        </li>

    </ul>
</div>