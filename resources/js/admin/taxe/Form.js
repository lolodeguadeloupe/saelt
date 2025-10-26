import AppForm from '../app-components/Form/AppForm';

Vue.component('taxe-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                valeur_pourcent:  '' ,
                valeur_devises:  '' ,
                descciption:  '' ,
                
            }
        }
    }

});