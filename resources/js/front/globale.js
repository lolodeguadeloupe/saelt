import './bootstrap';

import 'vue-multiselect/dist/vue-multiselect.min.css';
import 'vue-select/dist/vue-select.css';
import flatPickr from 'vue-flatpickr-component';
import VueQuillEditor from 'vue-quill-editor';
import Notifications from 'vue-notification';
import Multiselect from 'vue-multiselect';
import VeeValidate from 'vee-validate';
import 'flatpickr/dist/flatpickr.css';
import VueCookie from 'vue-cookie';
import VModal from 'vue-js-modal';
import Vue from 'vue';
import VCalendar from 'v-calendar';
import vSelect from 'vue-select';
import '../admin/myAutocompletion/myAutocomplete.css'
import MyAutocomplete from '../admin/myAutocompletion/MyAutoCompletion';

Vue.component('multiselect', Multiselect);
Vue.use(VeeValidate, { strict: true });
Vue.component('datetime', flatPickr);
Vue.use(VModal, { dialog: true, dynamic: true, injectModalsContainer: true });
Vue.use(VueQuillEditor);
Vue.use(Notifications);
Vue.use(VueCookie);
Vue.use(VCalendar, {
    componentPrefix: 'vc'
});
Vue.component('v-select', vSelect)
Vue.prototype.$calendarCommande = [
    { 'cmd': 'Left', 'action': 'Move to the previous day' },
    { 'cmd': 'Right', 'action': 'Move to the next day' },
    { 'cmd': 'Up', 'action': 'Move to the previous week' },
    { 'cmd': 'Down', 'action': 'Move to the next week' },
    { 'cmd': 'Home', 'action': 'Move to the start of the current week' },
    { 'cmd': 'End', 'action': 'Move to the end of the current week' },
    { 'cmd': 'PgUp', 'action': 'Move to the same day of the previous month' },
    { 'cmd': 'PgDown', 'action': 'Move to the same day of the next month' },
    { 'cmd': 'Alt + PgUp', 'action': 'Move to the same month and day of the previous year' },
    { 'cmd': 'Alt + PgDown', 'action': 'Move to the same month and day of the next year' },
];
Vue.prototype.$redirect = (url) => {
    window.location.replace(url);
}
Vue.prototype.$grouperArray = (arr = [], groupe = 1) => {
    var count = 0;
    var new_array = [];
    while (count < arr.length) {
        var pus_arr = [];
        for (let index = count; index < count + groupe; index++) {
            pus_arr = [...pus_arr, arr[index]];
        }
        new_array = [...new_array, pus_arr];
        count = count + groupe;
    }
    return new_array;
}
Vue.prototype.cloneObject = (obj) => {
    var new_obj = JSON.stringify(obj);
    return JSON.parse(new_obj);
}
Vue.prototype.$lowerCase = ($string) => {
    if ($string == null || String($string).trim() == '') {
        return '';
    }
    return String($string).toLowerCase();
}
Vue.prototype.$upperCase = ($string) => {
    if ($string == null || String($string).trim() == '') {
        return '';
    }
    return String($string).toUpperCase();
}
Vue.filter('formatTime', function(value) {
    if (value) {
        const parts = value.split(":");
        return +String('0' + parts[0]).substr(-2) + "h " + String('0' + parts[1]).substr(-2) + "m";
    } else {
        return "unknown"
    }
});
Vue.prototype.$dictionnaire = (function(lang) {
    var dict = {};
    switch (lang) {
        case 'en':
            dict = {
                'warning': 'Warning',
                'delete_confirm': 'Do you really want to delete',
                'delete_item_confirm': 'Do you really want to delete this item',
                'confirm_no_cancel': 'No, cancel',
                'confirm_yes_delete': 'Yes, delete',
                'item_successful_delete': 'Item successfully deleted',
                'error_occured': 'An error has occured',
                'success': 'Success',
                'error': 'Error',
                'selected_item': 'selected items',
                'form_error': 'The form contains invalid fields.',
                'confirm_save': 'Do you really want to save',
                'confirm_yes_save': 'Yes, save',
                'file_error': 'An error has occured',
                'file_size': 'An error of size file',
                'select_error': 'Try to valid champ',
                'btn_new_autocomplete': 'new item ...',
                'new_event_calendar': 'new event ...',
                'status_calendar_passe': 'Past',
                'status_calendar_active': 'Active',
                'status_calendar_desactive': 'Desactive',
                'no_image_avaible': 'No image available',
                'week_list': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'btn_save': 'Save',
                /* champ front */
                'info_form_incomplete_title': 'Champs obligatoires',
                'info_form_incomplete': 'Veuillez renseigner tous les champs obligatoires',
                'info_form_incomplete_btn_confirm': 'Ok',
                'commande_produit_succes_title': 'Commande réussi',
                'commande_produit_succes': 'Votre commande a bien été prise en compte',
                'commande_produit_succes_btn_ok': 'Ok',
            }
            break;
        case 'fr':
            dict = {
                'warning': 'Avertissement',
                'delete_confirm': 'Voulez-vous vraiment supprimer',
                'delete_item_confirm': 'Voulez-vous vraiment supprimer cet élément',
                'confirm_no_cancel': 'Non, annuler',
                'confirm_yes_delete': 'Oui, supprimer',
                'item_successful': 'Élément supprimé avec succès',
                'error_occured': 'Une erreur s\'est produite',
                'success': 'Succès',
                'error': 'Erreur',
                'selected_item': 'éléments sélectionnés',
                'form_error': 'Donnée invalide',
                'confirm_save': 'Voulez-vous enregistrer cette modification',
                'confirm_yes_save': 'Oui, enregistrer',
                'file_error': 'Une erreur s\'est produite',
                'file_size': 'Une erreur sur la taille de l\'image',
                'select_error': 'Veuillez valider le champ',
                'btn_new_autocomplete': 'Créer nouveau element ...',
                'new_event_calendar': 'Nouvel événement ...',
                'status_calendar_passe': 'Passé',
                'status_calendar_active': 'Activé',
                'status_calendar_desactive': 'Desactivé',
                'no_image_avaible': 'Pas d\'image disponible',
                'week_list': ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                'btn_save': 'Enregistrer',
                /* champ front */
                'info_form_incomplete_title': 'Champs obligatoires',
                'info_form_incomplete': 'Veuillez renseigner tous les champs obligatoires',
                'info_form_incomplete_btn_confirm': 'Ok',
                'commande_produit_succes_title': 'Commande réussi',
                'commande_produit_succes': 'Votre commande a bien été prise en compte',
                'commande_produit_succes_btn_ok': 'Ok',
            }
            break;
    }
    return dict;
})('fr');

Vue.directive('autocompletion', {
    inserted: function(el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding;
        /*{autocompletion, ="value", ="<expression>", v-autocompletion:<arg>,v-autocompletion:arg.<modifiers>.<modifiers>...}*/
        var s = JSON.stringify;
        var options = typeof value == 'function' ? value() : {};
        var defaultOption = { attrs: { action: '', autokey: '', label: '', ...vnode.data.attrs }, ajax: null, dataRequest: {}, fnSelectItem: null, detailInfo: [], formateDetailInfo: null, fnBtnNew: null, frame: null };
        defaultOption.attrs = { inputlabel: null, inputkey: null, ...defaultOption.attrs }
        options = {...defaultOption, ...options, dict: Vue.prototype.$dictionnaire };
        MyAutocomplete(el).readed(options)
    }
})

Vue.directive('parsehtml', {
    inserted: function(el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding, options = {...vnode.data.attrs };
        $(el).html('');
        $(value).appendTo($(el));
    },
    update: function(el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding, options = {...vnode.data.attrs };
        $(el).html('');
        $(value).appendTo($(el));
    }
})

Vue.prototype.$pushFnBody = (data) => {
    var _event = (typeof $('body').data('component_body_listner') !== 'undefined') ? $('body').data('component_body_listner') || {} : {};
    var _isEvent = {},
        keys = [];
    for (const _e_ in _event) {
        keys.push(_e_);
    }
    for (const _e_ in _event) {
        if (typeof _event[_e_] === 'function') {
            _isEvent[_e_] = _event[_e_];
        } else {
            console.error('probleme component_body_listner type');
        }
    }
    for (const _e_ in data) {
        if (typeof data[_e_] === 'function' && keys.indexOf(_e_) < 0) {
            _isEvent[_e_] = data[_e_];
        }
    };

    $('body').data('component_body_listner', _isEvent);
}

Vue.prototype.$getFnBody = () => {
    return (typeof $('body').data('component_body_listner') !== 'undefined') ? $('body').data('component_body_listner') || {} : {};
}

Vue.prototype.$getKey = (array_, key) => {
    return array_.map(function(data) {
        return data[key];
    });
}

Vue.prototype.$toJson = (data) => {
    return JSON.stringify(data);
}

Vue.prototype.$loading = () => {
    var elm = null;
    $('.loading-front').each(function() {
        elm = this;
        $(this).css({ display: 'flex', 'background-color': 'transparent' });
    });
    return {
        remove: function() {
            if (elm) {
                $(elm).css({ display: 'none' });
            }
        }
    }
}

Vue.prototype.$countEtoil = (etoil) => {
    console.log(etoil)
    if (typeof etoil == 'undefined' || etoil == null || isNaN(etoil)) {
        return '';
    } else {
        var _etoil = '';
        for (var k = 0; k < parseInt(etoil); k++) {
            _etoil = _etoil + ' ★';
        }
        return _etoil;
    }
}

Vue.prototype.$textDescription = (text, limite) => {
    return typeof limite == undefined ? text : String(text).substr(0, limite);
}

Vue.prototype.$isNumber = (val) => {
    return String(val).trim() != '' && !isNaN(val);
}

Vue.prototype.$setDefaultValue = (event) => {
    $(event.target).each(function() {
        $(this).val((String($(this).val()).trim() != '' && !isNaN(String($(this).val()))) ? $(this).val() : $(this).attr('data-oldValue'));
    });
}

Vue.prototype.$forceParseDate = (date) => {
    moment(date).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY');
}