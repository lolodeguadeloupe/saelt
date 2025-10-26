import AppForm from '../app-components/Form/AppForm';

Vue.component('devise-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                symbole:  '' ,
                
            }
        }
    }

});