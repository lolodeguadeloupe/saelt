import AppForm from '../app-components/Form/AppForm';

Vue.component('compagnie-liaison-excursion-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                excursion_id:  '' ,
                compagnie_transport_id:  '' ,
                
            }
        }
    }

});