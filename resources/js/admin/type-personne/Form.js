import AppForm from '../app-components/Form/AppForm';

Vue.component('type-personne-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                type:  '' ,
                
            }
        }
    }

});