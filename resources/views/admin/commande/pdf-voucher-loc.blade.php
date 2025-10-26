<!DOCTYPE html>
<html>

<head>
    <title>Information conducteur</title>
    <style>
        @page {
            margin: 60px 50px 60px 50px;
            padding: 50px;
        }

        * {
            font-size: 12px;
            font-weight: 400;
            line-height: 20px;
            box-sizing: border-box;
        }

        p {
            margin: 0;
        }

        body {
            width: 700px;
        }

        .logo {
            width: 130px;
            height: 80px;
        }

        .table {
            display: table;
        }

        .t-row {
            display: table-row;
        }

        .t-cell {
            display: table-cell;
        }

        .d-inline {
            display: inline-block !important;
        }

        .d-block {
            display: block !important;
        }

        .v-middle {
            vertical-align: middle;
        }

        .v-top {
            vertical-align: top;
        }

        .p-relative {
            position: relative !important;
        }

        .t-center {
            text-align: center;
        }

        .t-left {
            text-align: left;
        }

        .t-right {
            text-align: right;
        }

        .t-nowrap {
            white-space: nowrap;
        }

        .bloc-info {
            width: 700px;
        }

        .header {
            width: 700px;
        }

        p.title {
            font-weight: 900;
            margin-bottom: 0px;
        }

        p.value {
            margin-top: 5px;
            padding-left: 5px;
        }

        span.title {
            font-weight: 900;
            margin-right: 10px;
        }

        span.value {
            padding-left: 5px;
        }

        .info-generale {
            width: 425px;
            /*350px;*/
        }

        .titre-voucher {
            width: 270px;
            /*340px; */
            border: 1px solid black;
        }

        .titre-style {
            margin: auto;
            width: 80%;
            border-style: solid;
            border-color: black;
            border-width: 1px 1px 1px 1px;
            border-top-color: transparent;
            border-bottom-color: transparent;
        }

        .titre-style>.p-1 {
            margin-bottom: 30px;
        }

        .separateur-bg {
            width: 700px;
            height: 1px;
            background-color: black;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .separateur {
            width: 700px;
            height: 1px;
            margin-top: 15px;
            margin-bottom: 15px;
        }

        .body-prestataire {
            width: 700px;
            border: 1px solid black;
        }

        .info-prest {
            width: 80px;
            padding: 5px;

        }

        .info-prest-content {
            width: 450px;
            border: 1px solid black;
            border-top-color: transparent;
            border-bottom-color: transparent;
            padding: 5px;
        }

        .info-prest-history {
            width: 130px;
            /**200 */
            padding: 5px;
        }

        .info-prest-history-row {
            width: 120px;
            padding: 0;
            margin: 0
        }

        .row-2 {
            width: 44%;
            padding: 0;
            margin: 0;
        }

        .row {
            width: 100%;
            padding: 0;
            margin: 0
        }

        .attestation-client {
            width: 700px;
        }

        .attestation-client-title {
            width: 544px;
            border: 1px solid black;
            border-bottom-color: transparent;
            padding: 5px;
        }

        .attestation-client-value {
            width: 544px;
            border: 1px solid black;
            padding: 5px;
        }

        .detail-voucher {
            width: 700px;
            border: 1px solid black;
        }

        .voucher-col1 {
            width: 400px;
        }

        .voucher-col2 {
            width: 120px;
        }

        .voucher-col3 {
            width: 130px;
            /*200px;*/
        }

        .p-5 {
            padding: 5px;
        }

        .border {
            border: 1px solid black;
        }

        .b-l-t {
            border-left-color: transparent;
        }

        .b-r-t {
            border-right-color: transparent;
        }

        .b-t-t {
            border-top-color: transparent;
        }

        .b-b-t {
            border-bottom-color: transparent;
        }

        .contrat-agent {
            width: 700px;
        }

        .contrat {
            width: 270px;
            /*325px;*/
        }

        .contrat-col1 {
            width: 125px;
        }

        .contrat-col2 {
            width: 130px;
        }

        .footer {
            position: fixed;
            bottom: 50px;
            width: 700px;
        }

        .footer p {
            line-height: 5px !important;
            margin: 10px;
        }
    </style>
</head>

<body>
    <div class="bloc-info p-relative">
        <div class="header p-relative">
            <div class="info-generale p-relative d-inline v-top">
                <img src="{{public_path('assets/img/logo.png')}}" alt="logo" class="logo d-block v-top">
                <span class="d-block v-top">Boulevard Ibène 97180 Sainte-Anne</span>
                <span class="d-block v-top">0590 88 19 80 – GSM : 0690 91 81 80</span>
                <span class="d-block v-top">email : contact@gtc.voyage</span>
            </div>
            <div class="titre-voucher p-relative d-inline v-top">
                <div class="titre-style v-top p-5">
                    <p class="p-1 t-center v-top">VOUCHER</p>
                    <p class="t-center v-top">BON D'ECHANGE</p>
                </div>
            </div>
        </div>
        <div class="separateur-bg"></div>
        <div class="body-prestataire p-relative v-top table">
            <div class="info-prest d-relative t-cell v-top">
                <span class="title d-block v-top">Préstataire :</span>
                <span class="title d-block v-top">Adresse :</span>
                <span class="title d-block v-top">Contact :</span>
            </div>
            <div class="info-prest-content d-relative t-cell v-top">
                <span class="value d-block v-top">{{$data['prestataire']['name']}} </span>
                <span class="value d-block v-top">{{$data['prestataire']['adresse']}} {{$data['prestataire']['ville']['name']}} - {{$data['prestataire']['ville']['code_postal']}}</span>
                <span class="value d-block v-top">{{$data['prestataire']['phone']}}</span>
            </div>
            <div class="info-prest-history d-relative t-cell v-top">
                <div class="row">
                    <p><span class="title">Date d'émission :</span><br> {{parse_date_string($commande['date'])}}</p>
                    <div style="height: 5px;"></div>
                    <p><span class="title">Voucher n° :</span> {{$data['id']}}</p>
                </div>
            </div>
        </div>
        <div class="separateur"></div>
        <div class="attestation-client">
            <div class="attestation-client-title title">A L'ATTESTATION DU CLIENT</div>
            <div class="attestation-client-value">{{$commande['nom']}} {{$commande['prenom']}}</div>
        </div>
        <div class="separateur"></div>
        <div class="detail-voucher p-relative table v-top border">
            <div class="voucher-col1 t-cell v-top p-relative">
                <div class="row d-block t-center v-top p-5 border b-t-t b-l-t b-r-t">SERVICE COMME SUIT :</div>
                <div class="row d-block t-left v-top p-5">
                    <div class="row d-block"><span class="title">SERVICES :</span> LOCATION</div>
                    <div class="row d-block"><span class="title">DATE DEBUT LOCATION :</span> {{parse_date_string($data['date_recuperation'])}}</div>
                    <div class="row d-block"><span class="title">DATE FIN LOCATION :</span> {{parse_date_string($data['date_recuperation'])}}</div>
                    <div class="row d-block"><span class="title">VEHICULE :</span>
                        {{$data['titre']}} {{$data['immatriculation']}}
                    </div>
                    <div class="row" style="height: 10px;"></div>
                    <div class="row d-block"><span class="title">TEL :</span> {{$commande['telephone']}}</div>
                    <div class="row d-block"><span class="title">ADRESSE :</span> {{$commande['adresse']}} {{$commande['ville']}} - {{$commande['code_postal']}}</div>
                    <div class="row" style="height: 20px;"></div>
                    <div class="row d-block t-center title p-5 border" style="margin-left: -5px;margin-right: -5px;border-left-color: transparent;border-right-color:transparent;">REMARQUE :</div>
                    <div class="row d-block t-left p5" style="height: 50px;">
                        <p></p>
                    </div>

                </div>
            </div>
            <div class="voucher-col2 t-cell v-top p-relative border b-t-t b-b-t">
                <div class="row d-block t-center v-top p-5 border b-t-t b-l-t b-r-t" style="margin-top: -1px;">REF PRESTATAIRE :</div>
                <div class="row p-relative t-center">
                    PREST-{{$data['prestataire']['id']}}
                </div>
            </div>
            <div class="voucher-col3 t-cell v-top p-relative">
                <div class="row d-block t-center v-top p-5 border b-t-t b-l-t b-r-t">STATUS :</div>
                <div class="row p-relative t-center">
                    {{config('ligne-commande.status')[$commande['status']]['value']}}
                </div>
            </div>
        </div>
        <div class="separateur"></div>
        <div class="contrat-agent">
            <div class="contrat border d-block" style="margin: 0 0 0 auto;">
                <div class="contrat-col1 d-inline v-top">
                    <div class="row d-block title t-center border b-l-t b-r-t b-t-t">AGENT</div>
                    <div class="row d-block" style="height: 50px;"></div>
                </div>
                <div class="contrat-col2 d-inline v-top">
                    <div class="row d-block title t-center border b-r-t b-t-t">CACHET AGENT</div>
                    <div class="row d-block border b-t-t b-r-t b-b-t" style="height: 50px;"></div>
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="row t-center">
                <p>GTC VOYAGE Bld Ibéné – 97180 SAINTE ANNE –Tel : 05 90 88 19 80</p>
                <p>SARL CAPITAL DE 38 112,25 € - SIRET 352 620 00016 - LI N° 971.95.0022</p>
                <p>GARANTIE FINANCIERE : APS - RESPONSABILITE CIVILE : GAN EUROCOURTAGE</p>
            </div>
        </div>
    </div>
</body>

</html>