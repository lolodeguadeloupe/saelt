
export const CalendarNote = function (options) {
    var generateChars = function (length) {
        var chars = '';
        for (var i = 0; i < length; i++) {
            var randomChar = Math.floor(Math.random() * 36);
            chars += randomChar.toString(36);
        }
        return chars;
    }

    var sortArray = function (fn) {
        for (var i = 0, y = 0; i < this.length; i++) {
            y = i + 1;
            while (y < this.length) {
                if (!fn.apply(this, [this[i], this[y]])) {
                    var s = this[i];
                    this[i] = this[y];
                    this[y] = s;
                }
                y++;
            }
        }
        return this;
    }
    var Moment = function (_date) {
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
            if (_date) _ref.setTime(_date.getTime());
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
            this.getString = function (format) {
                format = format.replace(/-|\/|\s/g, " ");
                var format = format.split(" "), string = '', reg_Y = /^Y|y/g, reg_M = /^M|m/g;
                for (var i = 0; i < format.length; i++) {
                    if (reg_Y.test(String(format[i])))
                        string += this.date.getFullYear();
                    else if (reg_M.test(format[i]))
                        string += ('0' + (this.date.getMonth() + 1)).substr(-2);
                    else
                        string += ('0' + this.date.getDate()).substr(-2);
                    string += (i < (format.length - 1)) ? '-' : '';
                }
                return string;

            }
            this.parseDateToString = function (date, string = 'y-m-d') {
                var _parse = new Moment(this.date);
                _parse.setDate(date);
                return _parse.getString(string);
            }
            //year
            this.equalsYear = function (moment) {
                return this.date.getFullYear() === moment.date.getFullYear();
            }
            this.beforOrEqualsYear = function (moment) {
                return this.date.getFullYear() >= moment.date.getFullYear();
            }
            this.beforYear = function (moment) {
                return this.date.getFullYear() > moment.date.getFullYear();
            }
            this.lastOrEqualsYear = function (moment) {
                return this.date.getFullYear() <= moment.date.getFullYear();
            }
            this.lastYear = function (moment) {
                return this.date.getFullYear() < moment.date.getFullYear();
            }
            //month
            this.equalsMonth = function (moment) {
                return this.equalsYear(moment) && this.date.getMonth() === moment.date.getMonth();
            }
            this.beforOrEqualsMonth = function (moment) {
                return (this.equalsYear(moment) && this.date.getMonth() >= moment.date.getMonth()) || this.beforYear(moment);
            }
            this.beforMonth = function (moment) {
                return (this.equalsYear(moment) && this.date.getMonth() > moment.date.getMonth()) || this.beforYear(moment);
            }
            this.lastOrEqualsMonth = function (moment) {
                return (this.equalsYear(moment) && this.date.getMonth() <= moment.date.getMonth()) || this.beforYear(moment);
            }
            this.lastMonth = function (moment) {
                return (this.equalsYear(moment) && this.date.getMonth() < moment.date.getMonth()) || this.beforYear(moment);
            }
            //time
            this.beforTime = function (moment) {
                return this.date.getTime() > moment.date.getTime;
            }
            this.lastTime = function (moment) {
                return this.date.getTime() < moment.date.getTime();
            }
            //date
            this.equalsDate = function (moment) {
                return this.equalsMonth(moment) && this.date.getDate() === moment.date.getDate();
            }
            this.beforOrEqualsDate = function (moment) {
                return this.beforMonth(moment)
                    || (this.equalsMonth(moment) && this.date.getDate() >= moment.date.getDate());
            }
            this.beforDate = function (moment) {
                return this.beforMonth(moment)
                    || (this.equalsMonth(moment) && this.date.getDate() > moment.date.getDate());
            }
            this.lastOrEqualsDate = function (moment) {
                return this.lastMonth(moment)
                    || (this.equalsMonth(moment) && this.date.getDate() <= moment.date.getDate());
            }
            this.lastDate = function (moment) {
                return this.lastMonth(moment)
                    || (this.equalsMonth(moment) && this.date.getDate() < moment.date.getDate());
            }
            return this;
        }

        var instance = {}
        return thisMoment.apply(instance);

    }, _$ = function (selector, attr) {
        var self, _arrayMethode = function () {
            this.each = function (fn) {
                for (var i = 0; i < this.length; i++) {
                    fn.apply(this[i], this, i);
                }
                return this;
            }
            return this;
        }, styleMethode = function () {
            this.position = function () {
                var position = this.getBoundingClientRect(), newPos = {};
                for (var _x in position)
                    newPos[_x] = parseFloat(position[_x]).toFixed(3);
                return newPos;
            }
            this.outerHeight = function () {
                return this.offsetHeight;
            }
            this.outerWidth = function () {
                return this.offsetWidth;
            }
            this.positionInner = function () {
                var m_left = this.style.marginLeft ? this.style.marginLeft : 0,
                    m_rigth = this.style.marginRight ? this.style.marginRight : 0,
                    m_top = this.style.marginTop ? this.style.marginTop : 0,
                    m_bottom = this.style.marginBottom ? this.style.marginBottom : 0,
                    p_left = this.style.paddingLeft ? this.style.paddingLeft : 0,
                    p_right = this.style.paddingRight ? this.style.paddingRight : 0,
                    p_top = this.style.paddingTop ? this.style.paddingTop : 0,
                    p_bottom = this.style.paddingBottom ? this.style.paddingBottom : 0;

                return {
                    height: parseFloat(this.offsetHeight) - (parseFloat(m_top) + parseFloat(m_bottom)),
                    width: parseFloat(this.offsetWidth) - (parseFloat(m_left) + parseFloat(m_rigth)),
                    marginLeft: m_left,
                    marginRight: m_rigth,
                    marginTop: m_top,
                    marginBottom: m_bottom,
                    paddingLeft: p_left,
                    paddingRight: p_right,
                    paddingTop: p_top,
                    paddingBottom: p_bottom
                }
            }
            return this;
        }
        self = function () {
            this.attr = function (attrs) {
                if (typeof attrs === 'string') {
                    for (var i = 0; i < this.attributes.length; i++) {
                        if (this.attributes[i].name === attrs) {
                            return this.attributes[i].value;
                        }
                    }
                    return '';
                }
                for (var x in attrs) {
                    var y = document.createAttribute(x);
                    y.value = attrs[x];
                    this.setAttributeNode(y);
                }
                return this;
            }
            this.css = function (styles) {
                var newStyle = '';
                for (var isStyle in styles) {
                    newStyle += isStyle + ':' + (String(styles[isStyle]).trim() === '' ? '""' : styles[isStyle]) + ';';
                }

                for (var i = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === 'style') {
                        newStyle += this.attributes[i].value + '; ' + newStyle;
                    }
                }
                this.attr({ style: newStyle });
                return this;
            }
            this.cssBefore = function (styles) {
                var _class = generateChars(7), style = _$('<style/>', { class: _class }), string = '';
                for (var isStyle in styles) {
                    string += isStyle + ':' + (String(styles[isStyle]).trim() === '' ? '""' : styles[isStyle]) + ';';
                }
                this.addClass(_class);
                style.innerHTML = "." + _class + "::before{" + string + "}";
                document.head.append(style);
                return this;
            }
            this.cssAfter = function (styles) {
                var _class = generateChars(7), style = _$('<style/>', { class: _class }), string = '';
                for (var isStyle in styles) {
                    string += isStyle + ':' + (String(styles[isStyle]).trim() === '' ? '""' : styles[isStyle]) + ';';
                }
                this.addClass(_class);
                style.innerHTML = "." + _class + "::after{" + string + "}";
                document.head.append(style);
                return this;
            }
            this.hasAttr = function (attr, value) {
                if (typeof value === 'undefined' || value.trim() === '')
                    return false;
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
            this.text = this.text || function (string) {
                if (typeof string === 'undefined' && this.childNodes[0] && this.childNodes[0].data) {
                    return this.childNodes[0].data;
                } else if (typeof string === 'undefined')
                    return this.innerText;
                this.innerText = string;
                return this;
            }
            this.addAttr = function (attrs) {
                for (var is in attrs) {
                    for (var i = 0, k = 0; i < this.attributes.length; i++) {
                        if (this.attributes[i].name === is && !this.hasAttr(is, attrs[is])) {
                            this.attributes[i].value = this.attributes[i].value + ' ' + attrs[is];
                            k++;
                        }
                    }
                    if (!k) this.attr(attrs);
                }
                return this;
            }
            this.removeAttr = function (attr, value) {
                for (var i = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === attr) {
                        if (typeof value === 'string')
                            this.attributes[i].value = this.attributes[i].value.replace(new RegExp('^' + value + '$|^' + value + '+\\s|\\s+' + value + '+\\s|\\s+' + value + '$'), ' ');
                        else delete this.attributes[i];
                    }
                }
                return this;
            }
            this.addClass = function (value) {//classList.add("mystyle",...) //has=> contains(class) remove =>remove(class1, class2, ...) toggle =>toggle(class, true|false)
                for (var i = 0, k = 0; i < this.attributes.length; i++) {
                    if (this.attributes[i].name === 'class' && !this.hasAttr('class', value)) {
                        this.attributes[i].value = this.attributes[i].value + ' ' + value;
                        k++;
                    }
                }
                if (!k) this.addAttr({ 'class': value });
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
                    is = cl.length > 1
                        ?
                        (parent.nodeName === cl[0].toUpperCase() && parent.hasAttr('class', cl[1]))
                        :
                        (
                            id.length > 1
                                ?
                                (parent.nodeName === cl[0].toUpperCase() && parent.hasAttr('id', cl[1]))
                                :
                                parent.nodeName === selector.toUpperCase()
                        );
                    if (!is) parent = parent.parentElement;

                } while (!is && parent.nodeName !== 'HTML');
                return parent;
            }
            this.childrens = function () {
                return _arrayMethode.apply(this.children);
            }
            this.find = function (find) {
                var all = this.querySelectorAll(find);
                return _arrayMethode.apply(all);
            }
            this.is = function (element) {
                return this.isEqualNode(element) && this === element;
            }
            this.remove = function () {
                this.parent().removeChild(this);
            }
            this.replace = function (replace) {
                var attrs = {};
                for (var i = 0; i < this.attributes.length; i++) {
                    attrs[this.attributes[i].name] = this.attributes[i].value;
                    replace.attr(attrs);
                }
                for (var child = 0; child < this.childNodes.length; child++) {
                    for (var event_ in this.childNodes[child].cloneNode(true))
                        console.log(event_, this.childNodes[child].cloneNode(true)[event_])
                    replace.appendChild(this.childNodes[child].cloneNode(true));
                }
                this.parent().replaceChild(replace, this);

            }
            this.addTitle = function (title) {
                var el = this;
                if (this.hasAttr('title-old') && !this.hasAttr('title_'))
                    return this
                if (!_$(this).hasAttr('_title') || this.hasAttr('title_'))
                    this.addEventListener('mouseenter', function (event) {
                        if (!this.is(event.target)) return;
                        var _title_ = title || _$(this).attr('_title')
                        this.addAttr({ 'title-old': _title_ })
                        var _sess_ = 'info-title-' + new Date().getTime()
                        this.removeAttr('_title')
                        var x = this.position()
                        var _this_ = _$("<span/>", {
                            'class': '_title ',
                            'sess-actif': _sess_
                        }).html(_title_).cssAfter({
                            'content': '',
                            'position': 'absolute',
                            'top': '10px',
                            'left': '20%',
                            'margin-top': '-22px',
                            'border-width': '5px',
                            'border-style': 'solid',
                            'border-color': 'transparent transparent #212529 transparent'
                        }).css({
                            'visibility': 'hidden',
                            'width': ' max-content',
                            'max-width': '220px',
                            'top': '-5px',
                            'right': '20px',
                            'background-color': 'rgb(248, 250, 252)',
                            'color': '#333',
                            'border': '1px solid #212529',
                            'text-align': 'left',
                            'padding': '5px 10px',
                            'border-radius': '6px',
                            'position': 'absolute',
                            'z-index': '1',
                            'transition': 'opacity 1s ease 0s'
                        });
                        _this_.css({
                            'visibility': 'visible',
                            'z-index': '100000',
                            'right': 'unset',
                            'top': (parseInt(event.pageY) - (parseInt(_this_.outerHeight()) / 2)) + 10 + 'px',
                            'left': parseInt(event.pageX) - (parseInt(_this_.outerWidth()) + 36) + 'px'
                        })
                        _$('body').each(function () {
                            _$(this).appendFor(_this_)
                        });
                        //console.log(event.clientY,event.pageY,Math.round($(window).scrollTop()))
                        this.addEventListener('mouseleave', function () {
                            _$("[sess-actif='" + _sess_ + "']").each(function () {
                                var _clssRef = this.attr('class'), _arrCls = _clssRef.split(' ');
                                for (var i = 0; i < _arrCls.length; i++) {
                                    _$('head').each(function () {
                                        _$(this).childrens().each(function () {
                                            //classList.add("mystyle",...) //has=> contains(class) remove =>remove(class1, class2, ...) toggle =>toggle(class, true|false)
                                            if (this.classList.contains(_arrCls[i])) this.remove();
                                        })
                                    })
                                }
                                this.remove();
                            });

                            _$("[sess-actif^='info-title-']").each(function () {
                                var _clssRef = this.attr('class'), _arrCls = _clssRef.split(' ');
                                for (var i = 0; i < _arrCls.length; i++) {
                                    _$('head').each(function () {
                                        _$(this).childrens().each(function () {
                                            if (this.classList.contains(_arrCls[i])) this.remove();
                                        })
                                    })
                                }
                                this.remove()
                            })
                            if (_$(this).hasAttr('title-old')) {
                                _$(this).attr('_title', _$(this).attr('title-old'))
                                _$(this).removeAttr('title-old')
                            }
                        })
                    }
                    )
                return el
            }
            return styleMethode.apply(this);
        };
        var instance;
        if (typeof selector === 'string' && /^<+([a-zA-Z]*)+\/>/g.test(selector)) {
            try {
                selector = selector.replace(/^<+(?<string>([a-zA-Z]*))+\/>/g, '$<string>');
                selector = document.createElement(selector);
                instance = self.apply(selector);
                instance.attr(attr);
            } catch (error) {
                throw error;
            }
        }
        else if (typeof selector === "string") {
            selector = document.querySelectorAll(selector) || document.getElementsByTagName(selector);
            instance = _arrayMethode.apply(selector);
        }
        else if (typeof selector === 'object') {
            instance = self.apply(selector);
            instance.attr(attr);
        }

        return instance;

    },
        Loading = function () {
            var _l = 'load-' + generateChars(4), self = _$(this);
            if (!self) return null;
            var frame = _$('<div/>').attr({
                'loading': _l
            }).css({
                'position': 'absolute',
                'text-align': 'center',
                'margin-top': (-1 * parseInt(self.outerHeight())) - 2 + 'px',
                'left': 'unset',
                'width': self.outerWidth() + 'px',
                'height': parseInt(self.outerHeight()) + 2 + 'px',
                'background-color': 'rgba(134, 139, 144, 0)' /*'#868b90bd'*/,
                'z-index': 999
            }).appendFor(
                _$('<i/>').attr({
                    'class': 'fa fa-spinner',
                    //'loading': _l
                }).css({
                    'position': 'relative',
                    'margin-top': (((parseInt(_$(this).outerHeight()) - 22) / 2) < 0 ? 0 : ((parseInt(_$(this).outerHeight()) - 22) / 2)) + 'px',
                    'color': 'rgb(36, 216, 83)',
                    'font-size': '22px',
                    '-webkit-animation': 'fa-spin 2s infinite linear',
                    'animation': 'fa-spin 2s infinite linear'
                }
                ));

            this.parent().appendFor(frame);
            return frame;
        }

    var calendar = function () {
        var content, loadCalendar, _colorArr = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'F'], _getColor = function (color) {
            var check1 = _colorArr.findIndex(function (val) {
                return val == color.substr(1, 1)
            });
            var check2 = _colorArr.findIndex(function (val) {
                return val == color.substr(2, 1);
            });
            check1 += 4;
            check2 += 3;
            check1 = check1 > _colorArr.length - 1 ? 0 : check1;
            check2 = check2 > _colorArr.length - 1 ? 0 : check2;
            console.log(check1, _colorArr[check1], check2, _colorArr[check2])
            return '#' + _colorArr[check1] + '' + _colorArr[check2] + '' + _colorArr[check2] + '' + _colorArr[check1] + color.substr(5);
        }, _isSuiteEvent = { color: '#2F2391F2', note: '' }, suiteEvent = function (event) {
            if (_isSuiteEvent.note != event)
                _isSuiteEvent.color = _getColor(_isSuiteEvent.color);
            _isSuiteEvent.note = event;
            this.css({ 'border': '2px solid ' + _isSuiteEvent.color });
        };
        var isDate = Moment(new Date()), isMonth = isDate.date.getMonth(), firsrtDay = 0, dateCalandar = Moment();
        var now = Moment().setMonth(isMonth);

        var month = options && options.month ? options.month : ['Janvier', 'Février', 'Mars', 'Avril', 'May', 'Juin', 'Juillet', 'Août', 'Séptembre', 'Octobre', 'Novembre', 'Décembre'];
        var weekHead = options && options.week ? options.week : ['Lundi', 'Mardi', 'Mercredi', 'Jeudi', 'Vendredi', 'Samedi', 'Dimanche'];

        var btnSave = _$('<di/>', {
            class: 'pull-right',
            style: 'cursor:pointer',
            title: 'Enregistrer evenement'
        }), iconBtnSave = _$('<i/>', {
            class: 'fa fa-save',
            style: 'font-size:24px;color:greenyellow;position:absolute;'
        }), btnRemove = function () {
            return _$('<i/>', {
                class: 'fa fa-times',
                style: 'color:red;text-align:end;font-size:11px;position:absolute;width:19px;height:19px;' +
                    'top:4px;right:1px;padding-top:4px;box-shadow:0 0 9px 0px black;padding-right:5px;border-radius:6px'
            });
        }, infoNote = function () {
            return _$('<label/>', {
                class: 'label',
                style: 'font-variant: all-petite-caps;color: #00000087;text-align: center;font-size: 7px;position:absolute;border-radius:4px;' +
                    'width: 100%;height:100%;top:0px;right: 0px;padding-right: unset;text-overflow: ellipsis;white-space: nowrap;'
            });
        };

        var savedNote = function () {
            this.calendarNote.news = [];
            this.calendarNote.removes = [];
            btnSave.innerHTML = "";
            for (var _in in this.calendarNote) {
                sortArray.apply(this.calendarNote[_in], [function (a, b) {
                    return new Date(a) < new Date(b);
                }]);
            }
            this.calendarSaveEvent(this.calendarNote);
        }

        var saveNote = function () {
            for (var note in this.calendarNote.news) {
                var note_add = this.calendarNote.news[note];
                if (!this.calendarNote.applied.includes(this.calendarNote.news[note])) {
                    this.calendarNote.applied.push(this.calendarNote.news[note]);
                }
                this.calendarNote.removed = this.calendarNote.removed.filter(function (is_note) {
                    return note_add !== is_note;
                });

                this.calendarNote.contentRemove = this.calendarNote.contentRemove.filter(function (is_note) {
                    return note_add !== is_note;
                });
            }
            for (var note in this.calendarNote.removes) {
                var removes = this.calendarNote.removes[note];

                if (this.calendarNote.content.includeObj(this.calendarNote.removes[note])
                    &&
                    !this.calendarNote.contentRemove.includes(this.calendarNote.removes[note])) {
                    this.calendarNote.contentRemove.push(this.calendarNote.removes[note]);
                }

                this.calendarNote.content = this.calendarNote.content.filter(function (is_note) {
                    return (removes !== is_note.value);
                });

                this.calendarNote.news = this.calendarNote.news.filter(function (is_note) {
                    return (removes !== is_note);
                });

                this.calendarNote.applied = this.calendarNote.applied.filter(function (is_note) {
                    return (removes !== is_note);
                });

                if (!this.calendarNote.removed.includes(this.calendarNote.removes[note])
                    &&
                    !this.calendarNote.contentRemove.includes(this.calendarNote.removes[note])) {
                    this.calendarNote.removed.push(this.calendarNote.removes[note]);
                }
            }
            savedNote.apply(this);
        }

        var nexCalendar = function (date) {
            loadCalendar = Loading.apply(content);
            this.gotToMonth = function () {
                now.setMonth(now.date.getMonth() + 1);
            }
            this.changeEvent();
        }

        var prevCalendar = function () {
            loadCalendar = Loading.apply(content);
            this.gotToMonth = function () {
                now.setMonth(now.date.getMonth() - 1);
            }
            this.changeEvent();
        }

        var generate = function () {
            firsrtDay = now.date.getDay();
            dateCalandar = firsrtDay === 0
                ?
                Moment().setTime(now.date.getTime()).init({ jours: -7 })
                :
                Moment().setTime(now.date.getTime()).init({ jours: -(firsrtDay - 1) });
        }

        var head = function (selector) {
            var self = this;
            var head = _$('<thead/>'),
                btnPrev = _$('<button/>').html("<<"),
                btnNex = _$('<button/>').html(">>"),
                tr = _$('<tr/>')
                    .appendFor(_$('<th/>').appendFor(btnPrev))
                    .appendFor(_$('<th/>', { colspan: '5' })
                        .html(month[now.date.getMonth()] + ' <b>' + now.date.getFullYear() + '</b>').appendFor(btnSave))
                    .appendFor(_$('<th/>').appendFor(btnNex));
            _$(head).appendFor(tr);
            btnNex.addEventListener('click', function () {
                nexCalendar.apply(self);
            });
            btnPrev.addEventListener('click', function () {
                prevCalendar.apply(self);
            });
            tr = _$('<tr/>', { class: 'table-calandar-month' });

            for (var x = 0; x < weekHead.length; x++) {
                tr.appendFor(_$('<th/>', { title: weekHead[x] }).html(weekHead[x].substring(0, 3)));
            }
            _$(head).appendFor(tr);
            _$(selector).appendFor(head);
            return selector;
        }

        var empile = function (selector) {
            var parent = this;
            var self = function () {
                this.push = function (nbWeek, week) {
                    for (var nbDays = nbWeek + 1; nbDays <= 7 + nbWeek; nbDays++) {
                        var days = _$('<td/>', { style: "position:relative;" }).html(dateCalandar.date.getDate());
                        if (dateCalandar.equalsMonth(now)) days.addAttr({ class: 'active' });
                        else days.addAttr({ class: 'disable' });
                        if (dateCalandar.equalsDate(isDate))
                            days.addClass('date-now-calendar');

                        if (dateCalandar.beforDate(isDate)) {//event init
                            if (parent.calendarNote.content.includeObj(dateCalandar.getString('y-m-d'))) {
                                if (dateCalandar.beforMonth(now)) {

                                    var rm = new btnRemove();
                                    rm.addEventListener('click', function () {
                                        var date = _$(this).parents('td').text(),
                                            next_month = Moment(now.date).setMonth(now.date.getMonth() + 1).setDate(date);
                                        parent.pushCalendarNoteRemove(next_month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar-note');
                                        _$(this).remove();
                                    });
                                } else {
                                    var rm = new btnRemove();
                                    rm.addEventListener('click', function () {
                                        var date = _$(this).parents('td').text(),
                                            month = Moment(now.date).setMonth(now.date.getMonth()).setDate(date);
                                        parent.pushCalendarNoteRemove(month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar-note');
                                        _$(this).remove();
                                    });
                                }
                                var note = parent.calendarNote.content.filter(obj => {
                                    return obj.value && obj.value === dateCalandar.getString('y-m-d')
                                });

                                if (note) {
                                    var _title = '';
                                    for (var i in note[0].notes) {
                                        _title += '<b>' + i + '</b>: ' + note[0].notes[i] + '</br>';
                                    }
                                    var __oo = new infoNote().html(note[0].libelle).css({ 'text-shadow': '5px 5px 10px red' });
                                    suiteEvent.apply(__oo, [note[0].libelle]);
                                    days.appendFor(__oo).addTitle(_title);
                                }
                                if (parent.delete) days.appendFor(rm);
                                //event remove
                                days.addClass('selected-calendar-note');

                            } else if (parent.add && (parent.calendarNote.applied.includes(dateCalandar.getString('y-m-d')) || parent.calendarNote.news.includes(dateCalandar.getString('y-m-d')))) {
                                var rm = new btnRemove();
                                if (dateCalandar.equalsMonth(now)) {
                                    rm.addEventListener('click', function () {
                                        var date = _$(this).parents('td').text(),
                                            month = Moment(now.date).setMonth(now.date.getMonth()).setDate(date);
                                        parent.pushCalendarNoteRemove(month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar');
                                        _$(this).remove();
                                    });
                                } else if (dateCalandar.beforMonth(now)) {
                                    rm.addEventListener('click', function () {
                                        var date = _$(this).parents('td').text(),
                                            month = Moment(now.date).setMonth(now.date.getMonth() + 1).setDate(date);
                                        parent.pushCalendarNoteRemove(month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar');
                                        _$(this).remove();
                                    });
                                } else {
                                    rm.addEventListener('click', function () {
                                        var date = _$(this).parents('td').text(),
                                            month = Moment(now.date).setMonth(now.date.getMonth() - 1).setDate(date);
                                        parent.pushCalendarNoteRemove(month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar');
                                        _$(this).remove();
                                    });
                                }

                                days.appendFor(rm);
                                days.addClass('selected-calendar');
                                //remove event
                            } else {
                                if (dateCalandar.equalsMonth(now)) {
                                    var remove_event = function () {
                                        _$(this).parents('td').addClass('waiting');
                                        var date = _$(this).parents('td').text(),
                                            month = Moment(now.date).setMonth(now.date.getMonth()).setDate(date);
                                        parent.pushCalendarNoteRemove(month.getString('y-m-d'));
                                        _$(this).parent().removeClass('selected-calendar');
                                        _$(this).remove();
                                    }, add_event = function (event) {
                                        if (!this.is(event.target)) return;
                                        var selectDate = now.parseDateToString(_$(this).html(), 'y-m-d');
                                        parent.pushCalendarNoteNews(selectDate);
                                        var rm = new btnRemove();
                                        rm.addEventListener('click', remove_event);
                                        _$(this).appendFor(rm);
                                        _$(this).addClass('selected-calendar');
                                    };

                                    if (parent.add) days.addEventListener('click', add_event)

                                } else if (dateCalandar.beforMonth(now)) {
                                    days.addEventListener('click', function () {
                                        var next_month = Moment(now.date).setMonth(now.date.getMonth() + 1).setDate(_$(this).html());
                                        if (parent.add) parent.pushCalendarNoteNews(next_month.getString('y-m-d'));
                                        nexCalendar.apply(parent);
                                    })
                                } else {
                                    days.addEventListener('click', function () {
                                        var last_month = Moment(now.date).setMonth(now.date.getMonth() - 1).setDate(_$(this).html());
                                        if (parent.add) parent.pushCalendarNoteNews(last_month.getString('y-m-d'));
                                        prevCalendar.apply(parent);
                                    })
                                }
                            }
                        } else {//no event
                            if (parent.calendarNote.content.includeObj(dateCalandar.getString('y-m-d'))) {
                                var note = parent.calendarNote.content.filter(obj => {
                                    return obj.value && obj.value === dateCalandar.getString('y-m-d')
                                });

                                if (note) {
                                    var _title = '';
                                    for (var i in note[0].notes) {
                                        _title += '<b>' + i + '</b>: ' + note[0].notes[i] + '</br>';
                                    }
                                    var __oo = new infoNote().html(note[0].libelle).css({ 'text-shadow': '5px 5px 10px red' });
                                    suiteEvent.apply(__oo, [note[0].libelle]);
                                    days.appendFor(__oo).addTitle(_title);
                                }
                                days.addClass('selected-calendar-note');
                            }
                            if (dateCalandar.beforMonth(now)) {
                                days.addEventListener('click', function () {
                                    nexCalendar.apply(parent);
                                })
                            } else if (dateCalandar.lastMonth(now)) {
                                days.addEventListener('click', function () {
                                    prevCalendar.apply(parent);
                                })
                            }

                        }

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
        this.edit = options.edit || false;
        this.delete = options.delete || false;
        this.readOnly = options.readOnly || false;
        this.add = (this.edit && !this.readOnly);
        this.options = options || {};
        this.calendar = {};

        Array.prototype.includeObj = function (value) {
            for (var i = 0; i < this.length; i++) {
                if (typeof this[i] === 'object' && typeof value === 'string') {
                    for (var obj_in in this[i]) {
                        if (this[i][obj_in] == value) return true;
                    }
                }
                else if (typeof value === 'object' && typeof this[i] === 'object') {
                    var trouver = 0;
                    for (var val in value) {
                        if (this[i][val] && this[i][val] === value[val]) {
                            trouver++;
                        }
                    }
                    if (trouver === value.length) return true;
                }
            }
            return false;
        }

        this.calendarNote = {
            news: [],
            applied: [],
            content: [],
            contentRemove: [],
            removes: [],
            removed: []
        };
        this.pushCalendarNoteRemove = function (notes) {
            if (!this.calendarNote.removes.includes(notes))
                this.calendarNote.removes.push(notes);

            if (this.calendarNote.removes.length) {
                var event = this;
                iconBtnSave.addEventListener('click', function () {
                    saveNote.apply(event);
                });
                btnSave.appendFor(iconBtnSave);
            }
        }
        this.pushCalendarNoteNews = function (notes) {
            if (typeof notes === 'string' && !this.calendarNote.news.includes(notes))
                this.calendarNote.news.push(notes);
            else {
                for (var note in notes) {
                    if (!this.calendarNote.news.includes(notes))
                        this.calendarNote.news.push(note);
                }
            }
            if (this.calendarNote.news.length) {
                var event = this;
                iconBtnSave.addEventListener('click', function () {
                    saveNote.apply(event);
                });
                btnSave.appendFor(iconBtnSave);
            }
        }
        this.pushCalendarNoteContent = function (notes) {
            if (typeof notes === 'string' && !this.calendarNote.content.includeObj(notes)) {
                this.calendarNote.content.push({ value: notes });
            }
            else if (typeof notes === 'object' && !this.calendarNote.content.includeObj(notes)) {
                this.calendarNote.content.push(notes);
            }
        }
        this.changeEvent = function () {
            this.gotToMonth.apply(this);
            this.gotToMonth = function () { };
            this.calendar = {
                month: now.date.getMonth() + 1,
                year: now.date.getFullYear()
            };
            this.getCalendar();
            console.log('change event');
        };
        this.gotToMonth = function () { };

        this.initCalendar = function (elem, fn, saveEvent) {
            this.changeEvent = fn ? function () {
                this.gotToMonth.apply(this);
                this.gotToMonth = function () { };
                this.calendar = {
                    month: now.date.getMonth() + 1,
                    year: now.date.getFullYear()
                };
                fn.apply(this);
            } : this.changeEvent;
            this.calendarSaveEvent = saveEvent ? saveEvent : () => { console.log('save event') };
            content = elem ? elem : content;
            now = Moment().setMonth(isMonth);
            loadCalendar = undefined;
            this.calendarNote.news = [];
            this.calendarNote.removes = [];
            btnSave.innerHTML = "";
            this.changeEvent();
        }

        this.getCalendar = function () {
            generate();
            var body = _$('<tbody/>'), table = _$('<table/>', {
                class: 'table-calandar'
            }), nbWeek = 0;
            head.apply(this, [table]);
            while (nbWeek < 42) {
                var week = _$('<tr/>');
                nbWeek = empile.apply(this, [body]).push(nbWeek, week) - 1;
            }

            table.appendFor(body);
            content.innerHTML = "";
            _$(content).appendFor(table);
            if (loadCalendar) loadCalendar.remove();
        }
        return this;
    }

    var objCalendar = {};
    return calendar.apply(objCalendar);
}