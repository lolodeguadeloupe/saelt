import AppForm from '../app-components/Form/AppForm';

Vue.component('pay-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nom:  '' ,
                
            }
        }
    }

});