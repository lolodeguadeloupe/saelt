import AppForm from '../app-components/Form/AppForm';

Vue.component('island-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                
            }
        }
    }

});