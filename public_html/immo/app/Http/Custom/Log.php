<?php
namespace App\Http\Custom;

use App\Events\ActionLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * @method static self ACTION_USER($type,$user_cible = null, $commentaire = null)
 *
 * @method static self ACTION_GENEGAL($type_action, $commentaire)
 */
class Log {
    public static function __callStatic($method, $args) {
        $method = strtoupper($method);
        $type = 'default';
        $second_arg = null;
        $third_arg = null;
        if(isset($args) && count($args) > 0) {
            $type = $args[0];
            if(isset($args[1])) $second_arg = $args[1];
            if(isset($args[2])) $third_arg = $args[2];
        }
        switch ($method) {

            case 'ACTION_GENEGAL':
                    event(new ActionLog($type, Auth::id(), $second_arg));
                break;

            default:
                    event(new ActionLog("Type non - défini", Auth::id(), $second_arg));
                break;
        }
    }

}
