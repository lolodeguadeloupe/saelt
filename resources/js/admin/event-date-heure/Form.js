import AppForm from '../app-components/Form/AppForm';

Vue.component('event-date-heure-form', {
    mixins: [AppForm],
    data: function() {
        return {
            form: {
                description:  '' ,
                date:  '' ,
                time_start:  '' ,
                time_end:  '' ,
                model_event:  '' ,
                status:  '' ,
                
            }
        }
    }

});