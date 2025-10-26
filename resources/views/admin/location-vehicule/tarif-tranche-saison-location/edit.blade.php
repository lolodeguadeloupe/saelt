        <div class="card">

            <form class="form-horizontal form-edit" id="edit-tarif" method="post" @submit.prevent="storeTarif($event,'edit_tarif')" :action="actionEditTarif" novalidate>
                <div class="card-header">
                    <i class="fa fa-pencil"></i>
                    <h3>{{ trans('admin.tarif-tranche-saison-location.actions.edit') }}</h3>
                    <a class="float-right text-danger" style="cursor:pointer" href="#" @click.prevent="closeModal('edit_tarif')"><i class="fa fa-times"></i></a>
                </div>
                <div class="card-body">
                    <div class="form-group row align-items-center">
                        <label for="saisons_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.saison') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" name="vehicule_location_id" required style="display: none;" :value="vehicule.id">
                            <input type="text" name="saisons_id" required style="display: none;">
                            <input type="text" class="form-control" required readonly name="saisons_titre" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.saison') }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="tranche_saison_id" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }} (Jours)</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="text" name="tranche_saison_id" required style="display: none;">
                            <input type="text" class="form-control" required readonly name="tranche_saison_titre" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.tranche_saison') }}">
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="prix_achat" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'')" name="prix_achat" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.prix_achat') }}">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="marge" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" min="0" required class="form-control with-unite" @input="checkMarge($event,'')" name="marge" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.marge') }}">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                    <div class="form-group row align-items-center">
                        <label for="prix_vente" class="col-form-label text-md-right required" :class="isFormLocalized ? 'col-md-4' : 'col-md-2'">{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}</label>
                        <div :class="isFormLocalized ? 'col-md-4' : 'col-md-9 col-xl-8'">
                            <input type="number" min="0" required class="form-control with-unite" readonly @input="checkMarge($event,'')" name="prix_vente" placeholder="{{ trans('admin.tarif-tranche-saison-location.columns.prix_vente') }}">
                            <span style="position: absolute; left: 20px; top: 0; width:auto; height: 100%;display: flex;align-items: center; font-weight: 500; text-decoration: underline;font-size: 18px;">€</span>
                        </div>
                    </div>
                </div>


                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-download"></i>
                        {{ trans('admin-base.btn.save') }}
                    </button>
                </div>

            </form>
        </div>