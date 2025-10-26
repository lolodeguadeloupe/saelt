<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MediaImageUpload extends Model
{
    protected $table = 'media_image_upload';

    protected $fillable = [
        'id_model',
        'name',
    
    ];
    
    
    protected $dates = [
        'created_at',
        'updated_at',
    
    ];
    
    protected $appends = ['resource_url'];

    /* ************************ ACCESSOR ************************* */

    public function getResourceUrlAttribute()
    {
        return url('/admin/media-image-uploads/'.$this->getKey());
    }
}
