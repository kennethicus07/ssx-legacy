<?php

namespace App\Models\Supplier;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
class PitchingSessionCategories extends Model
{
    use HasFactory;

    protected $table = 'pitching_session_categories';
    protected $fillable = [
        'participation_addon_id',
        'fair_code',
        'value',
        'status',
        'status',
        'created_at',
        'updated_at',
    ];

  protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('status', 1);
        });
    }

    public function addOn()
    {
        return $this->belongsTo(ParticipationAddOn::class, 'participation_addon_id', 'id');
    }
}
