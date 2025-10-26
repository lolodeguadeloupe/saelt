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
import { Admin } from 'craftable';
import VModal from 'vue-js-modal'
import Vue from 'vue';
import VCalendar from 'v-calendar';
import vSelect from 'vue-select'
import './app-components/bootstrap';
import './index';
import './myAutocompletion/myAutocomplete.css'
import MyAutocomplete from './myAutocompletion/MyAutoCompletion';

import 'craftable/dist/ui';

const dict = function dict(lang) {
    switch (lang) {
        case 'en':
            return {
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
                'no_file_avaible': 'No de file available',
                'week_list': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'short_week_list': ['Mon.', 'Tue.', 'Wed.', 'Thu.', 'Fri.', 'Sat', 'Sun.'],
                'short_month': ['Janv.', 'Fev.', 'Mars', 'Avr.', 'May', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                'btn_save': 'Save',
                //
                'compagnie': 'Compagnie',
                'saison': 'Saisonnalité',
                'aeroports': 'Aéroport',
                'prestataire': 'Prestataires',
                'billeterie': 'Billeteries maritimes',
                'type_personne': 'Types de personnes'
            };
        case 'fr':
            return {
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
                'file_size': 'Une erreur sur la taille de fichier',
                'select_error': 'Veuillez valider le champ',
                'btn_new_autocomplete': 'Créer nouveau element ...',
                'new_event_calendar': 'Nouvel événement ...',
                'status_calendar_passe': 'Passé',
                'status_calendar_active': 'Activé',
                'status_calendar_desactive': 'Desactivé',
                'no_image_avaible': 'Pas d\'image disponible',
                'week_list': ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                'short_week_list': ['Lun.', 'Mar.', 'Mer.', 'Jeu.', 'Ven.', 'Sam.', 'Dim.'],
                'short_month': ['Janv.', 'Fev.', 'Mars', 'Avr.', 'May', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                'btn_save': 'Enregistrer',
                //
                'compagnie': 'Compagny',
                'saison': 'Saisonnalité',
                'aeroports': 'Aéroport',
                'prestataire': 'Prestataires',
                'billeterie': 'Billeteries maritimes',
                'type_personne': 'Types de personne',
                /** */
                'tarif_saison_vide': 'Vous \'avez pas encore de tarif, veuillez créer d\'abord',
            };
    }
}

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
    window.location = url;
}
Vue.prototype.$managerliens = (data = {
    is_parent: true,
    parent_name: '',
    href: '',
    name: '',
    body: '',
    _this: '',
    axios: '',
    _$: ''
}) => {
    let loading = data._$(data.body).InputLoadRequest();
    data.axios.post(`${data._this.urlbase}/admin/service-sessions/push`, {
        is_parent: data.is_parent,
        parent_name: data.parent_name,
        href: data.href,
        name: data.name,
        liens: data._this.$liens,
        range: data.range
    }).then(function (response) {
        window.location = data.href;
    }).catch(function (errors) {

    }).finally(() => {
        loading.remove();
    });
}

Vue.filter('formatTime', function (value) {
    if (value) {
        const parts = value.split(":");
        return +String('0' + parts[0]).substr(-2) + "h " + String('0' + parts[1]).substr(-2) + "mn";
    } else {
        return "unknown"
    }
});
Vue.prototype.$formatTime = function (value) {
    if (value) {
        const parts = value.split(":");
        return +String('0' + parts[0]).substr(-2) + "h " + String('0' + parts[1]).substr(-2) + "mn";
    } else {
        return "unknown"
    }
};
Vue.prototype.$dictionnaire = (function (lang) {
    return dict(lang);
})('fr');

Vue.prototype.$liens = (function (lang) {
    var lien = {};
    switch (lang) {
        case 'en':
            lien = {
                'hebergement': 'Hebergement',
                'excursion': 'Excursion',
                'transfert': 'Transfert',
                'location': 'Location',
                'billeterie': 'Billeterie',
                'commande': 'Commade',
                'typePersonne': 'Type personne',
                'categorieVehicule': 'Catégorie véhicule',
                'typeTransfert': 'Type transfert',
                'planing_vehicule': 'Planing véhicule',
                'coup_coeur': 'coups de cœur'
            }
            break;
        case 'fr':
            lien = {
                'hebergement': 'Hebergement',
                'excursion': 'Excursion',
                'transfert': 'Transfert',
                'location': 'Location',
                'billeterie': 'Billeterie',
                'commande': 'Commade',
                'typePersonne': 'Type personne',
                'categorieVehicule': 'Catégories véhicules',
                'typeTransfert': 'Type',
                'planing_vehicule': 'Planing véhicule',
                'coup_coeur': 'coups de cœur'
            }
            break;
    }
    return lien;
})('fr');

Vue.prototype.$beforCloseWindow = (_data) => {
    var data = [];
    if (typeof _data == "function") {
        data.push(data);
    }
    return data;
}

Vue.directive('autocompletion', {
    inserted: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding;
        /*{autocompletion, ="value", ="<expression>", v-autocompletion:<arg>,v-autocompletion:arg.<modifiers>.<modifiers>...}*/
        var s = JSON.stringify;
        var options = typeof value == 'function' ? value() : {};
        var defaultOption = { attrs: { action: '', autokey: '', label: '', ...vnode.data.attrs }, ajax: null, dataRequest: {}, fnSelectItem: null, detailInfo: [], formateDetailInfo: null, fnBtnNew: null, frame: null, fnBtnNewEnable: true };
        defaultOption.attrs = { inputlabel: null, inputkey: null, ...defaultOption.attrs }
        options = { ...defaultOption, ...options, dict: Vue.prototype.$dictionnaire };
        MyAutocomplete(el).readed(options);
    }
})

Vue.directive('parsehtml', {
    inserted: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding;
        $(el).html('');
        $(value).appendTo($(el));
    },
    update: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding;
        $(el).html('');
        $(value).appendTo($(el));
    }
})

Vue.prototype.$parseDate = (date) => {
    const d = new Date(date);
    d.setHours(d.getHours() + (d.getTimezoneOffset() / 60))
    return d;
}

Vue.prototype.$initTime = (date) => {
    return moment(date).set({
        'hour': 0,
        'minute': 0,
        'seconde': 0,
        'millisecond': 0
    });
}

Vue.prototype.$parseDateToString = function (date, parse = false) {
    if (date == '') return '';
    const d = new Date(date);
    if (parse) {
        d.setHours(d.getHours() + (d.getTimezoneOffset() / 60));
    }
    return moment(date).format('YYYY-MM-DD');
}

Vue.prototype.$intervalDateDays = function (date1, date2, parse = false) {
    const d1 = new Date(date1);
    const d2 = new Date(date2);
    if (parse) {
        d1.setHours(d1.getHours() + (d1.getTimezoneOffset() / 60));
        d2.setHours(d2.getHours() + (d2.getTimezoneOffset() / 60));
    }
    return moment(d2).diff(moment(d1), 'days');
}

Vue.prototype.$getArrayDateString = (arr = []) => {
    return arr.map(date => moment(date).format('DD/MM/YYYY')).join(' ,');
}

Vue.prototype.$formatDateString = (date = "", parse = false) => {
    const d = new Date(date);
    if (parse) {
        d.setHours(d.getHours() + (d.getTimezoneOffset() / 60));
    }
    return `${String(`0${d.getDate()}`).substr(-2)} ${dict('fr').short_month[d.getMonth()]} ${d.getFullYear()}`;
}

Vue.prototype.$isEmpty = function (obj) {
    var count = 0;
    if (obj == null) return true;
    for (var k in obj) {
        count++;
    }
    return count == 0;
}

Vue.prototype.$isBase64 = function (image) {
    return String(image).match(/^data:/) != null && String(image).match(/;base64,/) != null;
}

Vue.prototype.$promise = function (callback, time = 60) {
    setTimeout(callback, time);
}

Vue.prototype.$parseFloat = function (val) {
    return parseFloat(val).toFixed(2);
}

Vue.prototype.$splite = function (val, splite = ';') {
    if (String(val) == '') return [];
    return String(val).split(splite);
}

Vue.prototype.$parseInt = function (val) {
    return parseInt(val);
}

Vue.prototype.$getKey = (array_, key) => {
    return array_.map(function (data) {
        return data[key];
    });
}

Vue.prototype.$joinKey = (array_, key, join_ = '-') => {
    var all_key = array_.map(function (data) {
        return data[key];
    });

    return all_key.join(join_);
}

Vue.prototype.$toJson = (_val) => {
    return JSON.stringify(_val);
}

Vue.prototype.$parseJson = (_val) => {
    return JSON.parse(_val);
}

Vue.prototype.$plusDays = (date, days = 1) => {
    return moment(date).day(moment(date).day() + days).toDate();
}

Vue.prototype.$plusYears = (date, year = 1) => {
    return moment(date).year(moment(date).year() + year).toDate();
}

Vue.prototype.$plusMonths = (date, month = 1) => {
    return moment(date).month(moment(date).month() + month).toDate();
}

Vue.prototype.$initCalendar = (date) => {
    return moment(date).set({
        'date': 1,
        'month': 0,
    }).toDate();
}

Vue.prototype.$grouperArray = (arr = [], groupe = 1) => {
    var count = 0;
    var new_array = [];
    while (count < arr.length) {
        var pus_arr = [];
        for (let index = count; index < count + groupe  && arr[index] != undefined; index++) {
            pus_arr = [...pus_arr, arr[index]];
        }
        new_array = [...new_array, pus_arr];
        count = count + groupe;
    }
    return new_array;
}

Vue.prototype.$incrementeTo = (increment, val = 1) => {
    const array_ = [];
    for (let index = val; index < parseInt(val) + parseInt(increment); index++) {
        array_.push(index);
    }
    return array_;
}
Vue.prototype.$textDescription = (text, limite) => {
    return text != null ? ((typeof limite == undefined || limite == null) ? text : `${String(text).substr(0, limite)} ...`) : '';
}
Vue.prototype.$date = new Date();

new Vue({
    mixins: [Admin],
});

//moment(_this5.vehicule[index].date_recuperation,moment.ISO_8601).toString()  => "2013-01-01T00:00:00-13:00"