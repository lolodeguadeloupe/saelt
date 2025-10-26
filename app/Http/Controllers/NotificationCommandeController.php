<?php

namespace App\Http\Controllers;

use App\Exports\AttemptTask;
use App\Exports\GeneratePDF;
use App\Models\AppConfig;
use App\Models\Commande;
use App\Models\FacturationCommande;
use App\Models\LigneCommandeSupplement;
use App\Models\Ville;
use App\Models\VoucherCommande;
use App\Notifications\AppNotification;
use App\Notifications\FactureNotification;
use App\Notifications\VoucherNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class NotificationCommandeController extends Controller
{
    private function getContrat(Request $request)
    {
        //Log::info($request->headers->get('Authorization'));
    }

    public function facturation(Request $request)
    {
        $data = json_decode(json_encode($request->all()));

        if (!isset($data->id)) {
            return false;
        }
        $commande = Commande::select(
            'commande.id',
            'commande.mode_payement_id',
            'commande.paiement_id',
            'commande.prix',
            'commande.tva',
            'commande.frais_dossier',
            'commande.date',
            'commande.status',
            'commande.prix_total',
            'facturation_commande.nom',
            'facturation_commande.prenom',
            'facturation_commande.adresse',
            'facturation_commande.ville',
            'facturation_commande.code_postal',
            'facturation_commande.telephone',
            'facturation_commande.email'
        )
            ->join('facturation_commande', 'facturation_commande.commande_id', 'commande.id')
            ->with([
                'facture',
                'mode_payement',
                'hebergement' => function ($query) {
                    $query->with(['personne', 'supplement', 'vol', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'excursion' => function ($query) {
                    $query->with([
                        'personne',
                        'supplement' => function ($query) {
                            $query->with(['personne']);
                        },
                        'ile',
                        'prestataire' => function ($query) {
                            $query->with(['ville']);
                        },
                        'billet_compagnie',
                        'lunch_prestataire'
                    ]);
                },
                'location' => function ($query) {
                    $query->with(['personne', 'supplement', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'billeterie' => function ($query) {
                    $query->with(['personne', 'supplement', 'compagnie' => function ($query) {
                        $query->with(['ville']);
                    }]);
                },
                'transfert' => function ($query) {
                    $query->with(['personne', 'supplement', 'prestataire' => function ($query) {
                        $query->with(['ville']);
                    }]);
                }
            ])
            ->find($data->id)->toArray();
        $commande['app'] = AppConfig::with(['ville'])->get()->first()->toArray();
        $facture = FacturationCommande::where(['commande_id' => $commande['id']])
            ->get()
            ->first();
        $facture_doc = GeneratePDF::generatePDFFacture(['data' => $commande]);

        $vouchers = $this->generateVoucher($commande);
        if ($facture->notifications()->count() == 0) {
            $facture->notify(new FactureNotification(['id' => $commande['id'], 'facture' => $facture_doc, 'voucher' => $vouchers, 'client' => $commande['facture']['prenom'] . ' ' . $commande['facture']['nom']], route('remerciement') . '?key_=' . $request->key_));
        }
        AttemptTask::post(url("notification-prestataire"), [
            'voucher' => $vouchers,
            'commande' => $commande
        ], 'test_test', $request); 

        AttemptTask::post(
            url("notification-application"),
            [
                'commande' => $commande
            ],
            'test_test',
            $request
        );

        return true;
    }

    private function generateVoucher($data)
    {
        $vouchers = [];
        $cmd_history = [
            'date' => $data['date'],
            'adresse' => $data['adresse'],
            'ville' => $data['ville'],
            'code_postal' => $data['code_postal'],
            'email' => $data['email'],
            'telephone' => $data['telephone'],
            'prenom' => $data['prenom'],
            'nom' => $data['nom'],
            'status' => $data['status']
        ];

        for ($i = 0; $i < count($data['hebergement']); $i++) {
            $voucher = json_decode(json_encode([
                'email' => $data['hebergement'][$i]['prestataire']['email'],
                'name' => $data['hebergement'][$i]['prestataire']['name'],
                'model' => LigneCommandeChambre::class,
                'titre' => trans('produit-alias.type-chambre'),
                'model_id' => $data['hebergement'][$i]['id'],
                'commande_id' => $data['id'],
                'id' => $data['id'] . '-' . (count($vouchers) + 1)
            ]));
            $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-heb', ['commande' => $cmd_history, 'data' => $data['hebergement'][$i], 'voucher' => $voucher], 'voucher-hebergement', $voucher);
            $vouchers[] = $voucher;
            /** */
            if (isset($data['hebergement'][$i]['vol']) && isset($data['hebergement'][$i]['vol'][0])) {

                $voucher = json_decode(json_encode([
                    'email' => $data['hebergement'][$i]['vol'][0]['compagnie_email'],
                    'name' => $data['hebergement'][$i]['vol'][0]['compagnie_nom'],
                    'model' => LigneVolHebergement::class,
                    'titre' =>  trans('produit-alias.allotement'),
                    'model_id' => $data['hebergement'][$i]['vol'][0]['id'],
                    'commande_id' => $data['id'],
                    'id' => $data['id'] . '-' . (count($vouchers) + 1)
                ]));
                $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-billet-hebergement', ['commande' => $cmd_history, 'data' => $data['hebergement'][$i], 'voucher' => $voucher], 'voucher-hebergement-vol', $voucher);
                $vouchers[] = $voucher;
            }


            if (isset($data['hebergement'][$i]['supplement'])) {
                for ($sup = 0; $sup < count($data['hebergement'][$i]['supplement']); $sup++) {
                    $email = isset($data['hebergement'][$i]['supplement'][$sup]['prestataire_email']) ? $data['hebergement'][$i]['supplement'][$sup]['prestataire_email'] : $data['hebergement'][$i]['supplement'][$sup]['prestataire_second_email'];
                    $voucher = json_decode(json_encode([
                        'email' => $email,
                        'name' => $data['hebergement'][$i]['supplement'][$sup]['prestataire_name'],
                        'model' => LigneCommandeSupplement::class,
                        'titre' => $data['hebergement'][$i]['supplement'][$sup]['titre'] ." - ". trans('produit-alias.hebergement'),
                        'model_id' => $data['hebergement'][$i]['supplement'][$sup]['id'],
                        'commande_id' => $data['id'],
                        'id' => $data['id'] . '-' . (count($vouchers) + 1)
                    ]));
                    $event_supp = [
                        'debut' => $data['hebergement'][$i]['date_debut'],
                        'fin' => $data['hebergement'][$i]['date_fin'],
                        'lieu' => Ville::find($data['hebergement'][$i]['ville_id'])
                    ];
                    $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-supplement', [
                        'commande' => $cmd_history,
                        'data' => $data['hebergement'][$i],
                        'voucher' => $voucher,
                        'supplement' => $data['hebergement'][$i]['supplement'][$sup],
                        'event' => $event_supp
                    ], 'voucher-supplement-hebergement', $voucher);
                    $vouchers[] = $voucher;
                }
            }
        }

        for ($i = 0; $i < count($data['location']); $i++) {
            $voucher = json_decode(json_encode([
                'email' => $data['location'][$i]['prestataire']['email'],
                'name' =>  $data['location'][$i]['prestataire']['name'],
                'model' => LigneCommandeLocation::class,
                'titre' =>  trans('produit-alias.vehicule-location'),
                'model_id' => $data['location'][$i]['id'],
                'commande_id' => $data['id'],
                'id' => $data['id'] . '-' . (count($vouchers) + 1)
            ]));
            $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-loc', ['commande' => $cmd_history, 'data' => $data['location'][$i], 'voucher' => $voucher], 'voucher-location', $voucher);
            $vouchers[] = $voucher;
        }

        for ($i = 0; $i < count($data['billeterie']); $i++) {
            $voucher = json_decode(json_encode([
                'email' => $data['billeterie'][$i]['compagnie']['email'],
                'name' =>  $data['billeterie'][$i]['compagnie']['nom'],
                'model' => LigneCommandeBilletterie::class,
                'titre' => trans('produit-alias.billeterie-maritime'),
                'model_id' => $data['billeterie'][$i]['id'],
                'commande_id' => $data['id'],
                'id' => $data['id'] . '-' . (count($vouchers) + 1)
            ]));
            $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-billet', ['commande' => $cmd_history, 'data' => $data['billeterie'][$i], 'voucher' => $voucher], 'voucher-billeterie', $voucher);
            $vouchers[] = $voucher;
        }

        for ($i = 0; $i < count($data['transfert']); $i++) {
            $voucher = json_decode(json_encode([
                'email' => $data['transfert'][$i]['prestataire']['email'],
                'name' =>  $data['transfert'][$i]['prestataire']['name'],
                'model' => LigneCommandeTransfert::class,
                'titre' => trans('produit-alias.transfert-voyage'),
                'model_id' => $data['transfert'][$i]['id'],
                'commande_id' => $data['id'],
                'id' => $data['id'] . '-' . (count($vouchers) + 1)
            ]));
            $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-transfert', ['commande' => $cmd_history, 'data' => $data['transfert'][$i], 'voucher' => $voucher], 'voucher-transfert', $voucher);
            $vouchers[] = $voucher;
        }

        for ($i = 0; $i < count($data['excursion']); $i++) {
            $voucher = json_decode(json_encode([
                'email' => $data['excursion'][$i]['prestataire']['email'],
                'name' =>  $data['excursion'][$i]['prestataire']['name'],
                'model' => LigneCommandeExcursion::class,
                'titre' => trans('produit-alias.excursion'),
                'model_id' => $data['excursion'][$i]['id'],
                'commande_id' => $data['id'],
                'id' => $data['id'] . '-' . (count($vouchers) + 1)
            ]));
            $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-excursion', ['commande' => $cmd_history, 'data' => $data['excursion'][$i], 'voucher' => $voucher], 'voucher-excursion', $voucher);
            $vouchers[] = $voucher;
            /** lunch */
            foreach ($data['excursion'][$i]['lunch_prestataire'] as $key => $value) {
                $_prest_excursion = $data['excursion'][$i];
                $_prest_excursion['prestataire'] = $value;
                $voucher = json_decode(json_encode([
                    'email' => $_prest_excursion['prestataire']['prestataire_email'],
                    'name' =>  $_prest_excursion['prestataire']['prestataire_name'],
                    'model' => LigneCommandeLunchPrestataire::class,
                    'titre' => trans('produit-alias.options_included.lunch') ." - ". trans('produit-alias.excursion'),
                    'model_id' => $_prest_excursion['prestataire']['id'],
                    'commande_id' => $data['id'],
                    'id' => $data['id'] . '-' . (count($vouchers) + 1)
                ]));
                $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-excursion-lunch', ['commande' => $cmd_history, 'data' => $_prest_excursion, 'voucher' => $voucher], 'voucher-excursion-formule', $voucher);
                $vouchers[] = $voucher;
            }
            /** billet */
            foreach ($data['excursion'][$i]['billet_compagnie'] as $key => $value) {
                $_compagnie_excursion = $data['excursion'][$i];
                $_compagnie_excursion['compagnie'] = $value;
                $voucher = json_decode(json_encode([
                    'email' => $_compagnie_excursion['compagnie']['compagnie_email'],
                    'name' =>  $_compagnie_excursion['compagnie']['compagnie_nom'],
                    'model' => LigneCommandeBilletCompagnie::class,
                    'titre' => trans('produit-alias.options_included.ticket') ." - ". trans('produit-alias.excursion'),
                    'model_id' => $_compagnie_excursion['compagnie']['id'],
                    'commande_id' => $data['id'],
                    'id' => $data['id'] . '-' . (count($vouchers) + 1)
                ]));
                $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-excursion-billet', ['commande' => $cmd_history, 'data' => $_compagnie_excursion, 'voucher' => $voucher], 'voucher-excursion-billet', $voucher);
                $vouchers[] = $voucher;
            }
            /** */
            if (isset($data['excursion'][$i]['supplement'])) {
                for ($sup = 0; $sup < count($data['excursion'][$i]['supplement']); $sup++) {
                    $email = isset($data['excursion'][$i]['supplement'][$sup]['prestataire_email']) ? $data['excursion'][$i]['supplement'][$sup]['prestataire_email'] : $data['excursion'][$i]['supplement'][$sup]['prestataire_second_email'];
                    $voucher = json_decode(json_encode([
                        'email' => $email,
                        'name' => $data['excursion'][$i]['supplement'][$sup]['prestataire_name'],
                        'model' => LigneCommandeSupplement::class,
                        'titre' => $data['excursion'][$i]['supplement'][$sup]['titre']." - ". trans('produit-alias.excursion') ,
                        'model_id' => $data['excursion'][$i]['supplement'][$sup]['id'],
                        'commande_id' => $data['id'],
                        'id' => $data['id'] . '-' . (count($vouchers) + 1)
                    ]));
                    $event_supp = [
                        'debut' => $data['excursion'][$i]['date_excursion'],
                        'fin' => $data['excursion'][$i]['date_excursion'],
                        'lieu' => Ville::find($data['hebergement'][$i]['ville_id'])
                    ];
                    $voucher->file_pdf = GeneratePDF::generateVoucher('front.pdf-voucher-supplement', [
                        'commande' => $cmd_history,
                        'data' => $data['excursion'][$i],
                        'voucher' => $voucher,
                        'supplement' => $data['excursion'][$i]['supplement'][$sup],
                        'event' => $event_supp
                    ], 'voucher-supplement-excursrion', $voucher);
                    $vouchers[] = $voucher;
                }
            }
        }
        return $vouchers;
    }

    public function voucher(Request $request)
    {
        /** prestataire */
        $data = json_decode(json_encode($request->all()), true);
        $commande = $data['commande'];
        $vouchers = $this->generateVoucher($commande);

        $vouchers = collect($vouchers)->groupBy('email')->values();
        collect($vouchers)->map(function ($data) {
            $arr_not = [];
            $voucher = null;
            collect($data)->map(function ($item_not) use (&$arr_not, &$voucher) {
                $arr_not[] = $item_not;
                $voucher = VoucherCommande::where(['commande_id' => $item_not->commande_id, 'model' => $item_not->model, 'model_id' => $item_not->model_id])->first();
                if ($voucher == null) {
                    $voucher = VoucherCommande::create([
                        'email' => $item_not->email,
                        'name' => $item_not->name,
                        'model' => $item_not->model,
                        'model_id' => $item_not->model_id,
                        'commande_id' => $item_not->commande_id
                    ]);
                }
            });
            if ($voucher && $voucher->notifications()->count() == 0) {
                $voucher->notify(new VoucherNotification($arr_not, $voucher->name));
            }
        });
        return true;
    }

    public function application(Request $request)
    {
        /** saelt */
        $data = json_decode(json_encode($request->all()));
        $commande = $data->commande;
        $app = AppConfig::first();
        if ($app->email) {
            $voucher = VoucherCommande::where(['commande_id' => $commande->id, 'model' => get_class($app), 'model_id' => $app->id])->first();
            if ($voucher == null) {
                $voucher = VoucherCommande::create([
                    'email' => $app->email,
                    'name' => $app->nom,
                    'model' => get_class($app),
                    'model_id' => $app->id,
                    'commande_id' => $commande->id
                ]);
            }
            if ($voucher->notifications()->count() == 0) {
                $app->notify(new AppNotification($commande->id));
            }
        }
    }
}
