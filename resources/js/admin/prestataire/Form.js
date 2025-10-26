import AppForm from '../app-components/Form/AppForm';

Vue.component('prestataire-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                adresse:  '' ,
                phone:  '' ,
                email:  '' ,
                
            }
        }
    }

});