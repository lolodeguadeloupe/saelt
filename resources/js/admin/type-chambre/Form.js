import AppForm from '../app-components/Form/AppForm';

Vue.component('type-chambre-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                description:  '' ,
                
            }
        }
    }

});