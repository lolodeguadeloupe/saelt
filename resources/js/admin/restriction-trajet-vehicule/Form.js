import AppForm from '../app-components/Form/AppForm';

Vue.component('restriction-trajet-vehicule-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                agence_location_depart:  '' ,
                agence_location_arrive:  '' ,
                
            }
        }
    }

});