import AppForm from '../app-components/Form/AppForm';

Vue.component('saison-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                debut:  '' ,
                fin:  '' ,
                jour:  '' ,
                nuit:  '' ,
                
            }
        }
    }

});