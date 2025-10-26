import AppForm from '../app-components/Form/AppForm';

Vue.component('billeterie-maritime-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                number:  '' ,
                compagnie_transport_id:  '' ,
                
            }
        }
    }

});