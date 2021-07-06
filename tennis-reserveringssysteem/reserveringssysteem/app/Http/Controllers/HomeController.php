<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Court;
use App\Models\Reservation;
use App\Models\Setting;
use App\Models\Timeslot;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $courts = Court::where('clubs_id', $user->clubs_id)->get();
        $setting = Setting::where('clubs_id', $user->clubs_id)->first();
        $timeslots = Timeslot::where('settings_id', $setting->id)->get() ?? [];
        $reservations = [];

        $minutes = $setting->timeslot;

        if ($request->date) {
            $date = Carbon::parse($request->date);
        } else {
            $date = Carbon::today();
        }

        foreach ($courts as $court)
        {
            $reservations[] = Reservation::where('courts_id', $court->id)
                                            ->whereDate('starttime', $date)
                                            ->get();
        }

        foreach ($timeslots as $timeslot)
        {
            $dates = array();
            $startdate = strtotime(Carbon::parse($timeslot->startdate));
            $enddate = strtotime(Carbon::parse($timeslot->enddate));
            $stepVal = '+1 day';
            while( $startdate <= $enddate ) {
                $dates[] = date("Y-m-d", $startdate);
                $startdate = strtotime($stepVal, $startdate);
            }

            foreach ($dates as $timeslot_date) {
                if (Carbon::parse($timeslot_date) == $date)
                {
                    $minutes = $timeslot->minutes;
                }
            }
        }

        $userCount = Reservation::whereHas('users', function (Builder $query) use ($user) {
            $query->where('user_id', $user->id);
        })->count();

        $starttime = 8 * 60;
        $endtime = 23 * 60;

        return view('home',
        [
            'courts' => $courts,
            'reservations' => $reservations,
            'starttime' => $starttime,
            'endtime' => $endtime,
            'timeslot' => $minutes,
            'date' => $date,
            'today' => Carbon::today(),
            'previousDay' => $date->copy()->subDays(),
            'nextDay' => $date->copy()->addDay(),
            'twoWeeks' => Carbon::today()->addDay(14),
            'userCount' => $userCount,
            'setting' => $setting,
        ]);
    }
}
