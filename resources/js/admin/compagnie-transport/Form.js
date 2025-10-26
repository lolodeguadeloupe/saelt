import AppForm from '../app-components/Form/AppForm';

Vue.component('compagnie-transport-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                nom:  '' ,
                email:  '' ,
                phone:  '' ,
                adresse:  '' ,
                
            }
        }
    }

});