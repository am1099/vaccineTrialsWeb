<?php

namespace App\Http\Controllers;


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Response;


use App\Models\Volunteer;
use App\Models\Vaccine;


class VolunteerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function createVolunteer()
    {

        return view('signup');
    }

    public function getAllvolunteers()
    {

        $volunteers =  Volunteer::get();

        $infected_volunteers =  Volunteer::where('infected','yes')                
                                ->get();

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


        if (count($infected_volunteers) > 10){

            // Display all results regardless of vaccine group or dose
        $getTrialResults = json_encode([
            [
            'name' => 'SLCV2020',
            'type' => 'Vaccine',
            'vaccineGroup' => 'B',
            'efficiency' => round((($unvaccinated->count() - $vaccinated->count() )/ $unvaccinated->count()),4),
            'result' => ['volunteer' => count($volunteers), 'confirm_positive' => count($vaccinated)],
            ],[
            'name' => 'Unknown',
            'type' => 'Placebo',
            'vaccineGroup' => 'A',
            'result' => ['volunteer' => count($volunteers), 'confirm_positive' => count($unvaccinated)]]], JSON_PRETTY_PRINT);

            return view('restfulApi_allresults', compact('getTrialResults'));
        }else{

            $getTrialResults = json_encode([
                'error_message' => "Phase 3 Trial in progress, please wait.",
                ], JSON_PRETTY_PRINT);
    
                return view('restfulApi_allresults', compact('getTrialResults'));

        }


    }

    public function getResultsBy($vaccineGroup, $dose){

        $infected_volunteers =  Volunteer::where('infected','yes')                
                                ->get();

        $volunteersByG_D =  DB::table('vaccines')
        ->select('vaccines.*')
        ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
        ->where('volunteers.dose', $dose)
        ->where('volunteers.vaccineGroup', $vaccineGroup)
        ->get();

        // number of positive cases by vaccine group and by dose
        $numOfPosByG_D = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('volunteers.dose', $dose)
            ->where('volunteers.vaccineGroup', $vaccineGroup)
            ->get();

        // SQL 1 & 2 To get number of positive cases from each vaccine group

        $unvaccinated = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('volunteers.dose', $dose)
            ->where('volunteers.vaccineGroup', $vaccineGroup)
            ->get();

            $vaccineGroupResult = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.infected', 'yes')
            ->where('volunteers.vaccineGroup', $vaccineGroup)
            ->get()->first();

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


        /// A : SLCV2020 - vaccine  -- efficiency rate of vaccine
        $group_A_dose_half = round((($unvaccinated_halfDose->count() - $vaccinated_halfDose->count() )/ $unvaccinated_halfDose->count()),4);
        $group_A_dose_full = round((($unvaccinated_fullDose->count() - $vaccinated_fullDose->count() )/ $unvaccinated_fullDose->count()),4);

        if ($vaccineGroup == 'A' && $dose == 0.5){
            
            $efficiency_result = $group_A_dose_half;

        }elseif($vaccineGroup == 'A' && $dose == 1.0){
            
            $efficiency_result = $group_A_dose_full;
        }

        //////////////////////////////
        // if threshold of 10 positive casses is exceeded then allow results to be shown otherwise display error

        if (count($infected_volunteers) > 10){
        
            if ($vaccineGroup == 'A'){

                $getTrialResultsByG_D = json_encode(
                    
                    [
                    'name' => $vaccineGroupResult->name,
                    'type' => $vaccineGroupResult->type,
                    'vaccineGroup' => $vaccineGroup,
                    'dose' => $dose,
                    'efficiency' => $efficiency_result,
                    'result' => ['volunteer' => count($volunteersByG_D), 'confirm_positive' => count($numOfPosByG_D)],

                    ], JSON_PRETTY_PRINT);

                    return view('restfulApi_resultsByG_D', compact('getTrialResultsByG_D'));


            }elseif($vaccineGroup == 'B'){

                $getTrialResultsByG_D = json_encode([
                    'name' => $vaccineGroupResult->name,
                    'type' => $vaccineGroupResult->type,
                    'vaccineGroup' => $vaccineGroup,
                    'dose' => $dose,
                    'result' => ['volunteer' => count($volunteersByG_D), 'confirm_positive' => count($numOfPosByG_D)],
                    ], JSON_PRETTY_PRINT);
        
                    return view('restfulApi_resultsByG_D', compact('getTrialResultsByG_D'));            }
        }else{

            $getTrialResultsByG_D = json_encode([
                'error_message' => "Phase 3 Trial in progress, please wait.",
                ], JSON_PRETTY_PRINT);
    
                return view('restfulApi_resultsByG_D', compact('getTrialResultsByG_D'));        }
    }

    public function storeVolunteer(Request $req)
    {

        $req->validate(
            [
                'email' => ['required', 'string', 'email', 'max:255', 'unique:volunteers'],
                'fullname' => ['required', 'string', 'max:255', 'regex:/(.+)( )(.+)/'],
                'gender' => ['required', 'string'],
                'age' => ['required', 'int', 'min:18', 'max:150'],
                'passwordHash' => ['required', 'string', 'min:8', 'unique:volunteers'],
                'address' => ['required', 'string'],

            ],

            ['fullname.regex' => 'Incorrect Name Format, please include your first and last name.'],
            ['age.min' => 'You must be 18 or over to register as a volunteer!']

        );

        $volunteer = new Volunteer();

        $volunteer->email = $req->email;
        $volunteer->fullname = $req->fullname;
        $volunteer->gender = $req->gender;
        $volunteer->age = $req->age;
        $volunteer->address = $req->address;
        $volunteer->health_condition = $req->health_condition;

        $volunteer->passwordHash = Hash::make($req->passwordHash);

        $volunteer->save();

        return redirect('login')->with('success', 'You have successfully been registerd! Login below');
    }

    public function displayVolunteer($email)
    {

        $email_decrypt = Crypt::decrypt($email);
        $volunteers = Volunteer::Where('email', $email_decrypt)->first();

        $pos_numbers = Volunteer::Where('infected', 'yes')->get();


        $vaccineType = DB::table('vaccines')
            ->select('vaccines.*')
            ->join('volunteers', 'vaccines.vaccineGroup', '=', 'volunteers.vaccineGroup')
            ->where('volunteers.email', $email_decrypt)
            ->get();


        return view('V_Dashboard', compact('volunteers', 'pos_numbers', 'vaccineType'));
    }

    public function checkQR(Request $req, $email)
    {

        $vaccineType = $req->input('vaccine');
        $dose = $req->input('dose');

        Volunteer::where('email', $email)->update(['vaccineGroup' => $vaccineType, 'dose' => $dose]);
    }

    public function reportPositive($email){
        Volunteer::where('email', $email)->update(['infected' => 'yes']);
        $email = Crypt::encrypt($email);

        return redirect(route('displayvolunteers', $email))->with('report', 'Successfully reported positive');
    }

    public function viewVolunteer($email)
    {

        $volunteer = Volunteer::Where('email', $email)->first();

        return view('V_Dashboard', compact('volunteer'));
    }
}
