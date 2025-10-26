import AppForm from '../app-components/Form/AppForm';

Vue.component('allotement-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                quantite:  '' ,
                date_depart:  '' ,
                date_acquisition:  '' ,
                date_limite:  '' ,
                compagnie_transport_id:  '' ,
                
            }
        }
    }

});