import SectionPage from '../app-front/SectionPage';
import Myform from '../app-front/helperForm';

Vue.component('remerciement', {
    mixins: [SectionPage],
    data: function() {
        return {
            hebergement: [],
            excursion: [],
            location: [],
            billeterie: [],
            transfert: [],
            date: '',
            status: '',
            prix: '',
            tva: '',
            frais_dossier: '',
            prix_total: '',
            nom: '',
            prenom: '',
            adresse: '',
            ville: '',
            code_postal: '',
            telephone: '',
            email: '',
            mode_payement: {}
        }
    },
    created() {
        var _this5 = this;
        //data
        if (this.data[0] != undefined) {
            this.hebergement = this.data[0].hebergement;
            this.excursion = this.data[0].excursion;
            this.location = this.data[0].location;
            this.billeterie = this.data[0].billeterie;
            this.transfert = this.data[0].transfert;
            /** */
            this.date = this.data[0].date;
            this.status = this.data[0].status;
            this.prix = this.data[0].prix;
            this.tva = this.data[0].tva;
            this.prix_total = this.data[0].prix_total;
            this.nom = this.data[0].nom;
            this.prenom = this.data[0].prenom;
            this.adresse = this.data[0].adresse;
            this.ville = this.data[0].ville;
            this.code_postal = this.data[0].code_postal;
            this.telephone = this.data[0].telephone;
            this.email = this.data[0].email;
            this.mode_payement = this.data[0].mode_payement;
            this.frais_dossier = this.data[0].frais_dossier
        }
    },
    methods: {
        calculerSupplement(supp = []) {
            var somme = 0;
            supp.map(function(_supp) {
                somme = somme + parseFloat(_supp.prix);
            })
            return somme;
        }
    },
    props: []
});