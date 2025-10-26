<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ile;
use App\Http\Controllers\Front\GestionCommandeUtilisateurController;
use App\Models\FraisDossier;
use App\Models\ModePayement;
use App\Models\Taxe;
use Carbon\Carbon;

class PanierController extends Controller
{

    public function index(Request $request)
    {
        $my_request = GestionRequestUtilisateurController::getUniqueKeyRequest($request, false);
        //
        $commande = GestionCommandeUtilisateurController::all($request);

        /*$type_commande = collect($commande)->keys()->toArray();
        if (array_search('hebergement', $type_commande) !== false) {
            $taxe_heb = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
            foreach ($commande as $key => $value) {
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe_heb) {
                    if ($taxe_heb != null && (($taxe_heb->taxe_appliquer == 0 && $taxe_heb->valeur_pourcent != null && doubleval($taxe_heb->valeur_pourcent) > 0)
                        || ($taxe_heb->taxe_appliquer == 1 && $taxe_heb->valeur_devises != null && doubleval($taxe_heb->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe_heb->taxe_appliquer == 1 ? doubleval($taxe_heb->valeur_devises) : $data->data->marge_calculer * doubleval($taxe_heb->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        } else {
            foreach ($commande as $key => $value) {
                $taxe  = null;
                switch ($key) {
                    case 'transfert':
                        $taxe = Taxe::where(['sigle' => 'tva_transfert'])->first();
                        break;
                    case 'billeterie':
                        $taxe = Taxe::where(['sigle' => 'tva_billetterie'])->first();
                        break;
                    case 'location':
                        $taxe = Taxe::where(['sigle' => 'tva_location'])->first();
                        break;
                    case 'excursion':
                        $taxe = Taxe::where(['sigle' => 'tva_excursion'])->first();
                        break;
                }
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                    if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                        || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        }*/
        $commande = PanierController::transform_panier($commande);
        //
        $frais_dossier = FraisDossier::where(['sigle' => 'frais_internet'])->first();
        //
        $tva = Taxe::all();

        return $this->viewCustom('front.panier', [
            'data' => $commande,
            'session_request' => json_encode(isset($my_request) ? $my_request : null),
            'TVA' => $tva,
            'fraisdossier' => $frais_dossier,
            'modePayement' => ModePayement::all()
        ]);
    }

    public static function transform_panier($commande)
    {
        foreach ($commande as $key => $value) {
            $commande[$key] = collect($commande[$key])->map(function ($data) {                
                $data->data = json_decode($data->data);
                $data->computed = json_decode($data->computed);
                return $data;
            })->toArray();
        }
        $commande = collect($commande)->filter(function ($data) {
            return count($data) > 0;
        });
        if (count($commande) > 1 || isset($commande['hebergement'])) {
            $taxe_heb = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
            foreach ($commande as $key => $value) {
                $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe_heb) {
                    if ($taxe_heb != null && (($taxe_heb->taxe_appliquer == 0 && $taxe_heb->valeur_pourcent != null && doubleval($taxe_heb->valeur_pourcent) > 0)
                        || ($taxe_heb->taxe_appliquer == 1 && $taxe_heb->valeur_devises != null && doubleval($taxe_heb->valeur_devises) > 0))) {
                        $data->taxe_calculer = $taxe_heb->taxe_appliquer == 1 ? doubleval($taxe_heb->valeur_devises) : $data->data->marge_calculer * doubleval($taxe_heb->valeur_pourcent) / 100;
                    } else {
                        $data->taxe_calculer = 0;
                    }
                    return $data;
                })->toArray();
            }
        } else {
            if (isset($commande['excursion'])) {
                $has_other_produit = false;
                collect($commande['excursion'])->map(function ($_exc) use (&$has_other_produit) {
                    foreach ($_exc->data->supplementCkecked as $key => $value) {
                        if (count($value)) {
                            $has_other_produit = true;
                        }
                    }
                    if ($_exc->data->item->lunch == 1 || $_exc->data->item->ticket) {
                        $has_other_produit = true;
                    }
                });
                if ($has_other_produit) {
                    $taxe = Taxe::where(['sigle' => 'tva_hebergement_pack'])->first();
                    foreach ($commande as $key => $value) {
                        $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                            if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                                || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                                $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                            } else {
                                $data->taxe_calculer = 0;
                            }
                            return $data;
                        })->toArray();
                    }
                } else {
                    $taxe = Taxe::where(['sigle' => 'tva_excursion'])->first();
                    foreach ($commande as $key => $value) {
                        $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                            if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                                || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                                $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                            } else {
                                $data->taxe_calculer = 0;
                            }
                            return $data;
                        })->toArray();
                    }
                }
            } else if (isset($commande['transfert'])) {
                $taxe = Taxe::where(['sigle' => 'tva_transfert'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            } else if (isset($commande['billeterie'])) {
                $taxe = Taxe::where(['sigle' => 'tva_billetterie'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            } else if (isset($commande['location'])) {
                $taxe = Taxe::where(['sigle' => 'tva_location'])->first();
                foreach ($commande as $key => $value) {
                    $commande[$key] = collect($commande[$key])->map(function ($data) use ($taxe) {
                        if ($taxe != null && (($taxe->taxe_appliquer == 0 && $taxe->valeur_pourcent != null && doubleval($taxe->valeur_pourcent) > 0)
                            || ($taxe->taxe_appliquer == 1 && $taxe->valeur_devises != null && doubleval($taxe->valeur_devises) > 0))) {
                            $data->taxe_calculer = $taxe->taxe_appliquer == 1 ? doubleval($taxe->valeur_devises) : $data->data->marge_calculer * doubleval($taxe->valeur_pourcent) / 100;
                        } else {
                            $data->taxe_calculer = 0;
                        }
                        return $data;
                    })->toArray();
                }
            }
        }
        return $commande;
    }
}
