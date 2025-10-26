var bibliotheque = {
    NUMERO_CIN: 'Numéro CIN',
    CODE_DIRECTION: 'Référence direction',
    CIN_LIEU_DELIVRE: 'CIN délivrer à',
    NOM: 'Nom',
    PHOTO: 'Photo',
    LIEU_NAISSANCE: 'Lieu de naissance',
    ADRESSE_MAIL: 'E-mail',
    NATIONALITE: 'Natinalité',
    SITUATION_MATRIMONIALE: 'Situation matrimoniale',
    created_at: 'Créer le',
    CODE_CATEGORIE_PROFESSIONNELLE: 'Référence catégorie',
    REFERENCE_HIERARCHIQUE: 'Référence hiérarchique',
    CODE_POSTAL: 'Code postal',
    CIN_DATE_DELIVRE: 'Date CIN',
    PRENOM: 'Prénom(s)',
    ADRESSE: 'Adresse',
    FONCTION: 'Fonction',
    SEXE: 'Séxe',
    NOMBRE_ENFANT: 'Nombre d\'enfant',
    updated_at: 'A jour le',
    FONCTIONs: 'Fonction',
    FONCTIONv: 'Fonction',
    NOM_VILLE: 'Ville',
    DATE_NAISSANCE: 'Date de naisssance',
    NUMERO_TELEPHONE: 'Contact mobile',
    NOM_DIRECTION: 'Direction',
    ANCEINNETE: 'Anceinneté',
    NUMERO_COMPTE: 'Compte bancaire',
    bt_serveur_status: 'Interception avec le serveur : ',
    paginate_suiv: 'Suivant',
    paginate_prec: 'Précedent'
};

export const Bibliotheque = function () {
    this.bibliotheque_key_ = bibliotheque || {};
    this.add = function (...biblio) {

        if (typeof biblio === 'object') {
            var k = 0
            while (biblio[k]) {
                for (var key in biblio[k]) {
                    if (!(key in this.bibliotheque_key_) && typeof biblio[k][key] === 'string')
                        this.bibliotheque_key_[key] = biblio[k][key];
                }
                k++
            }
        }
        bibliotheque = this.bibliotheque_key_;
        return this.bibliotheque_key_;
    }

    this.edit = function (biblio) {
        if (typeof biblio === 'object' && typeof biblio.value === 'string') {
            for (var key in biblio)
                this.bibliotheque_key_[key] = biblio[key];
        }
        bibliotheque = this.bibliotheque_key_;
        return this.bibliotheque_key_;
    }

    this.is = function (val_traite) {
        var chercher = val_traite || {};
        if (typeof chercher === 'object') {
            var k = 0;
            for (var l in chercher) {
                var swap = chercher
                if (typeof swap[l] === 'object' && swap[l]) {
                    chercher[l] = this.is(swap[l]);
                } else if (typeof swap[l] === 'string' || swap[l] === null) {
                    if (l in this.bibliotheque_key_)
                        chercher[l] = { biblio: this.bibliotheque_key_[l], value: swap[l] };
                    else
                        chercher[l] = { biblio: l, value: swap[l] };
                }
            }
        }
        return chercher;
    }

    return this;
}