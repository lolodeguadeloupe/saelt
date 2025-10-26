import AppForm from '../app-components/Form/AppForm';

Vue.component('ile-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});