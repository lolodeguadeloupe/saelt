
export const MyCalandar = function (elem, options) {

    var _$ = function (selector, attr) {
        var self, _arrayMethode = function () {
            this.each = function (fn) {
                for (var i = 0; i < this.length; i++) {
                    fn.apply(this[i], this, i);
                }
                return this;
            }
            return this;
        }
        self = function () {
            this.attr = function (attrs) {
                for (var x in attrs) {
                    var y = document.createAttribute(x);
                    y.value = attrs[x];
                    this.setAttributeNode(y);
                }
                return this;
            }
            this.hasAttr = function (attr, value) {
                for (var i = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === attr) {
                        var reg = new RegExp('^' + value + '$|^' + value + '+\\s|\\s+' + value + '+\\s|\\s+' + value + '$');
                        if (reg.test(this.attributes[i].value))
                            return true;
                        else
                            return false;
                    }
                }
                return false;
            }
            this.appendFor = function (node) {
                this.append(node);
                return this;
            }
            this.html = function (string) {
                if (typeof string === 'undefined')
                    return this.innerHTML;
                this.innerHTML = string;
                return this;
            }
            this.addAttr = function (attrs) {
                for (var is in attrs) {
                    for (var i = 0; i < this.attributes.length; i++) {
                        if (this.attributes[i].name === is && !this.hasAttr(is, attrs[is])) {
                            this.attributes[i].value = this.attributes[i].value + ' ' + attrs[is];
                        }
                    }
                    if (i === 0) this.attr(attrs);
                }
                return this;
            }
            this.addClass = function (value) {
                for (var i = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === 'class' && !this.hasAttr('class', value)) {
                        this.attributes[i].value = this.attributes[i].value + ' ' + value;
                    }
                }
                if (i == 0) this.addAttr({ 'class': value });
                return this;
            }
            this.removeClass = function (value) {
                for (var i = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === 'class') {
                        this.attributes[i].value = this.attributes[i].value.replace(new RegExp('^' + value + '$|^' + value + '+\\s|\\s+' + value + '+\\s|\\s+' + value + '$'), ' ');
                    }
                }
                return this;
            }
            this.parent = function () {
                return self.apply(this.parentElement);
            }
            this.parents = function (selector) {
                var cl = selector.split('.'), id = selector.split('#'), parent = this.parentElement, is = true
                do {
                    parent = self.apply(parent);
                    is = cl.length
                        ?
                        (parent.nodeName === cl[0].toUpperCase() && parent.hasAttr('class', cl[1]))
                        :
                        (
                            id.length
                                ?
                                (parent.nodeName === cl[0].toUpperCase() && parent.hasAttr('id', cl[1]))
                                :
                                parent.nodeName === selector.toUpperCase()
                        );
                    parent = parent.parentElement;

                } while (!is && parent.nodeName !== 'HTML');
                return parent;
            }
            this.find = function (find) {
                var all = this.querySelectorAll(find);
                return _arrayMethode.apply(all);
            }
            return this;
        };
        var instance;
        if (typeof selector === 'string' && /^<+([a-zA-Z]*)+\/>/g.test(selector)) {
            try {
                selector = selector.replace(/^<+(?<string>([a-zA-Z]*))+\/>/g, '$<string>');
                selector = document.createElement(selector);
                instance = self.apply(selector);
            } catch (error) {
                throw error;
            }
        }
        else if (typeof selector === "string") {
            selector = document.querySelectorAll(selector);
            instance = _arrayMethode.apply(selector);
        }
        else if (typeof selector === 'object') {
            instance = self.apply(selector);
        }

        return instance.attr(attr);;

    }

    var Moment = function () {

        var thisMoment = function () {
            var _d = new Date(),
                _ref = new Date(_d.getFullYear(), _d.getMonth(), 1),
                _sec = 1000,
                _min = _sec * 60,
                _heure = _min * 60,
                _jour = _heure * 24,
                _nbSec = 1,
                _nbMin = 1,
                _nbHeures = 1,
                _nbJours = 1;
            _ref.setHours(0, 0, 0, 0);

            this.date = _ref;
            this.getDay = function (year, month, date) {
                var parse = new Date(year, month);
                parse.setDate(date);
                return parse.getDay();
            }
            this.setTime = function (time) { this.date.setTime(time); return this };
            this.setDate = function (date) { this.date.setDate(date); return this };
            this.setMonth = function (month) { this.date.setMonth(month); return this };
            this.setYear = function (year) { this.date.setFullYear(year); return this };
            this.init = function (init) {
                if (typeof init !== 'undefined' && typeof init === 'object') {
                    _ref = init.year ? _ref.setFullYear(init.year) : _ref;
                    _nbSec = init.sec ? init.sec : _nbSec;
                    _nbMin = init.min ? init.min * _min : _nbMin;
                    _nbHeures = init.heures ? init.heures * _heure : _nbHeures;
                    _nbJours = init.jours ? init.jours * _jour : _nbJours;
                    _ref.setTime(_ref.getTime() + (_nbSec * _nbMin * _nbHeures * _nbJours))
                }
                return this;
            }
            return this;
        }

        var instance = {}
        return thisMoment.apply(instance);

    }

    var calendar = function () {
        var isDate = new Date(), isMonth = isDate.getMonth(), firsrtDay = 0, dateCalandar = Moment();
        var nexCalendar = function (date) {
            this.now.setMonth(this.now.date.getMonth() + 1);
            if (typeof date != 'undefined') {
                this.calendar = {
                    date: date,
                    month: this.now.date.getMonth(),
                    year: this.now.date.getFullYear()
                }
                var { year, month, date } = this.calendar;
                this.calendar['day'] = Moment().getDay(year, month, date);
            }
            this.getCalendar();
            console.log('next', this);
        }

        var prevCalendar = function (date) {
            this.now.setMonth(this.now.date.getMonth() - 1);
            if (typeof date != 'undefined') {
                this.calendar = {
                    date: date,
                    month: this.now.date.getMonth(),
                    year: this.now.date.getFullYear()
                }
                var { year, month, date } = this.calendar;
                this.calendar['day'] = Moment().getDay(year, month, date);
            }
            this.getCalendar();
            console.log('prev', this);
        }

        this.now = Moment().setMonth(isMonth);
        this.month = options && options.month ? options.month : ['Janvier', 'Février', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Août', 'Séptembre', 'Octobre', 'Novembre', 'Décembre'];
        this.weekHead = options && options.week ? options.week : ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        this.generate = function () {
            firsrtDay = this.now.date.getDay();
            dateCalandar = firsrtDay === 0
                ?
                Moment().setTime(this.now.date.getTime()).init({ jours: -7 })
                :
                Moment().setTime(this.now.date.getTime()).init({ jours: -(firsrtDay - 1) });
        }

        this.calendar = {};
        this.empile = function (selector) {
            var parent = this;
            var self = function () {
                this.push = function (nbWeek, week) {
                    for (var nbDays = nbWeek + 1; nbDays <= 7 + nbWeek; nbDays++) {
                        var days = _$('<td/>').html(dateCalandar.date.getDate());
                        if (dateCalandar.date.getFullYear() == parent.calendar.year && dateCalandar.date.getMonth() == parent.calendar.month && parent.calendar.date == dateCalandar.date.getDate())
                            days.addClass('selected-calendar');
                        if (dateCalandar.date.getFullYear() == isDate.getFullYear() && dateCalandar.date.getMonth() == isDate.getMonth() && dateCalandar.date.getDate() == isDate.getDate())
                            days.addClass('date-now-calendar');
                        if (parent.now.date.getMonth() === dateCalandar.date.getMonth()) {
                            days.addAttr({ class: 'active' }).addEventListener('click', function () {
                                _$(this).parents('table.table-calandar').find('td').each(function () {
                                    _$(this).removeClass('selected-calendar');
                                })
                                _$(this).addClass('selected-calendar');
                                parent.calendar = {
                                    date: _$(this).html(),
                                    month: parent.now.date.getMonth(),
                                    year: parent.now.date.getFullYear()
                                }
                                var { year, month, date } = parent.calendar;
                                parent.calendar['day'] = Moment().getDay(year, month, date);
                            })
                        } else if (parent.now.date.getMonth() > dateCalandar.date.getMonth()) {
                            days.addAttr({ class: 'disable' }).addEventListener('click', function () {
                                prevCalendar.apply(parent, [_$(this).html()]);
                            })
                        } else {
                            days.addAttr({ class: 'disable' }).addEventListener('click', function () {
                                nexCalendar.apply(parent, [_$(this).html()]);
                            })
                        }
                        //class: parent.now.date.getMonth() === dateCalandar.date.getMonth() ? 'active' : 'disable'
                        _$(week).appendFor(days);
                        _$(this).appendFor(week);
                        dateCalandar.setDate(dateCalandar.date.getDate() + 1)
                    }
                    return nbDays;
                }

                return this;
            };

            return self.apply(selector);
        }
        this.head = function (selector) {
            var parent = this;
            var head = _$('<thead/>'),
                btnPrev = _$('<th/>').appendFor(_$('<button/>').html("<<")),
                btnNex = _$('<th/>').appendFor(_$('<button/>').html(">>")),
                tr = _$('<tr/>')
                    .appendFor(btnPrev)
                    .appendFor(_$('<th/>', { colspan: '5' })
                        .html(this.month[this.now.date.getMonth()] + ' <b>' + this.now.date.getFullYear() + '</b>'))
                    .appendFor(btnNex);
            _$(head).appendFor(tr);
            btnNex.addEventListener('click', function () {
                nexCalendar.apply(parent);
            });
            btnPrev.addEventListener('click', function () {
                prevCalendar.apply(parent);
            });
            tr = _$('<tr/>', { class: 'table-calandar-month' });

            for (var x in this.weekHead) {
                tr.appendFor(_$('<th/>', { title: this.weekHead[x] }).html(this.weekHead[x].substring(0, 3)));
            }
            _$(head).appendFor(tr);
            _$(selector).appendFor(head);
            return selector;
        }

        this.getCalendar = function () {
            this.generate();
            var body = _$('<tbody/>'), table = _$('<table/>', {
                class: 'table-calandar'
            }), nbWeek = 0;
            this.head(table);
            while (nbWeek < 42) {
                var week = _$('<tr/>');
                nbWeek = this.empile(body).push(nbWeek, week) - 1;
            }

            table.appendFor(body);
            elem.innerHTML = "";
            _$(elem).appendFor(table);
            return this;
        }
        return this;

    }

    // element DOM Create

    var objCalendar = {};
    calendar.apply(objCalendar);
    objCalendar.getCalendar();
    return elem;


}