<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;

trait TracksUser
{
    public static function bootTracksUser()
    {
        static::creating(function ($model) {

            $userId = Auth::guard('supplier')->id();

            if ($userId) {
                $model->created_by = $userId;
                $model->updated_by = $userId;
            }
        });

        static::updating(function ($model) {

            $userId = Auth::guard('supplier')->id();

            if ($userId) {
                $model->updated_by = $userId;
            }
        });
    }
}