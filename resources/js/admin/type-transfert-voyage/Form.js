import AppForm from '../app-components/Form/AppForm';

Vue.component('type-transfert-voyage-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                titre:  '' ,
                description:  '' ,
                nombre_min:  '' ,
                nombre_max:  '' ,
                
            }
        }
    }

});