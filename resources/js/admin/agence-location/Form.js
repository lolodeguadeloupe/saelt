import AppForm from '../app-components/Form/AppForm';

Vue.component('agence-location-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                code_agent:  '' ,
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