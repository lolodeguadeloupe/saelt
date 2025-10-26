import AppForm from '../app-components/Form/AppForm';

Vue.component('base-type-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                description:  '' ,
                
            }
        }
    }

});