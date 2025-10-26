import AppForm from '../app-components/Form/AppForm';

Vue.component('media-image-upload-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                id_model:  '' ,
                name:  '' ,
                
            }
        }
    }

});