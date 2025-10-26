import HeaderPage from '../app-front/HeaderPage';

Vue.component('header-bar-front', {
    mixins: [HeaderPage],
    data: function() {
        return {}
    },
    mounted() {},
    methods: {
        loadData: function loadData() {
            return;
        }
    },
    props: [

    ]
});