<?php

namespace App\Traits;

use App\Models\AuditLog;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            AuditLog::log('create', $model, null, $model->toArray());
        });

        static::updated(function ($model) {
            $oldData = $model->getOriginal();
            $newData = $model->toArray();
            
            // Hanya log jika ada perubahan yang signifikan
            if ($oldData != $newData) {
                AuditLog::log('update', $model, $oldData, $newData);
            }
        });

        static::deleted(function ($model) {
            AuditLog::log('delete', $model, $model->toArray(), null);
        });
    }
}