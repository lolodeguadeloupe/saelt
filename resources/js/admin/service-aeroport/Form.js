import AppForm from '../app-components/Form/AppForm';

Vue.component('service-aeroport-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                code_service:  '' ,
                name:  '' ,
                adresse:  '' ,
                phone:  '' ,
                email:  '' ,
                logo:  '' ,
                ville_id:  '' ,
                
            }
        }
    }

});