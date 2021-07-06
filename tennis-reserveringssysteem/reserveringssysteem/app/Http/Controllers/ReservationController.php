<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReservationStoreRequest;
use App\Models\Court;
use App\Models\Reservation;
use App\Models\ReservationKind;
use App\Models\Setting;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use stdClass;

class ReservationController extends Controller
{
    /**
     * Where to redirect the user to when entering the application.
     */
    public function index()
    {
        return view('pages.reservations.index');
    }

    /**
     * Create a reservation and returning to the reservation/create view with the data to show.
     */
    public function create(Request $request)
    {
        if (Carbon::parse($request->date) < Carbon::today() || Carbon::parse($request->date) > Carbon::today()->addDay(14)) {
            return redirect(route('home', ['date' => Carbon::parse($request->date)->format('Y-m-d')]))->with('error', 'Je mag voor deze datum geen reservering doen.');
        }

        $users = User::where('member', '<>', null)->get();
        $authUser = Auth::user();
        $reservationsKinds = ReservationKind::get();
        $court = Court::where('id', $request->courts_id)->first();
        $setting = Setting::where('id', $authUser->clubs_id)->first();

        $filtered_users = $users->filter(function ($value, $key) use($authUser){
            return $value['id'] != $authUser->id;
        });

        foreach ($users as $user)
        {
            $userCount = Reservation::whereHas('users', function (Builder $query) use ($user) {
                $query->where('user_id', $user->id);
            })->count();

            if ($userCount >= $setting->amountOfReservations)
            {
                $filtered_users = $filtered_users->filter(function ($value, $key) use($user) {
                    return $value['id'] != $user->id;
                });
            }
        }

        $userCount = Reservation::whereHas('users', function (Builder $query) use ($authUser) {
            $query->where('user_id', $authUser->id);
        })->count();

        if ($userCount >= $setting->amountOfReservations)
        {
            $reservationsKinds->forget(0);
        }

        $information = new stdClass();
        $information->starttime = Carbon::parse($request->time);
        $information->endtime = Carbon::parse($request->time)->addMinutes($request->timeslot);
        $information->date = Carbon::parse($request->date);
        $information->courts_id = $request->courts_id;
        $information->courtNumber = $court->number;
        $information->courtType = $court->type;

        return view('pages.reservations.create', [
            'users' => $filtered_users,
            'user' => $authUser,
            'information' => $information,
            'reservationsKinds' => $reservationsKinds
        ]);
    }

    /**
     *  Store the reservation into the database.
     *  Check if the user is a member and make it a normal reservation.
     */
    public function store(ReservationStoreRequest $request)
    {
        DB::beginTransaction();

        try {
            $user = User::find($request->userId);

            $request->starttime = Carbon::parse($request->starttime)->format('H:i');
            $request->endtime = Carbon::parse($request->endtime)->format('H:i');
            $starttime = $request->date . ' ' . $request->starttime;
            $endtime = $request->date . ' ' . $request->endtime;

            $reservation = new Reservation();
            $reservation->starttime = Carbon::parse($starttime);
            $reservation->endtime = Carbon::parse($endtime);
            $reservation->courts_id = $request->courts_id;

            if (Auth::user()->roles_id == 3)
            {
                $reservation->reservations_kinds_id = 1;
            } else {
                $reservation->reservations_kinds_id = $request->reservationKind;
            }

            if ($request->nameEvent)
            {
                $reservation->nameEvent = $request->nameEvent;
            }

            $reservation->save();

            if ($request->users) {
                foreach($request->users as $member)
                {
                    $member = User::find($member);
                    $member->reservations()->attach($reservation);
                }
            }

            $user->reservations()->attach($reservation);
        } catch(Exception $e) {
            DB::rollback();
            // dd($e);
            return redirect()->back()->with('error', 'Er is iets fout gegaan.');
        }

        DB::commit();
        return redirect(route('home', ['date' => $request->date]))->with('success', 'Baan succesvol gereserveerd!');
    }
}
