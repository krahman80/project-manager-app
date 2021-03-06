<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    protected $dates = ['start_date', 'end_date'];
    
    public function Project() {
        return $this->belongsTo('App\Project');
    }

    public function User() {
        return $this->belongsTo('App\User');
    }

    public function getFlagAttribute() {
        $now = Carbon::now();

        if ($now->lessThan($this->start_date)){
            return "not started"; }
        else if ($this->end_date->lessThan($now)) {
            return "overdue";
        } else {
            return "started";
        }
    }

    public function getFlagClassAttribute() {
        $now = Carbon::now();

        if ($now->lessThan($this->start_date)){
            return "bg-info";
        }
        else if ($this->end_date->lessThan($now)){
            return "bg-danger text-white";
        } else {
            return "bg-warning";
        }

    }

    public function getStatusStringAttribute() {
        if($this->status == 0) {
            return "In Progress";
        } else if ($this->status == 1) {
            return "Pending";
        } else {
            return "Completed";
        }
    }

    public function comments() {
        return $this->belongsToMany('App\Comment');
    }
    
    public function scopeProgress($query)
    {
        return $query->where('status', '=', 0);
    }
}
