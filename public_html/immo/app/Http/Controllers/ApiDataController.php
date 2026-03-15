<?php

namespace App\Http\Controllers;

use App\Models\Departement;
use App\Models\Direction;
use App\Models\Service;
use Illuminate\Support\Facades\DB;

class ApiDataController extends Controller
{
    static function saveOrUpdateDirections(){
        $centralisatonKey = urlencode(env("CENTRALISATION_KEY"));
        $centralisatonLink = env("CENTRALISATION_LINK");
        try {
            $data = file_get_contents($centralisatonLink."api/directions?centralisation_key=$centralisatonKey");

            $data = json_decode($data);

            if($data && count($data)) {
                foreach ($data as $directionTemp) {
                    $directionTemp = (array) $directionTemp;
                    unset($directionTemp['created_at']);
                    unset($directionTemp['updated_at']);
                    $direction = Direction::find($directionTemp["id"]);
                    if($direction) $direction->update($directionTemp);
                    else DB::table('directions')->insertOrIgnore($directionTemp);
                }
                return true;
            }

        } catch (\Throwable $th) {
            // dd($th->getMessage());
            return false;
        }
    }

    static function saveOrUpdateServices(){
        $centralisatonKey = urlencode(env("CENTRALISATION_KEY"));
        $centralisatonLink = env("CENTRALISATION_LINK");

        if(self::saveOrUpdateDirections() && self::saveOrUpdateDepartements()) {
            try {
                $data = file_get_contents($centralisatonLink."api/services?centralisation_key=$centralisatonKey");

                $data = json_decode($data);

                if($data && count($data)) {
                    foreach ($data as $serviceTemp) {
                        $serviceTemp = (array) $serviceTemp;
                        unset($serviceTemp['created_at']);
                        unset($serviceTemp['updated_at']);
                        $service = Service::find($serviceTemp["id"]);
                        if($service) $service->update($serviceTemp);
                        else DB::table('services')->insertOrIgnore($serviceTemp);

                    }
                    return true;
                }

            } catch (\Throwable $th) {
                dd($th->getMessage());
                return false;
            }
        }

        return false;
    }

    static function saveOrUpdateDepartements()
    {
        $centralisatonKey = urlencode(env("CENTRALISATION_KEY"));
        $centralisatonLink = env("CENTRALISATION_LINK");

        if(self::saveOrUpdateDirections())  {
            try {
                $data = file_get_contents($centralisatonLink."api/departements?centralisation_key=$centralisatonKey");

                $data = json_decode($data);

                if($data && count($data)) {
                    foreach ($data as $departementTemp) {
                        $departementTemp = (array) $departementTemp;
                        unset($departementTemp['created_at']);
                        unset($departementTemp['updated_at']);
                        $departement = Departement::find($departementTemp["id"]);
                        if($departement) $departement->update($departementTemp);
                        else DB::table('departements')->insertOrIgnore($departementTemp);
                    }
                    return true;
                }

            } catch (\Throwable $th) {
                // dd($th->getMessage());
                return false;
            }
        }
        return false;
    }
}
