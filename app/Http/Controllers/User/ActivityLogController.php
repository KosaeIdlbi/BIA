<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ActivityLogController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        $user = User::with(["ActivityLog" => function ($query) {
            $query->with("product")->orderBy("updated_at", "desc");
        }])->find(Auth::id());

        $user_profile = ["Electronics" => 0, "Cleaning_products" => 0, "Food" => 0, "Clothing" => 0];
        $Electronics = ActivityLog::whereHas("product", function ($query) {
            $query->where("category", "Electronics");
        })->where("user_id", $user->id)->get();
        // return dd($Electronics);
        $Cleaning_products = ActivityLog::whereHas("product", function ($query) {
            $query->where("category", "Cleaning products");
        })->where("user_id", $user->id)->get();
        $Food = ActivityLog::whereHas("product", function ($query) {
            $query->where("category", "Food");
        })->where("user_id", $user->id)->get();
        $Clothing = ActivityLog::whereHas("product", function ($query) {
            $query->where("category", "Clothing");
        })->where("user_id", $user->id)->get();
        foreach ($Electronics as $item) {
            $user_profile["Electronics"] = ($item->viewed) ? $user_profile["Electronics"] += 1 : $user_profile["Electronics"] += 0;
            $user_profile["Electronics"] = ($item->incart) ? $user_profile["Electronics"] += 3 : $user_profile["Electronics"] += 0;
            $user_profile["Electronics"] = ($item->purchased) ? $user_profile["Electronics"] += 7 : $user_profile["Electronics"] += 0;
            $user_profile["Electronics"] = ($item->rating) ? $user_profile["Electronics"] += $item->rating : $user_profile["Electronics"] += 0;
        }
        foreach ($Cleaning_products as $item) {
            $user_profile["Cleaning_products"] = ($item->viewed) ? $user_profile["Cleaning_products"] += 1 : $user_profile["Cleaning_products"] += 0;
            $user_profile["Cleaning_products"] = ($item->incart) ? $user_profile["Cleaning_products"] += 3 : $user_profile["Cleaning_products"] += 0;
            $user_profile["Cleaning_products"] = ($item->purchased) ? $user_profile["Cleaning_products"] += 7 : $user_profile["Cleaning_products"] += 0;
            $user_profile["Cleaning_products"] = ($item->rating) ? $user_profile["Cleaning_products"] += $item->rating : $user_profile["Cleaning_products"] += 0;
        }
        foreach ($Food as $item) {
            $user_profile["Food"] = ($item->viewed) ? $user_profile["Food"] += 1 : $user_profile["Food"] += 0;
            $user_profile["Food"] = ($item->incart) ? $user_profile["Food"] += 3 : $user_profile["Food"] += 0;
            $user_profile["Food"] = ($item->purchased) ? $user_profile["Food"] += 7 : $user_profile["Food"] += 0;
            $user_profile["Food"] = ($item->rating) ? $user_profile["Food"] += $item->rating : $user_profile["Food"] += 0;
        }
        foreach ($Clothing as $item) {
            $user_profile["Clothing"] = ($item->viewed) ? $user_profile["Clothing"] += 1 : $user_profile["Clothing"] += 0;
            $user_profile["Clothing"] = ($item->incart) ? $user_profile["Clothing"] += 3 : $user_profile["Clothing"] += 0;
            $user_profile["Clothing"] = ($item->purchased) ? $user_profile["Clothing"] += 7 : $user_profile["Clothing"] += 0;
            $user_profile["Clothing"] = ($item->rating) ? $user_profile["Clothing"] += $item->rating : $user_profile["Clothing"] += 0;
        }

        $total_score = array_reduce($user_profile, function ($carry, $item) {
            return $carry + $item;
        });
        foreach (array_keys($user_profile) as $item) {
            if ($total_score) {
                switch ($item) {
                    case "Electronics":
                        $user_profile["Electronics"] = (int)round(($user_profile["Electronics"] / $total_score) * 100);
                        break;
                    case "Cleaning_products":
                        $user_profile["Cleaning_products"] = (int)round(($user_profile["Cleaning_products"] / $total_score) * 100);
                        break;
                    case "Food":
                        $user_profile["Food"] = (int)round(($user_profile["Food"] / $total_score) * 100);
                        break;
                    case "Clothing":
                        $user_profile["Clothing"] = (int)round(($user_profile["Clothing"] / $total_score) * 100);
                        break;
                    default:
                        break;
                }
            }
        }
        return view("user.activity-log", ["user" => $user, "user_profile" => $user_profile]);
    }
}
