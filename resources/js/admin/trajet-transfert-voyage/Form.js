import AppForm from '../app-components/Form/AppForm';

Vue.component('trajet-transfert-voyage-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                point_depart:  '' ,
                point_arrive:  '' ,
                description:  '' ,
                
            }
        }
    }

});