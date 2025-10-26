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
import { Front } from './my-template-front';
import './index';
//JS
import VueTimepicker from 'vue2-timepicker';
// CSS
import 'vue2-timepicker/dist/VueTimepicker.css'
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
                'week_list': ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                'short_month': ['Janv.', 'Fev.', 'Mars', 'Avr.', 'May', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                'btn_save': 'Save',
                /* champ front */
                'info_form_incomplete_title': 'Champs obligatoires',
                'info_form_incomplete': 'Veuillez renseigner tous les champs obligatoires',
                'info_form_incomplete_btn_confirm': 'Ok',
                'commande_produit_succes_title': 'Réservation ajoutée',
                'commande_produit_succes': 'Découvrez toutes nos prestations en cliquant sur le bouton « Continuez vos achats »',
                'commande_produit_succes_btn_ok': 'Ok',
                'commande_produit_btn_continuer_achat': 'Continuez vos achats',
                'commande_produit_btn_passer_commande': 'Passez votre commande',
                'commande_produit_billeterie_heure_invalid': `L'heure de la réservation est obligatoire`,
                'reserver_billetterie': `Réservez billetterie`,
                'reserver_location': `Réservez location`,
                'commande_produit_suivre_achat': 'Continuez',
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
                'file_size': 'Une erreur sur la taille de l\'image',
                'select_error': 'Veuillez valider le champ',
                'btn_new_autocomplete': 'Créer nouveau element ...',
                'new_event_calendar': 'Nouvel événement ...',
                'status_calendar_passe': 'Passé',
                'status_calendar_active': 'Activé',
                'status_calendar_desactive': 'Desactivé',
                'no_image_avaible': 'Pas d\'image disponible',
                'week_list': ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'],
                'short_month': ['Janv.', 'Fev.', 'Mars', 'Avr.', 'May', 'Juin', 'Juil.', 'Août', 'Sept.', 'Oct.', 'Nov.', 'Déc.'],
                'btn_save': 'Enregistrer',
                /* champ front */
                'info_form_incomplete_title': 'Champs obligatoires',
                'info_form_incomplete': 'Veuillez renseigner tous les champs obligatoires',
                'info_form_incomplete_btn_confirm': 'Ok',
                'commande_produit_succes_title': 'Réservation ajoutée',
                'commande_produit_succes': 'Découvrez toutes nos prestations en cliquant sur le bouton «Continuez vos achats»',
                'commande_produit_succes_btn_ok': 'Ok',
                'commande_produit_btn_continuer_achat': 'Continuez vos achats',
                'commande_produit_btn_passer_commande': 'Passez votre commande',
                'commande_produit_billeterie_heure_invalid': `L'heure de la réservation est obligatoire`,
                'reserver_billetterie': `Réservez billetterie`,
                'reserver_location': `Réservez location`,
                'commande_produit_suivre_achat': 'Continuez',
                'error_occured_btn_confirm': 'Fermer',
                'produit_commande_non_dispo_titre': 'Rupture de stock',
                'produit_commande_non_dispo_msg': 'Ce produit n\'est plus en stock'
            };
    }
}

Vue.component('multiselect', Multiselect);
Vue.component('vue-timepicker', VueTimepicker);
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
Vue.prototype.$getPositionString = (string, start, length = null) => {
    return String(string).substr(start, length ? length : String(string).length);
}
Vue.prototype.$grouperArray = (arr = [], groupe = 1) => {
    var count = 0;
    var new_array = [];
    while (count < arr.length) {
        var pus_arr = [];
        for (let index = count; index < count + groupe && arr[index] != undefined; index++) {
            pus_arr = [...pus_arr, arr[index]];
        }
        new_array = [...new_array, pus_arr];
        count = count + groupe;
    }
    return new_array;
}

Vue.prototype.$grouperArrayRepet = (arr = [], groupe = 1) => {
    var count = 0;
    var new_array = [];
    while (count < arr.length) {
        var pus_arr = [];
        for (let index = count; index < count + groupe; index++) {
            if (arr[index] == undefined) {
                var prev_index = index - arr.length;
                while (arr[prev_index] == undefined) {
                    prev_index--;
                }
                pus_arr = [...pus_arr, arr[prev_index]];
            } else {
                pus_arr = [...pus_arr, arr[index]];
            }
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

Vue.directive('autocompletion', {
    inserted: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding;
        /*{autocompletion, ="value", ="<expression>", v-autocompletion:<arg>,v-autocompletion:arg.<modifiers>.<modifiers>...}*/
        var s = JSON.stringify;
        var options = typeof value == 'function' ? value() : {};
        var defaultOption = { attrs: { action: '', autokey: '', label: '', ...vnode.data.attrs }, ajax: null, dataRequest: {}, fnSelectItem: null, detailInfo: [], formateDetailInfo: null, fnBtnNew: null, frame: null };
        defaultOption.attrs = { inputlabel: null, inputkey: null, ...defaultOption.attrs }
        options = { ...defaultOption, ...options, dict: Vue.prototype.$dictionnaire };
        MyAutocomplete(el).readed(options)
    }
})

Vue.directive('parsehtml', {
    inserted: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding, options = { ...vnode.data.attrs };
        $(el).html('');
        $(value).appendTo($(el));
    },
    update: function (el, binding, vnode) {
        var { name, value, expression, arg, modifiers } = binding, options = { ...vnode.data.attrs };
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
    return array_.map(function (data) {
        return data[key];
    });
}

Vue.prototype.$toJson = (data) => {
    return JSON.stringify(data);
}

Vue.prototype.$loading = () => {
    var elm = null;
    $('.loading-front').each(function () {
        elm = this;
        $(this).css({ display: 'flex', 'background-color': 'transparent' });
    });
    return {
        remove: function () {
            if (elm) {
                $(elm).css({ display: 'none' });
            }
        }
    }
}

Vue.prototype.$countEtoil = (etoil) => {
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
    return text != null ? ((typeof limite == undefined || limite == null) ? text : `${String(text).substr(0, limite)} ...`) : '';
}

Vue.prototype.$isNumber = (val) => {
    return String(val).trim() != '' && !isNaN(val);
}

Vue.prototype.$setDefaultValue = (event) => {
    $(event.target).each(function () {
        $(this).val((String($(this).val()).trim() != '' && !isNaN(String($(this).val()))) ? $(this).val() : $(this).attr('data-oldValue'));
    });
}

Vue.prototype.$forceParseDate = (date) => {
    moment(date).set({ 'hour': 0, 'minute': 0, 'seconde': 0, 'millisecond': 0 }).format('DD/MM/YYYY');
}

Vue.prototype.$stringIncludesArray = (array = [], val) => {
    return array.includes(String(val));
}
Vue.prototype.$parseDate = (date, parse = true) => {
    const d = new Date(date);
    if (parse == false) return d;
    d.setHours(d.getHours() + (d.getTimezoneOffset() / 60))
    return d;
}

Vue.prototype.$getArrayDateString = (arr = []) => {
    return arr.map(date => moment(date).format('DD/MM/YYYY')).join(' ,');
}

Vue.prototype.$initTime = (date, parse = false) => {
    return moment(date).set({
        'hour': 0,
        'minute': 0,
        'seconde': 0,
        'millisecond': 0
    });
}

Vue.prototype.$maxDate = (date1, date2) => {
    return moment(date2).diff(moment(date1)) >= 0 ? date2 : date1;
}

Vue.prototype.$plusDays = (date, days = 1) => {
    return moment(date).day(moment(date).day() + days).toDate();
}

Vue.prototype.$plusYears = (date, year = 1) => {
    return moment(date).year(moment(date).year() + year).toDate();
}

Vue.prototype.$multiplication = (...val) => {
    var result = 1;
    val.map(function (_val) {
        result = parseFloat(parseFloat(result) * parseFloat(_val)).toFixed(2);
    })
    return parseFloat(result);
}

Vue.prototype.$formatDateString = (date = "", parse = false) => {
    const d = new Date(date);
    if (parse) {
        d.setHours(d.getHours() + (d.getTimezoneOffset() / 60));
    }
    return `${String(`0${d.getDate()}`).substr(-2)} ${dict('fr').short_month[d.getMonth()]} ${d.getFullYear()}`;
}

Vue.prototype.$while = (nb, debut = 1) => {
    const arr = [];
    for (var i = debut; i <= nb; i++) {
        arr.push(i);
    }
    return arr;
}
Vue.prototype.$parseDateToString = function (date, parse = false) {
    if (date == '') return '';
    const d = new Date(date);
    if (parse) {
        d.setHours(d.getHours() + (d.getTimezoneOffset() / 60));
    }
    return moment(date).format('YYYY-MM-DD');
}

Vue.prototype.$espaceUnite = function (val) {
    const new_val = `0000000000000${val}`;
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

Vue.prototype.$isEmpty = function (obj) {
    var count = 0;
    var count_fn = (_obs) => {
        var count_ = 0;
        for (var k in _obs) {
            count_++;
        }
        return count_;
    }
    if (obj == null) return true;
    for (var k in obj) {
        if (typeof obj[k] == 'object') {
            count += count_fn(obj[k]);
        } else if (typeof obj[k] == 'function') {
            count++;
        }
    }
    return count == 0;
}

Vue.prototype.$isBase64 = function (image) {
    return String(image).match(/^data:/) != null && String(image).match(/;base64,/) != null;
}

Vue.prototype.$parseFloat = function (val) {
    return parseFloat(val).toFixed(2);
}

Vue.prototype.$promise = function (callback, time = 60) {
    setTimeout(callback, time);
}

Vue.prototype.$availability = function ($string) {
    if ($string == null || String($string).trim() == '') {
        return [];
    }
    return String($string).split(',');
}

Vue.prototype.$loadingText = (text = "recherche en cours") => {
    const _id_loading = `loading-${Math.random().toString(16).substr(2, 8)}-text`;
    var css_loading = `.content-${_id_loading}{width:100%;height:100%;position:absolute;top:0;display:flex;align-items:center;justify-content:center;font-size:30px;background:#858383bf;z-index:5;}#${_id_loading}{width:45%;position:fixed;display:flex;flex-direction:column;top:50vh;}#${_id_loading} .circle{width:20px;height:20px;position:absolute;border-radius:50%;background-color:#fff;left:15%;transform-origin:50%;animation:circle .5s alternate infinite ease;}`;
    css_loading += `@keyframes circle{0%{top:60px;height:5px;border-radius:50px 50px 25px 25px;transform:scaleX(1.7)}40%{height:20px;border-radius:50%;transform:scaleX(1)}100%{top:0}}`;
    css_loading += `#${_id_loading} .circle:nth-child(2){left:45%;animation-delay:.2s}#${_id_loading} .circle:nth-child(3){left:auto;right:15%;animation-delay:.3s}#${_id_loading} .shadow{width:20px;height:4px;border-radius:50%;background-color:rgba(0,0,0,.5);position:absolute;top:62px;transform-origin:50%;z-index:-1;left:15%;filter:blur(1px);animation:shadow .5s alternate infinite ease}`;
    css_loading += `@keyframes shadow{0%{transform:scaleX(1.5)}40%{transform:scaleX(1);opacity:.7}100%{transform:scaleX(.2);opacity:.4}}`;
    css_loading += `#${_id_loading} .shadow:nth-child(4){left:45%;animation-delay:.2s}#${_id_loading} .shadow:nth-child(5){left:auto;right:15%;animation-delay:.3s}#${_id_loading} span{font-family:Lato;font-size:32px;letter-spacing:7px;color:#fff;margin-top:10%;display:block;text-align:center;width:100%;user-select: none;}`;
    var content = null;
    $('body').each(function () {
        const loading = $('<div/>').attr({ id: _id_loading });
        const element = [
            $('<div/>').append(
                $('<div/>').attr({ class: 'circle' }),
                $('<div/>').attr({ class: 'circle' }),
                $('<div/>').attr({ class: 'circle' }),
                $('<div/>').attr({ class: 'shadow' }),
                $('<div/>').attr({ class: 'shadow' }),
                $('<div/>').attr({ class: 'shadow' }),
            ),
            $('<span/>').html(text)
        ];
        loading.append(element);
        content = $('<div/>').attr({ class: `content-${_id_loading}` }).append(loading).appendTo($(this));
        $(this).css({ position: 'relative' });
        $('<style/>').html(css_loading).appendTo($('head'));
    });
    return {
        delete: function () {
            if (content) {
                $(content).each(function () {
                    $(this).remove();
                })
            }
        },
        self: content,
    }
}

Vue.prototype.$detailImage = (self, url, position) => {
    // @mouseleave="$emit('close')"
    self.$modal.show({
        template: `
            <div class="card text-center">
                <div class="card-body p-0 m-0">
                <img src="${url}" class="img-fluid w-100" >
                </div>
            </div>
      `,
        props: []
    }, {

    }, {
        height: 'auto',
        style: 'background-color:#00000075;',
        clickToClose: true,
        classes: "detail-image-modal-show",
        styles: '',
        draggable: true,
    }, {
        'before-open': e => {

        },
        'before-close': e => {

        },
        'opened': e => {
            $(e.ref).each(function () {
                //console.log($(this).css('left'))
                //console.log(window.innerWidth)
                //console.log(window.innerHeight)
                //console.log(position)
                //$(this).css({ left: (parseInt(position.x) + parseInt(e.ref.clientWidth)), top: (parseInt(position.y) + parseInt(e.ref.clientHeight)) });
            })
        }
    });
}

new Vue({
    mixins: [Front]
});