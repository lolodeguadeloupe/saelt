import SectionPage from '../app-front/SectionPage';

Vue.component('panier', {
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
            taxe_tva: 0,
            tarifTotalTaxe: 0,
            frais_dossier: 0
        }
    },
    created() {
        var _this5 = this;
        var length_pannier = 0;
        this.tarifTotal = 0;
        _this5.taxe_tva = 0;
        _this5.tarifTotalTaxe = 0;
        for (var _panier in _this5.data) {
            console.log(_this5.data[_panier])
            _this5[_panier] = _this5.data[_panier] == undefined || _this5.data[_panier] == null ? [] : _this5.data[_panier].map(function (_val) {
                length_pannier++;
                _this5.tarifTotal = _this5.tarifTotal + (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer));
                _this5.taxe_tva = _this5.taxe_tva + parseFloat(_val.taxe_calculer);
                return {
                    ..._val,
                    prixHT: parseFloat(_val.computed.prixTotal),
                    computed: { ..._val.computed, prixTotal: (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer)) },
                    data: _val.data,
                };
            });
        }
        _this5.tarifTotal = parseFloat(_this5.tarifTotal).toFixed(2);
        if (_this5.fraisdossier != null) {
            _this5.frais_dossier = _this5.fraisdossier.prix;
        }
        _this5.tarifTotalTaxe = parseFloat(_this5.tarifTotal) + parseFloat(_this5.frais_dossier);
        /*_this5.tva.map(function(_tva) {
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
    computed: {
        has_produit() {
            return this.hebergement.length > 0 || this.location.length > 0 || this.excursion.length > 0 || this.billeterie.length > 0 || this.transfert.length > 0;
        }
    },
    methods: {
        loadPanier: function (data = []) {
            var _this5 = this;
            var length_pannier = 0;
            this.tarifTotal = 0;
            _this5.taxe_tva = 0;
            _this5.hebergement = [];
            _this5.location = [];
            _this5.excursion = [];
            _this5.billeterie = [];
            _this5.transfert = [];
            for (var _panier in data) {
                _this5[_panier] = data[_panier] == undefined || data[_panier] == null ? [] : data[_panier].map(function (_val) {
                    length_pannier++;
                    _this5.tarifTotal = _this5.tarifTotal + (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer));
                    _this5.taxe_tva = _this5.taxe_tva + parseFloat(_val.taxe_calculer);
                    return {
                        ..._val,
                        prixHT: parseFloat(_val.computed.prixTotal),
                        computed: { ..._val.computed, prixTotal: (parseFloat(_val.computed.prixTotal) + parseFloat(_val.taxe_calculer)) },
                        data: _val.data,
                    };
                });
            }
            _this5.tarifTotal = parseFloat(_this5.tarifTotal).toFixed(2);
            _this5.tarifTotalTaxe = parseFloat(_this5.tarifTotal) + parseFloat(_this5.frais_dossier);
            _this5.tarifTotal = parseFloat(_this5.tarifTotalTaxe) - parseFloat(_this5.taxe_tva);
            _this5.taxe_tva = parseFloat(_this5.taxe_tva).toFixed(2);
            /** */
            _this5.tarifTotal = parseFloat(_this5.tarifTotal).toFixed(2);
            _this5.tarifTotalTaxe = parseFloat(_this5.tarifTotalTaxe).toFixed(2);
            _this5.length_pannier = length_pannier;
        },
        deletePanier: function (event, commande, id_commande, id_produit, data = {}) {
            var _this5 = this;
            this.deleteCommande(event, commande, {
                id: id_commande,
                id_produit: id_produit,
                ...data
            }, _this5.loadPanier);
        },
    },
    props: [
        'tva',
        'modepayement',
        'fraisdossier'
    ]
});