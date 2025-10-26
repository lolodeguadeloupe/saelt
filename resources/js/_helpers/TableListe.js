import $ from 'jquery';
import '../_helpers/GenerateChar';
import { bouttonAction } from './ButtonAction';
import { Bibliotheque } from './BibloithequeLanguage';

export const is_action = { modifier: 1, supprimer: 2, detail: 3 }

export const TableListe = (function ($) {
    var _tableListe = function (dataTable = { data: [], colonne: [/*{id:null, value:null,icon:{head:null,id:null}}*/], pagination: { current_page: 1, last_page: 1 } }, event = { pagPrec: null, pagSuiv: null }, btnAction = null, tableClass = 'table table-condensed', css) {
        var self = this, bib_lang = new Bibliotheque();
        self.css('display', 'none')
        var col = function (attr = {}) {
            return $('<td/>', attr)
        }, row = function (attr = {}) {
            return $('<tr/>', attr)
        }, paginer = dataTable.pagination.current_page > 1 || (parseInt(dataTable.pagination.last_page) - parseInt(dataTable.pagination.current_page)) > 0
        var i = 0, table = $('<table/>', { 'class': tableClass + ' table-list', 'style': 'border-top: 4px solid #d2d6de !important;', 'table-id': $(this).GenerateChars(10) }), content = $('<tbody/>'), foot = $('<tfoot/>'), head = $('<thead/>'), _rowHead = new row(), headSet = false, notPaginate = true
        while (dataTable.data && dataTable.data[i]) {
            var _row = new row(notPaginate), k = 0
            while (dataTable.colonne[k] && typeof dataTable.colonne[k]['id'] !== 'undefined' && typeof dataTable.colonne[k]['value'] !== 'undefined') {
                var style = "";
                if (css && css[k])
                    style = css[k];
                if (typeof dataTable.data[i][dataTable.colonne[k]['id']] !== 'undefined') {
                    if (!headSet) {
                        _rowHead.append($('<th/>', { style: style }).html(
                            (dataTable.colonne[k].icon && dataTable.colonne[k].icon.head)
                                ?
                                '<i class="fa ' + dataTable.colonne[k].icon.head + '" style="float:left;"></i>' + dataTable.colonne[k]['value']
                                :
                                dataTable.colonne[k]['value']
                        ).clone(true));
                    }
                    _row.append(new col({ style: style }).html(dataTable.data[i][dataTable.colonne[k]['id']]).clone(true))
                }
                k++
            }
            var l = 0, _action = new col({ 'style': 'text-align:center;vertical-align: middle;' })
            if (!headSet && btnAction)
                _rowHead.append($('<th/>', { 'style': 'text-align:center;vertical-align: baseline;' }).html('Action').clone(true))
            headSet = true;

            while (btnAction && btnAction[l]) {
                _action.append(new bouttonAction(
                    {
                        class: btnAction[l].class || '',
                        title: btnAction[l].title || '',
                        action: btnAction[l].action,
                        session: { fnct: btnAction[l].callback, data: dataTable.data[i] },
                        callback: function (this_btn, action, callback) {
                            if (typeof callback.fnct === 'function')
                                callback.fnct.apply(this, [this_btn, _row, callback.data, action])
                        }
                    }
                ).clone(true))
                l++
            }
            if (l > 0)
                _row.append(_action.clone(true));
            if (dataTable.colonne[0] && dataTable.colonne[0].icon && dataTable.colonne[0].icon.id)
                $(_row).children().first().prepend('<i class="fa" style="float: left;"><img src="' + dataTable.data[i][dataTable.colonne[0].icon.id] + '" class="fa"/></i>');
            _row.appendTo(content)
            i++
        }
        if (i == 0)
            return self
        head.append(_rowHead.clone(true))
        if (paginer)
            foot.append(
                $('<tr/>').append(
                    $('<td/>',
                        {
                            'colspan': btnAction ? dataTable.colonne.length + 1 : dataTable.colonne.length
                        }
                    ).append(//dataTable.colonne
                        $('<ul/>',
                            {
                                'style': 'display: flex; padding-left: 0px;list-style: none; border-radius: .25rem;margin: 0px; float: right;'
                            }
                        ).append(
                            $('<li/>',
                                {
                                    'style': 'display:inline;'
                                }
                            ).append(
                                $('<a/>',
                                    {
                                        'class': dataTable.pagination.current_page > 1 ? 'clicable' : 'disabled',
                                        'href': '#',
                                        'style': 'position: relative;float: left;padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background: #fafafa;border: 1px solid #b0a7a7;margin-left: 0;border-top-left-radius: 4px;border-bottom-left-radius: 4px;'
                                    }
                                ).html(bib_lang.bibliotheque_key_['paginate_prec']).clone(true)
                            ).click(
                                function () {
                                    if (typeof event.pagPrec === 'function' && dataTable.pagination.current_page > 1) {
                                        event.pagPrec.call(this, table, $(this), parseInt(dataTable.pagination.current_page) - 1);
                                    }
                                }
                            ).clone(true)
                        ).append(
                            $('<li/>',
                                {
                                    'class': 'disabled', 'style': 'display:inline;'
                                }
                            ).append(
                                $('<a/>',
                                    {
                                        'class': (parseInt(dataTable.pagination.last_page) - parseInt(dataTable.pagination.current_page)) > 0 ? 'clicable' : 'disabled',
                                        'href': '#',
                                        'style': 'position: relative;float: left;padding: 6px 12px;margin-left: -1px;line-height: 1.42857143;color: #337ab7;text-decoration: none;background: #fafafa;border: 1px solid #b0a7a7;border-top-right-radius: 4px;border-bottom-right-radius: 4px;'
                                    }
                                ).html(bib_lang.bibliotheque_key_['paginate_suiv']).click(
                                    function () {
                                        if (typeof event.pagSuiv === 'function' && (parseInt(dataTable.pagination.last_page) - parseInt(dataTable.pagination.current_page)) > 0) {
                                            event.pagSuiv.call(this, table, $(this), parseInt(dataTable.pagination.current_page) + 1);
                                        }
                                    }
                                ).clone(true)
                            ).clone(true)
                        ).clone(true)
                    ).clone(true)
                ).clone(true)
            );
        //self.css('display', 'inline-block').html('').append(table.append(head.clone(true)).append(content.clone(true)).append(foot.clone(true)).clone(true));
        self.css('display', 'block').html('').append(table.append(head.clone(true)).append(content.clone(true)).append(foot.clone(true)).clone(true));
        return self;
    }
    return {
        init: function (selector) {
            var el = $(selector), _instance = function () {
                this.create = _tableListe.bind(this);
                return this;
            };
            if (el.length) {
                return _instance.apply($(el));
            }
            throw 'Invalide selecteur';
        }
    }
}($))