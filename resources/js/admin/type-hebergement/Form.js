import AppForm from '../app-components/Form/AppForm';

Vue.component('type-hebergement-form', {
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