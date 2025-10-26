import SectionPage from '../app-front/SectionPage';

Vue.component('other-product', {
    mixins: [SectionPage],
    data: function() {
        return {
            allIsland: [],
        }
    },
    mounted() {
        this.allIsland = this.$grouperArray(this.aside && this.aside.ile && this.aside.ile != undefined ? this.aside.ile : [], 3);
    },
    methods: {
        hasProduitStatus(){
            var has = false;
            for(var k in this.aside.produit){
                if(this.aside.produit[k].status == 1){
                    has = true;
                }
            }
            return has;
        },
    },
    props: [

    ]
});