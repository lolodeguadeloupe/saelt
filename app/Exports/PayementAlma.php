<?php

namespace App\Exports;

use App\Models\ModePayement;
use GuzzleHttp\Client;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Psr\Http\Message\ResponseInterface;

class PayementAlma implements FromCollection
{
    protected $request;
    protected $paylaod;
    protected $gateway;

    function __construct(Request $request, AlmaModele $alma)
    {
        /*$handler = new CurlHandler();
        $stack = HandlerStack::create($handler); // Wrap w/ middleware*/
        /** */
        $this->request = $request;
        $this->paylaod = $alma;
        $default_config = [
            'base_url' => config('alma.base_url'),
            'version' => config('alma.version'),
            'api_key' => config('alma.api_key') 
        ];
        $config = ModePayement::where(['titre' => config('mode-paiement.alma.titre')])->first();
        if ($config) {
            $default_config['base_url'] = $config->config->mode == 1 ? $config->config->base_url_prod : $config->config->base_url_test;
            $default_config['version'] = $config->config->api_version;
            $default_config['api_key'] = $config->config->mode == 1 ? $config->config->key_prod : $config->config->key_test;
        }
        $this->gateway = new Client([
            'base_uri' => $default_config['base_url'] . '/' . $default_config['version'] . '/',
            'headers' => [
                'Authorization' => config('alma.auth') . ' ' . $default_config['api_key'],
                'Content-type' => 'application/json'
            ],
            'verify' => base_path('cacert.pem'),
            /*'handler' => $stack*/
            'http_errors' => false
        ]);
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        //
    }

    public function payer()
    {
        $uri = config('alma.uri.payment.create');
        $response = $this->gateway->post($uri, [
            'body' => $this->paylaod->getPayload()
        ]);

        return $this->checkReponse($response);
    }

    public function checkStatus($id)
    {
        $uri = config('alma.uri.payment.create') . '/' . $id;
        $response = $this->gateway->post($uri, []); 
        return $this->checkReponse($response);
    }

    public function liste($pagination = 50, $last_id = '')
    {
        $uri = config('alma.uri.payment.create') . '?limit=' . $pagination . ($last_id = '' ? '' : '&starting_after=' . $last_id);
        $response = $this->gateway->get($uri);
        return $this->checkReponse($response);
    }

    private function checkReponse(ResponseInterface $reponse)
    {
        $contents = json_decode($reponse->getBody()->getContents());

        switch ($reponse->getStatusCode()) {
            case 200:
                return [
                    'data' => (array)$contents,
                    'satus_code' => 200,
                ];
            case 400:
                if ($contents->error_code == "validation_error") {
                    $_this = $this;

                    $errors = [];
                    collect($contents->errors)->map(function ($error) use ($_this, &$errors) {
                        $errors[$error->field] = isset($error->message) ? $error->message : $_this->checkErrorCode($error->error_code);
                    });
                    return [
                        'data' => $errors,
                        'satus_code' => 400,
                    ];
                }
                return [
                    'data' => json_decode($reponse->getBody()->getContents()),
                    'satus_code' => 400,
                ];
            case 401:
                return [
                    'data' => [
                        'auth' => 'Invalide d\'authétification'
                    ],
                    'satus_code' => 401,
                ];
                return;
            case 500 || 502:
                return [
                    'data' => [
                        'serveur' => 'Erreur du serveur'
                    ],
                    'satus_code' => $reponse->getStatusCode(),
                ];
            case 402:
                return [
                    'data' => [
                        'transaction' => 'Problème de paiement'
                    ],
                    'satus_code' => 402,
                ];
            case 404:
                return [
                    'data' => [
                        'serveur' => 'Serveur introuvable'
                    ],
                    'satus_code' => 404,
                ];
            default:
                return [
                    'data' => [
                        'client' => 'Problème de connexion'
                    ],
                    'satus_code' => $reponse->getStatusCode(),
                ];
        }
    }

    private function checkErrorCode($code)
    {
        switch ($code) {
            case 'invalid_value':
                return 'Invalide value';
            case 'invalid_type':
                return 'Invalide type';
            case 'missing_field':
                return 'Champ manquant';
        }
    }

    //<payment_id>
}
