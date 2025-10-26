<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GestionRequestUtilisateur extends Model
{
    protected $table = 'gestion_request_utilisateur';

    protected $fillable = [
        'session_id',
        'user_id',
        'identifiant_session',
        'data',
        'name',
        'timeout'
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = [];

    /* ************************ ACCESSOR ************************* */

    public function getData(){
        $this->data = collect(json_decode($this->data))->toArray();
        return  $this;
    }
}
