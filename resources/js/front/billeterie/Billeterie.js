import Myform from '../app-front/helperForm';
import SectionPage from '../app-front/SectionPage';

Vue.component('billeterie', {
    mixins: [SectionPage],
    data: function () {
        return {
            editpannier: false,
            date_commande: null,
        }
    },
    mounted() {
        var _this5 = this;
        if (_this5.sessionrequest && _this5.sessionrequest.parcours && _this5.sessionrequest.arrive && _this5.sessionrequest.depart && _this5.sessionrequest.date_depart) {
            _this5.action_search = true;
        }
    },
    methods: {
        validerCommander(event, item, form) {
            var _this5 = this,
                data_form = null,
                _el = event.currentTarget;

            const data = {
                item: item,
                marge_calculer: item.tarif_calculer.marge,
                date_commande: _this5.date_commande
            };
            const computed = {
                prixTotal: item.parcours == 2 ? item.tarif_calculer.aller_retour : item.tarif_calculer.aller
            };
            $(`#${form}`).each(function () {
                data_form = Myform(this).serialized();
            });
            if (data_form == null) {
                _this5.$modal.show('dialog', {
                    title: _this5.$dictionnaire.info_form_incomplete_title,
                    text: _this5.$dictionnaire.commande_produit_billeterie_heure_invalid,
                    buttons: [{
                        title: _this5.$dictionnaire.info_form_incomplete_btn_confirm,
                        handler: () => {
                            this.$modal.hide('dialog')
                        }
                    }],
                    class: 'alert alert-danger',
                });
                return;
            };
            _this5.putCommande(
                event,
                'billeterie', {
                data: JSON.stringify(data),
                computed: JSON.stringify(computed),
                form: data_form,
                edit_pannier: _this5.editpannier == 'true',
                date_commande: _this5.date_commande
            },
                function (commande_reponse) {
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
                        props: ['billeterie', 'location', 'panier', 'achat']
                    }, {
                        panier: function () {
                            _this5.$modal.hide('dialog')
                            _this5.managerRequest(event, `${_this5.urlbase}/panier`, { id: $(_el).attr('id-commande') })
                        },
                        achat: function () {
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