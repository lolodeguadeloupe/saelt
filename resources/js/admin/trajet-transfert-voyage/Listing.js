import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('trajet-transfert-voyage-listing', {
    mixins: [AppListing, AppForm],
    data: function () {
        return {
            form: { description: '' },
            actionEditTrajet: '',
            myEvent: {},
            cardImage: [],
        }
    },
    methods: {
        editTrajet(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            axios.get(url).then(function (response) {
                _this5.actionEditTrajet = response.data.trajetTransfertVoyage.resource_url;
                _this5.form.description = response.data.trajetTransfertVoyage.description;
                _this5.cardImage = response.data.trajetTransfertVoyage.card ? [response.data.trajetTransfertVoyage.card] : [];
                _this5.$modal.show('edit_trajet');
                _this5.myEvent = {
                    ..._this5.myEvent, 'editTrajet': function () {
                        var _data = {
                            ...response.data.trajetTransfertVoyage,
                            point_depart_titre: response.data.trajetTransfertVoyage.point_depart.titre,
                            point_arrive_titre: response.data.trajetTransfertVoyage.point_arrive.titre,
                            point_depart: response.data.trajetTransfertVoyage.point_depart.id,
                            point_arrive: response.data.trajetTransfertVoyage.point_arrive.id
                        };
                        console.log(_data)
                        $('#edit-trajet').each(function () {
                            Myform(this).setForm(_data)
                        })
                    }
                }
            }, function (error) {
                _this5.$notify({ type: 'error', title: 'Error!', text: error.response.data.message ? error.response.data.message : 'An error has occured.' });

            }).finally(() => {
                loading.remove();
            });
        },
        createTrajet(event, url) {
            var _this5 = this;
            let loading = $(event.target).InputLoadRequest();
            _this5.form = { ...(_this5.form ?? {}), description: "" };
            _this5.cardImage = [];
            _this5.myEvent = {
                ..._this5.myEvent, 'createTrajet': function () {
                    loading.remove()
                }
            }
            _this5.$modal.show('create_trajet');
        },
        storeTrajet(event, modal) {
            var _this5 = this;
            this.mySubmit(event, {
                success: function () {
                    _this5.$modal.hide(modal);
                }
            }, false, { description: (_this5.form && _this5.form.description) ?? '', });
        },
        closeModal(modal) {
            this.$modal.hide(modal);
        },
        uploadCart(event, drop = false) {
            var _this5 = this, progress_bar = $("<div/>").css({
                'background-color': 'green',
                'width': '0%',
                'height': '100%',
                'position': 'absolute',
                'z-index': '12',
                'top': '0',
                'left': '0'
            });

            const files = drop ? event.dataTransfer.files : event.target.files;
            for (const file of files) {
                if (file && file.type && ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'].includes(String(file.type))) {
                    if (file.size && file.size > 1024 * 1024 * 1024 * 4) {
                        _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_error}` });
                    } else {
                        var reader = new FileReader();
                        reader.onload = (data) => {
                            _this5.cardImage = [data.target.result];
                            progress_bar.remove();
                        }
                        reader.onprogress = (_event) => {
                            $($(event.target).is('figure') ? $(event.target) : $(event.target).parents('figure')).each(function () {
                                $(this).find('.my-_btn-add').each(function () {
                                    $(this).append(progress_bar);
                                    if (_event.loaded && _event.total) {
                                        const percent = (_event.loaded / _event.total) * 100;
                                        progress_bar.css({ width: `${percent}%` });
                                    }
                                })
                            })
                        }
                        reader.readAsDataURL(file);
                    }
                } else {
                    _this5.$notify({ type: 'error', title: 'Error!', text: `${_this5.$dictionnaire.file_size}` });
                }
            }
        },
        removeCart(index) {
            this.cardImage = [];
        },
        autocompleteLieuTransfert() {
            var _this5 = this;
            return {
                ajax: axios,
                fnSelectItem: function (item) {
                },
                fnBtnNew: function () {
                    _this5.$redirect(`${_this5.urlbase}/admin/lieu-transferts`);
                },
                detailInfo: ['titre','ville.name'],
                formateDetailInfo: null,
                frame: this,
            }
        },
    }, props: [
        'url',
        'action',
        'urlbase', 'urlasset'
    ]
});