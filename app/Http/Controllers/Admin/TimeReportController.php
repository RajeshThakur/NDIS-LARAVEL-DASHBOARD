<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TimeEntry;
use Carbon\Carbon;

class TimeReportController extends Controller
{
    public function index()
    {
        $from = Carbon::parse(request()->query('from', Carbon::now()));
        $to   = Carbon::parse(request()->query('to', Carbon::now()))->endOfDay();

        $projects = TimeEntry::with('project')
            ->whereBetween('start_time', [$from, $to])
            ->get();

        $workTypes = TimeEntry::with('work_type')
            ->whereBetween('start_time', [$from, $to])
            ->get();

        $projectTimes = [];

        foreach ($projects as $project) {
            $begin = Carbon::parse($project->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($project->end_time, 'Europe/Vilnius');

            if (!isset($projectTimes[$project->project->id])) {
                $projectTimes[$project->project->id] = [
                    'name' => $project->project->name,
                    'time' => $begin->diffInSeconds($end),
                ];
            } else {
                $projectTimes[$project->project->id]['time'] += $begin->diffInSeconds($end);
            }
        }

        $workTypeTime = [];

        foreach ($workTypes as $workType) {
            $begin = Carbon::parse($workType->start_time, 'Europe/Vilnius');
            $end   = Carbon::parse($workType->end_time, 'Europe/Vilnius');

            if (!isset($workTypeTime[$workType->work_type->id])) {
                $workTypeTime[$workType->work_type->id] = [
                    'name' => $workType->work_type->name,
                    'time' => $begin->diffInSeconds($end),
                ];
            } else {
                $workTypeTime[$workType->work_type->id]['time'] += $begin->diffInSeconds($end);
            }
        }

        return view('admin.timeReports.index', compact('projectTimes', 'workTypeTime'));
    }
}
