import ProduitAssocier from '../app-front/ProduitAssocier';

Vue.component('hebergement-produit-associer', {
    mixins: [ProduitAssocier],
    data: function () {
        return {
            
        }
    },
    watch: {
        'collection': function collection(newVal, oldVal) {
            if (+newVal !== +oldVal) {
            }
        }
    },
    methods: {

    },
    props: [

    ]
});