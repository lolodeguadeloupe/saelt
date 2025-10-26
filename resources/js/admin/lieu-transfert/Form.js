import AppForm from '../app-components/Form/AppForm';

Vue.component('lieu-transfert-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                adresse:  '' ,
                ville_id:  '' ,
                
            }
        }
    }

});