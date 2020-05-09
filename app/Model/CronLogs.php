<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CronLogs extends Model
{
    public $table = 'cron_logs';

    public $timestamps = false;

    protected $dates = [
        'started_at',
        'ended_at'
    ];
    
    protected $fillable = [
        'command_name',
        'data',
        'started_at',
        'ended_at',
    ];


    /**
     * Set Attributes
     */
    public function getStartedAtAttribute($value)
    {
        return DBToDatetime($value);
    }
    public function getEndedAtAttribute($value)
    {
        return DBToDatetime($value);
    }

    public function setStartedAtAttribute($value)
    {
        $this->attributes['started_at'] = datetimeToDB($value);
    }
    public function setEndedAtAttribute($value)
    {
        $this->attributes['ended_at'] = datetimeToDB($value);
    }

}
