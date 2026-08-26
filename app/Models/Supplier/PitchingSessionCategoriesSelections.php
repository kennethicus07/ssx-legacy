<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PitchingSessionCategoriesSelections extends Model
{
    use HasFactory;

    
     protected $table = 'pitching_session_categories_selection';
    protected $fillable = [
        'ff_code',
        'fair_code',
        'pitching_session_category_id',
        'created_at',
    ];



    public function pitchingSessionCategories()
{

    return $this->belongsTo(PitchingSessionCategories::class, 'pitching_session_category_id', 'id');
}

}
