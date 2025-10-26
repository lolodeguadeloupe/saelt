<?php

namespace App\Models\LocationVehicule;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class VehiculeInfoTech extends Model
{
    protected $table = 'vehicule_info_tech';

    protected $fillable = [
        'nombre_place',
        'nombre_porte',
        'vitesse_maxi',
        'nombre_vitesse',
        'boite_vitesse',
        'kilometrage',
        'type_carburant',
        'fiche_technique',
        'vehicule_id',

    ];


    protected $dates = [
        'created_at',
        'updated_at',

    ];

    protected $appends = ['resource_url', 'fiche_technique_b64'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/vehicule-info-teches/' . $this->getKey());
    }

    public function getFicheTechniqueB64Attribute()
    {
        if ($this->fiche_technique) {
            $filename = public_path($this->fiche_technique);
            /*$opts = array(
                'http'=>array(
                  'method'=>"GET",
                  'header'=>"Accept-language: en\r\n" .
                            "Cookie: foo=bar\r\n"
                )
              );
              
              $context = stream_context_create($opts);
              
              // Open the file using the HTTP headers set above
              $file = file_get_contents($filename, false, $context);
              return $file;
              */
            //dd(File::file("D://PROJET/professionnel/laravel nogae/~saeltpro/public/uploads//fiche-technique/BUKU8v5fLuG7eBKJV5Qw4vXyd.pdf"));
            return "data:" . mime_content_type($filename) . ";base64," . base64_encode(file_get_contents($filename));
        } else return null;
    }
}
