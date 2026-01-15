<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityObserver
{
    protected function logActivity(Model $model, string $action)
    {
        if (Auth::check()) {
            ActivityLog::create([
                'user_id' => Auth::id(),
                'activity' => $action . ' ' . class_basename($model),
                'model_type' => get_class($model),
                'model_id' => $model->id,
                'payload' => $model->getChanges(), // Mencatat hanya data yang berubah
                'ip_address' => request()->ip(),
            ]);
        }
    }

    public function created(Model $model)
    {
        $this->logActivity($model, 'Membuat');
    }
    public function updated(Model $model)
    {
        $this->logActivity($model, 'Mengubah');
    }
    public function deleted(Model $model)
    {
        $this->logActivity($model, 'Menghapus');
    }
}