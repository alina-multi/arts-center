<?php

namespace App\Console\Traits;

use Illuminate\Support\Facades\DB;

trait getNewUserId {
    //We are smart we cache things
    protected array $oldIdToNew = [];

    public function getNewUserId($oldId)
    {
        if (!$oldId) return false;

        if (empty($this->oldIdToNew[$oldId])) {
            $this->oldIdToNew[$oldId] = DB::table('users')->select('id')->where('old_id', $oldId)->value('id');
        }

        if (empty($this->oldIdToNew[$oldId])) {
            return false;
        }

        return $this->oldIdToNew[$oldId];
    }
}
