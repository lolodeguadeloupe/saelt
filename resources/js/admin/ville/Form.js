import AppForm from '../app-components/Form/AppForm';

Vue.component('ville-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                name:  '' ,
                island_id:  '' ,
                
            }
        }
    }

});