<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AccessLog extends Model
{
    protected $table      = 'kis_access_log';
    protected $guarded    = [];
    public $timestamps    = false;
}
