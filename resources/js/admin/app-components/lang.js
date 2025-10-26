const lang = function (lang) {
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
				'file_error':'An error has occured',
				'file_size':'An error of size file',
				'select_error': 'Try to valid champ',
				'status_calendar_passe':'Past',
				'status_calendar_active':'Active',
				'status_calendar_desactive':'Desactive'
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
				'file_size':'Une erreur sur la taille de l\'image',
				'select_error': 'Veuillez valider le champ',
				'status_calendar_passe':'Passé',
				'status_calendar_active':'Activé',
				'status_calendar_desactive':'Desactivé'
			}
			break;
	}
	return dict;
};

export default lang;