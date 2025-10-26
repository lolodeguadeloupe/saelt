<aside class="main-sidebar sidebar-dark-primary elevation-4 h-100 d-flex flex-column">
    <!-- Brand Logo -->
    <a href="#" class="brand-link elevation-3">
        <img src="{{logo()}}" alt="Logo" class="brand-image img-circle">
        <!--<span class="brand-text font-weight-light" style="margin-left: 10px;">{{ env('APP_NAME') }}</span> -->
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

        <!-- Sidebar Menu -->
        <nav class="mt-2 mb-4">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item item-title">
                    {{ trans('admin-base.sidebar.content') }}
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/pays') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location">
                        <i class="nav-icon fas fa-pays"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.pay.title') }}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/villes') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location">
                        <i class="nav-icon fas fa-villes"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.ville.title') }}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/iles') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location">
                        <i class="nav-icon fas fa-island"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.ile.title') }}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/taxes') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.taxe.title') }}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/prestataires') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location">
                        <i class="nav-icon fas fa-user-shield"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.prestataire.title') }}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/type-personnes') }}" class="nav-link nav-link-manager-liens lien_complement" data-parent="hebergement-excursion-transfert-location-billeterie">
                        <i class="nav-icon fas fa-users"></i>
                        <p class="nav-link-titre">{{trans('admin.nav.personne.title')}}</p>
                    </a>
                </li>
                <li class="nav-item {{app('request')->has('heb')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{app('request')->has('heb')?'active':''}}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            {{trans('admin.nav.hebergement.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/hebergements') }}" class="nav-link nav-link-manager-liens lien_parent {{app('request')->has('heb')?'active':''}}" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.hebergement.childre.tous')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/hebergement-marque-blanches') }}" class="nav-link nav-link-manager-liens lien_child" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.hebergement.childre.marque_blanche')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/type-hebergements') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.hebergement.childre.type')}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{app('request')->has('excursion')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{app('request')->has('excursion')?'active':''}}">
                        <i class="nav-icon fas fa-map-marked-alt"></i>
                        <p>
                            {{trans('admin.nav.excursion.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/excursions') }}" class="nav-link nav-link-manager-liens lien_parent {{app('request')->has('excursion')?'active':''}}" data-parent="excursion">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.excursion.childre.tous')}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            {{trans('admin.nav.allotement.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/allotements') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.allotement.childre.tous')}}
                                </p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item manager-liens">
                            <a href="#" onclick="location.replace('{{ url('admin/aerien-compagnie-transports?transport=Aérien') }}')" class="nav-link lien_complement" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.allotement.childre.compagnie')}}
                                </p>
                            </a>
                        </li>
-->
                    </ul>
                </li>
                <li class="nav-item {{app('request')->has('billeterie')?'menu-open':''}}">
                    <a href="#" class="nav-link {{app('request')->has('billeterie')?'active':''}}">
                        <i class="nav-icon fas fa-ticket-alt"></i>
                        <p>
                            {{trans('admin.nav.billeterie-maritime.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/billeterie-maritimes') }}" class="nav-link nav-link-manager-liens lien_parent {{app('request')->has('billeterie')?'active':''}}" data-parent="billeterie">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.billeterie-maritime.childre.tous')}}
                                </p>
                            </a>
                        </li>
                        <!--
                        <li class="nav-item">
                            <a href="#" onclick="location.replace('{{ url('admin/maritime-compagnie-transports?transport=Maritime') }}')" class="nav-link lien_complement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p>
                                    {{trans('admin.nav.billeterie-maritime.childre.compagnie')}}
                                </p>
                            </a>
                        </li>
-->
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-building"></i>
                        <p>
                            {{trans('admin.nav.compagnie-transport.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/all-compagnie-transports') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.compagnie-transport.childre.tous')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/maritime-compagnie-transports?transport=Maritime') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="excursion">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.compagnie-transport.childre.maritime')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/aerien-compagnie-transports?transport=Aérien') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.compagnie-transport.childre.aerien')}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item {{app('request')->has('location') || app('request')->has('vehicule') || app('request')->has('vehicule-saison') || app('request')->has('agence-location') || app('request')->has('vehicule-transfert-categorie') ?'menu-open':''}}">
                    <a href="#" class="nav-link {{app('request')->has('location') || app('request')->has('vehicule') || app('request')->has('vehicule-saison') || app('request')->has('agence-location') || app('request')->has('vehicule-transfert-categorie') ?'active':''}}">
                        <i class="nav-icon fas fa-car"></i>
                        <p>
                            {{trans('admin.nav.location-voiture.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                        <!--<span class="badge ml-2 badge-success">9</span>-->
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/agence-locations') }}" class="nav-link nav-link-manager-liens lien_child {{app('request')->has('agence-location')?'active':''}}" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.agence-location')}}
                                </p>
                                <!--<span class="badge ml-2 badge-success">9</span>-->
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/restriction-trajet-vehicules') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.restriction-trajet-vehicule')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/marque-vehicules') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.marque-vehicule')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/modele-vehicules') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.modele-vehicule')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/famille-vehicules') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.famille-vehicule')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/categorie-vehicules') }}" class="nav-link nav-link-manager-liens lien_child {{app('request')->has('vehicule-transfert-categorie')?'active':''}}" data-range="2" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.categorie-vehicule')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/vehicule-locations') }}" class="nav-link nav-link-manager-liens lien_parent {{app('request')->has('vehicule') || app('request')->has('location')?'active':''}}" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.location-voiture.childre.vehicule-location')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/planing-vehicules') }}" class="nav-link nav-link-manager-liens lien_parent" data-parent="location">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.planing-vehicule.title')}}
                                </p>
                            </a>
                        </li>

                        <!--<li class="nav-item manager-liens">
                            <a href="{{ url('admin/planing-vehicules') }}" class="nav-link nav-link-manager-liens lien_parent" data-parent="planing_vehicule">
                                <i class="nav-icon fas fa-calendar-check"></i>
                                <p class="nav-link-titre">{{trans('admin.nav.planing-vehicule.title')}}</p>
                            </a>
                        </li>-->

                    </ul>
                </li>

                <li class="nav-item {{app('request')->has('transfert-voyage') || app('request')->has('vehicule-transfert') || app('request')->has('transfert') ?'menu-open':''}}">
                    <a href="#" class="nav-link {{app('request')->has('transfert-voyage') || app('request')->has('vehicule-transfert') || app('request')->has('transfert') ?'active':''}}">
                        <i class="nav-icon fas fa-bus"></i>
                        <p>
                            {{trans('admin.nav.transfert-voyage.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/lieu-transferts') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="transfert">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.transfert-voyage.childre.lieu-transfert')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/trajet-transfert-voyages') }}" class="nav-link nav-link-manager-liens lien_child" data-range="2" data-parent="transfert">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.transfert-voyage.childre.trajet')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/type-transfert-voyages') }}" class="nav-link nav-link-manager-liens lien_parent {{app('request')->has('transfert-voyage') || app('request')->has('vehicule-transfert') || app('request')->has('transfert') ?'active':''}}" data-parent="transfert">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.transfert-voyage.childre.type')}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item {{app('request')->has('aeroport') || app('request')->has('port')?'menu-open':''}}">
                    <a href="#" class="nav-link {{app('request')->has('aeroport') || app('request')->has('port')?'active':''}}">
                        <i class="nav-icon fas fa-plane"></i>
                        <p>
                            {{trans('admin.nav.service-transport.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/service-aeroports') }}" class="nav-link nav-link-manager-liens lien_complement {{app('request')->has('aeroport')?'active':''}}" data-range="2" data-parent="hebergement">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.service-transport.childre.service-aeroport')}}
                                </p>
                            </a>
                        </li>
                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/service-ports') }}" class="nav-link nav-link-manager-liens lien_complement {{app('request')->has('port')?'active':''}}" data-range="2" data-parent="excursion">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.service-transport.childre.service-port')}}
                                </p>
                            </a>
                        </li>

                    </ul>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/mode-payements') }}" class="nav-link nav-link-manager-liens lien_complement" data-parent="hebergement-excursion-transfert-location-commande">
                        <i class="nav-icon fas fa-credit-card"></i>
                        <p class="nav-link-titre">{{trans('admin.nav.mode-payement.title')}}</p>
                    </a>
                </li>
                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/commandes') }}" class="nav-link nav-link-manager-liens lien_parent  {{app('request')->has('commande')?'active':''}}" data-parent="commande">
                        <i class="nav-icon fas fa-cart-plus"></i>
                        <p class="nav-link-titre">{{trans('admin.nav.commande.title')}}</p>
                    </a>
                </li>

                <li class="nav-item manager-liens">
                    <a href="{{ url('admin/coup-coeur-produits') }}" class="nav-link nav-link-manager-liens lien_parent" data-parent="coup_coeur">
                        <i class="nav-icon fas fa-disease"></i>
                        <p class="nav-link-titre">{{trans('admin.nav.coup-coeur-produit.title')}}</p>
                    </a>
                </li>
                <!--<li class="nav-item manager-liens">
                    <a href="{{ url('admin/frais-dossiers') }}" class="nav-link nav-link-manager-liens lien_complement" data-range="2" data-parent="hebergement-excursion-transfert-location-commande">
                        <i class="nav-icon fas fa-list-alt"></i>
                        <p class="nav-link-titre">{{ trans('admin.nav.frais-dossier.title') }}</p>
                    </a>
                </li>-->
                <li class="nav-item {{app('request')->has('setting')?'menu-open':''}} ">
                    <a href="#" class="nav-link {{app('request')->has('setting')?'active':''}}">
                        <i class="nav-icon fas fa-setting"></i>
                        <p>
                            {{trans('admin.nav.parametre.title')}}
                            <i class="right fas fa-angle-right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/app-configs') }}" class="nav-link nav-link-manager-liens lien_complement {{app('request')->has('setting')?'active':''}}" data-parent="hebergement-excursion-transfert-location-commande">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.parametre.childre.generale')}}
                                </p>
                            </a>
                        </li>

                        <li class="nav-item manager-liens">
                            <a href="{{ url('admin/app-supplements') }}" class="nav-link nav-link-manager-liens lien_complement {{app('request')->has('setting')?'active':''}}" data-parent="hebergement-excursion-transfert-location-commande">
                                <i class="nav-icon fas fa-circle"></i>
                                <p class="nav-link-titre">
                                    {{trans('admin.nav.parametre.childre.supplementaire')}}
                                </p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!--<button class="sidebar-minimizer brand-minimizer" type="button"></button>-->
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>

<!--
    aeroport
allotement
billeterie
commande
companies
excursion
frais de dossier4
hebergement
iles
location
mode payement
port
prestataire
taxes
transfert
types de personne

-->