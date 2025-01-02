<?php

namespace App\Observers;

use App\Models\YourModel;
use App\Models\Log;
use Illuminate\Support\Facades\Auth;

class CrudObserver
{
    public function created(YourModel $model)
    {
        Log::create([
            'action' => 'created',
            'model' => get_class($model),
            'model_id' => $model->id,
            'changes' => json_encode($model->getChanges()),
            'user_id' => Auth::id(),
        ]);
    }

    public function updated(YourModel $model)
    {
        Log::create([
            'action' => 'updated',
            'model' => get_class($model),
            'model_id' => $model->id,
            'changes' => json_encode($model->getChanges()),
            'user_id' => Auth::id(),
        ]);
    }

    public function deleted(YourModel $model)
    {
        Log::create([
            'action' => 'deleted',
            'model' => get_class($model),
            'model_id' => $model->id,
            'changes' => null,
            'user_id' => Auth::id(),
        ]);
    }
}
