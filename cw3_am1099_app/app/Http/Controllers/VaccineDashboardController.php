<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Crypt;

use App\Models\Volunteer;
use App\Models\Vaccine;


class VaccineDashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function display_normal_stats()
    {
        $stats = Volunteer::all();
        $stats_pos = Volunteer::Where('infected', 'yes')->get();

        // SQL 1 & 2 To get number of positive cases from each vaccine group

        $vaccinated = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('volunteers.vaccineGroup', 'B')
            ->get();

        $unvaccinated = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('volunteers.vaccineGroup', 'A')
            ->get();

        // SQL 3 & 4 To get number of positive cases from each vaccine group with 0.5 dose

        $vaccinated_halfDose = DB::table('volunteers')
            ->select('volunteers.*')
            ->join('vaccines', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('vaccines.vaccineGroup', 'B')
            ->where('volunteers.dose', '0.5')
            ->get();

        $unvaccinated_halfDose = DB::table('volunteers')
            ->select('volunteers.*')
            ->join('vaccines', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('vaccines.vaccineGroup', 'A')
            ->where('volunteers.dose', '0.5')
            ->get();

        //SQL 5 & 6 To get number of positive cases from each vaccine group with 1 dose

        $vaccinated_fullDose = DB::table('volunteers')
            ->select('volunteers.*')
            ->join('vaccines', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('vaccines.vaccineGroup', 'B')
            ->where('volunteers.dose', '1')
            ->get();

        $unvaccinated_fullDose = DB::table('volunteers')
            ->select('volunteers.*')
            ->join('vaccines', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('vaccines.vaccineGroup', 'A')
            ->where('volunteers.dose', '1')
            ->get();

        // dd($unvaccinated_fullDose->count());

        return view('VM_Dashboard', 
                compact('stats', 'stats_pos', 'vaccinated', 'unvaccinated','vaccinated_halfDose' ,'unvaccinated_halfDose' ,'vaccinated_fullDose' ,'unvaccinated_fullDose'));
    }
}
