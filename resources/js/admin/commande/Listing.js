import AppListing from '../app-components/Listing/AppListing';
import AppForm from '../app-components/Form/AppForm';
import Myform from '../app-components/helperForm';

Vue.component('commande-listing', {
    mixins: [AppListing, AppForm],
    methods: {
        detail(event, id) {
            this.$managerliens({
                is_parent: false,
                parent_name: 'commande',
                href: `${this.url}/${id}?commande=${id}`,
                name: 'Detail commande',
                body: event.target,
                _this: this,
                axios: axios,
                liens: 'childre',
                range: '1',
                _$: $
            });
        },
    },
    props: [
        'url',
        'action',
        'urlbase', 'urlasset',
        'modepayement'
    ]
});