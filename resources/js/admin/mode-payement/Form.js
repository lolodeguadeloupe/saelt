import AppForm from '../app-components/Form/AppForm';

Vue.component('mode-payement-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                
            }
        }
    }

});