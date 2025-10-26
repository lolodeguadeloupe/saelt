import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';

Vue.component('facturation', {
    mixins: [SectionPage],
    data: function () {
        return {
            hebergement: [],
            excursion: [],
            location: [],
            billeterie: [],
            transfert: [],
            length_pannier: 0,
            tarifTotal: 0,
            accepted: false,
            taxe_tva: 0,
            tarifTotalTaxe: 0,
            frais_dossier: 0
        }
    },
    created() {
        var _this5 = this;
        var length_pannier = 0;
        _this5.tarifTotal = 0;
        _this5.taxe_tva = 0;
        _this5.tarifTotalTaxe = 0;

        for (var _panier in _this5.data) {
            _this5[_panier] = _this5.data[_panier] == undefined || _this5.data[_panier] == null ? [] : _this5.data[_panier].map(function(_val) {
                length_pannier++;
                _this5.tarifTotal = _this5.tarifTotal + (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer));
                _this5.taxe_tva = _this5.taxe_tva + parseFloat(_val.taxe_calculer);
                return {
                    ..._val,
                    prixHT: parseFloat(_val.computed.prixTotal),
                    computed: {..._val.computed,prixTotal: (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer))},
                    data: _val.data,
                };
            });
        }
        _this5.tarifTotal = parseFloat(_this5.tarifTotal).toFixed(2);
        if(_this5.fraisdossier != null){
            _this5.frais_dossier = _this5.fraisdossier.prix;
        }
        _this5.tarifTotalTaxe = parseFloat(_this5.tarifTotal) + parseFloat(_this5.frais_dossier);
        /*_this5.tva.map(function (_tva) {
            if (_tva.taxe_appliquer == 0) { //valeur_pourcent
                _this5.taxe_tva = (_this5.tarifTotalTaxe * _tva.valeur_pourcent) / 100;
            } else if (_tva.taxe_appliquer == 1) { //valeur_devises
                _this5.taxe_tva = _tva.valeur_devises;
            }
        });*/
        _this5.tarifTotal = parseFloat(_this5.tarifTotalTaxe) - parseFloat(_this5.taxe_tva);
        _this5.taxe_tva = parseFloat(_this5.taxe_tva).toFixed(2);
        /** */
        _this5.tarifTotal = parseFloat(_this5.tarifTotal).toFixed(2);
        _this5.tarifTotalTaxe = parseFloat(_this5.tarifTotalTaxe).toFixed(2);
        _this5.length_pannier = length_pannier;
    },
    methods: {
        accepterCondition() {
            this.accepted = true;
            this.$modal.hide("terme-condition");
        },
        ajouterFacturation(event) {
            var _this5 = this,
                client_info = null,
                payement_mode = null;
            const msg_client_info = "<p>Veuillez valider tous les champs de facturation</p>",
                msg_payement = "<p>Veuillez selectionner votre mode de paiement</p>";

            $('#form-facturation').each(function () {
                client_info = Myform(this).serialized();
            });
            $('#payment-mode').each(function () {
                payement_mode = Myform(this).serialized();
            });
            const is_empty_mode_payement = _this5.$isEmpty(payement_mode);

            if (client_info == null || _this5.$isEmpty(payement_mode)) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: `${client_info == null ? msg_client_info : ''} ${is_empty_mode_payement ? msg_payement : ''}`,
                    buttons: [{
                        title: _this5.$dictionnaire.info_form_incomplete_btn_confirm,
                        handler: () => {
                            _this5.$modal.hide('dialog')
                        }
                    }],
                    class: 'alert alert-danger',
                });
                return;
            }
            var data_panier = {
                hebergement: _this5.hebergement,
                excursion: _this5.excursion,
                location: _this5.location,
                billeterie: _this5.billeterie,
                transfert: _this5.transfert,
                tarifTotal: _this5.tarifTotal,
                taxe_tva: _this5.taxe_tva,
                frais_dossier: _this5.frais_dossier,
                tarifTotalTaxe: _this5.tarifTotalTaxe
            }
            let loading_ = $(event.target).InputLoadRequest();
            let loading = _this5.$loading();
            axios.post(`${_this5.urlbase}/paiement-facturation`, {
                ...data_panier,
                client_info: client_info,
                mode_payement: payement_mode.payement
            }).then(function (response) {
                console.log(response)
                window.location.href = response.data;
                /*_this5.managerRequest(event, `${_this5.urlbase}/remerciement`, { id: response.data.id });*/
            }).catch(function (errors) {
                var all_error = {};
                if (errors.response.data != undefined && errors.response.data) {
                    for (var _err in errors.response.data.errors) {
                        if (String(_err).split('.').length > 1) {
                            all_error[String(_err).split('.')[1]] = errors.response.data.errors[_err][0];
                        }
                    }
                }
                $('#form-facturation').each(function () {
                    Myform(this).erreur(all_error);
                });
            }).finally(() => {
                loading.remove();
                loading_.remove();
            });
        }
    },
    props: [
        'panier',
        'tva',
        'modepayement',
        'fraisdossier'
    ]
});