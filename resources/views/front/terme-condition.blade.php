<div class="card">
    <div class="card-header">
        <button class="btn btn-sm btn-danger float-right" @click.prevent="$modal.hide('terme-condition')"><i class="fa fa-times"></i></button>
    </div>
    <div class="card-body">
        <p>Mes conditions</p>
    </div>
    <div class="card-footer" v-if="accepted == false">
        <button class="btn btn-info float-right" @click.prevent="accepterCondition">J'accepte</button>
    </div>
</div>