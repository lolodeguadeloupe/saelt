<div class="children-nav">
    <div class="nav-hover"></div>
    <ul class="_-nav">
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{ url('admin/type-transfert-voyages/'.$typeTransfertVoyage->id.'?transfert='.$typeTransfertVoyage->id) }}" class="lien_child nav-link-manager-liens" data-range="0" data-parent="transfert">
                <p class="nav-link-titre">{{trans('admin.nav.info.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/type-transfert-voyages-produit-condition-tarifaires/'.$typeTransfertVoyage->id.'?transfert='.$typeTransfertVoyage->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="transfert">
                <p class="nav-link-titre">{{trans('admin.nav.produit-condition-tarifaire.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/tranche-personne-transfert-voyages?transfert='.$typeTransfertVoyage->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="transfert">
                <p class="nav-link-titre"> {{trans('admin.nav.transfert-voyage.childre.tranche')}} </p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a href="{{ url('admin/type-personnes-prod?transfert='.$typeTransfertVoyage->id) }}" class="lien_child nav-link-manager-liens" data-range="2" data-range="1" data-parent="transfert">
                <p class="nav-link-titre">{{trans('admin.nav.personne.title')}}</p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/vehicule-transfert-voyages?transfert='.$typeTransfertVoyage->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="transfert">
                <p class="nav-link-titre"> {{ trans('admin.type-transfert-voyage.columns.vehicule') }} </p>
            </a>
        </li>
        <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/tarif-transfert-voyages?transfert='.$typeTransfertVoyage->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="transfert">
                <p class="nav-link-titre"> {{trans('admin.nav.transfert-voyage.childre.tarif')}} </p>
            </a>
        </li>
       <!-- <li class="parent manager-liens">
            <a @contextmenu.prevent="" href="{{url('admin/tarif-transfert-voyages?transfert='.$typeTransfertVoyage->id)}}" class="lien_child nav-link-manager-liens" data-range="1" data-parent="transfert">
                <p class="nav-link-titre"> {{trans('admin.nav.transfert-voyage.childre.tarif')}} </p>
            </a>
        </li>-->
    </ul>
</div>