import SectionPage from '../app-front/SectionPage';

Vue.component('transfert', {
    mixins: [SectionPage],
    data: function() {
        return {
            editpannier: false,
            date_commande: null,
            marge_calculer: 0
        }
    },
    methods: {
        validerCommander(event, item) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget; 

            const data = {
                item: item,
                marge_calculer: item.tranche.tarif_calculer.marge,
                date_commande: _this5.date_commande
            };
            const computed = {
                prixTotal: item.parcours == 2 ? item.tranche.tarif_calculer.aller_retour : item.tranche.tarif_calculer.aller
            };
            _this5.putCommande(
                event,
                'transfert', {
                    data: JSON.stringify(data),
                    computed: JSON.stringify(computed),
                    form: data_form,
                    edit_pannier: _this5.editpannier == 'true',
                    date_commande: _this5.date_commande
                },
                function(commande_data) {
                    _this5.$modal.show({
                        template: `
                            <div class="card border-success text-center">
                                <div class="card-header bg-success text-uppercase font-weight-bold card-title text-white">
                                    ${_this5.$dictionnaire.commande_produit_succes_title}
                                </div>
                                <div class="card-body pb-5">
                                    <p class="card-text"> ${_this5.$dictionnaire.commande_produit_succes} </p> 
                                </div>
                                <div class="card-footer text-muted d-flex align-items-center bg-success">
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="achat">${_this5.$dictionnaire.commande_produit_btn_continuer_achat}</button>
                                    <button type="button" class="btn btn-success btn-lg m-auto" @click.prevent="panier">${_this5.$dictionnaire.commande_produit_btn_passer_commande}</button>
                                </div>
                            </div>
                      `,
                        props: ['panier', 'achat']
                    }, {
                        panier: function() {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function() {
                            _this5.$modal.hide('dialog')
                            window.location.reload();
                        }
                    }, {
                        height: 'auto',
                        clickToClose: false
                    }, {
                        'before-open': e => {

                        },
                        'before-close': e => {

                        }
                    });
                }
            );
        }
    },
    props: [

    ]
});