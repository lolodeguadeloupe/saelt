<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EventDateHeure extends Model {

    protected $table = 'event_date_heure';
    protected $fillable = [
        'description',
        'date',
        'time_start',
        'time_end',
        'model_event',
        'status',
        'ui_event',
        'color'
    ];
    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];
    protected $appends = ['resource_url'];

    /*     * *********************** ACCESSOR ************************* */

    public function getResourceUrlAttribute() {
        return url('/admin/event-date-heures/' . $this->getKey());
    }

}
