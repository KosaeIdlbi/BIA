<?php

namespace App\Livewire;

use App\Models\ActivityLog;
use App\Models\Product;
use Illuminate\Support\Facades\Http;
use Livewire\Component;
use Livewire\Attributes\Computed;

class Suggestions extends Component
{
    protected $listeners = ["refreshSuggestions"];
    public $user;
    public function refreshSuggestions()
    {
        return 0;
    }
    #[Computed()]
    public function suggestions()
    {
        if ($this->user) {
            $user_profile = ["Electronics" => 0, "Cleaning products" => 0, "Food" => 0, "Clothing" => 0];
            $Electronics = ActivityLog::whereHas("product", function ($query) {
                $query->where("category", "Electronics");
            })->where("user_id", $this->user->id)->get();
            // return dd($Electronics);
            $Cleaning_products = ActivityLog::whereHas("product", function ($query) {
                $query->where("category", "Cleaning products");
            })->where("user_id", $this->user->id)->get();
            $Food = ActivityLog::whereHas("product", function ($query) {
                $query->where("category", "Food");
            })->where("user_id", $this->user->id)->get();
            $Clothing = ActivityLog::whereHas("product", function ($query) {
                $query->where("category", "Clothing");
            })->where("user_id", $this->user->id)->get();
            foreach ($Electronics as $item) {
                $user_profile["Electronics"] = ($item->viewed) ? $user_profile["Electronics"] += 1 : $user_profile["Electronics"] += 0;
                $user_profile["Electronics"] = ($item->incart) ? $user_profile["Electronics"] += 3 : $user_profile["Electronics"] += 0;
                $user_profile["Electronics"] = ($item->purchased) ? $user_profile["Electronics"] += 7 : $user_profile["Electronics"] += 0;
                $user_profile["Electronics"] = ($item->rating) ? $user_profile["Electronics"] += $item->rating : $user_profile["Electronics"] += 0;
            }
            foreach ($Cleaning_products as $item) {
                $user_profile["Cleaning products"] = ($item->viewed) ? $user_profile["Cleaning products"] += 1 : $user_profile["Cleaning products"] += 0;
                $user_profile["Cleaning products"] = ($item->incart) ? $user_profile["Cleaning products"] += 3 : $user_profile["Cleaning products"] += 0;
                $user_profile["Cleaning products"] = ($item->purchased) ? $user_profile["Cleaning products"] += 7 : $user_profile["Cleaning products"] += 0;
                $user_profile["Cleaning products"] = ($item->rating) ? $user_profile["Cleaning products"] += $item->rating : $user_profile["Cleaning products"] += 0;
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
                        case "Cleaning products":
                            $user_profile["Cleaning products"] = (int)round(($user_profile["Cleaning products"] / $total_score) * 100);
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
            $Electronics = Product::with(["ActivityLog" => function ($query) {
                $query->where("user_id", $this->user->id);
            }])->where("category", "Electronics")->inRandomOrder()->take($user_profile["Electronics"])->get();
            $Cleaning_products = Product::with(["ActivityLog" => function ($query) {
                $query->where("user_id", $this->user->id);
            }])->where("category", "Cleaning products")->inRandomOrder()->take($user_profile["Cleaning products"])->get();
            $Food = Product::with(["ActivityLog" => function ($query) {
                $query->where("user_id", $this->user->id);
            }])->where("category", "Food")->inRandomOrder()->take($user_profile["Food"])->get();
            $Clothing = Product::with(["ActivityLog" => function ($query) {
                $query->where("user_id", $this->user->id);
            }])->where("category", "Clothing")->inRandomOrder()->take($user_profile["Clothing"])->get();

            $products = [];
            foreach ($Electronics as $item) {
                if ($item->ActivityLog->first()) {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => $item->ActivityLog->first()->rating, // تفضيل rating من النشاط إن وجد
                        'clicked' => $item->ActivityLog->first()->incart, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => $item->ActivityLog->first()->viewed,
                        'purchased' => $item->ActivityLog->first()->purchased,
                    ];
                } else {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => 0, // تفضيل rating من النشاط إن وجد
                        'clicked' => 0, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => 0,
                        'purchased' => 0,
                    ];
                }
            }
            foreach ($Cleaning_products as $item) {
                if ($item->ActivityLog->first()) {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => $item->ActivityLog->first()->rating, // تفضيل rating من النشاط إن وجد
                        'clicked' => $item->ActivityLog->first()->incart, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => $item->ActivityLog->first()->viewed,
                        'purchased' => $item->ActivityLog->first()->purchased,
                    ];
                } else {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => 0, // تفضيل rating من النشاط إن وجد
                        'clicked' => 0, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => 0,
                        'purchased' => 0,
                    ];
                }
            }
            foreach ($Food as $item) {
                if ($item->ActivityLog->first()) {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => $item->ActivityLog->first()->rating, // تفضيل rating من النشاط إن وجد
                        'clicked' => $item->ActivityLog->first()->incart, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => $item->ActivityLog->first()->viewed,
                        'purchased' => $item->ActivityLog->first()->purchased,
                    ];
                } else {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => 0, // تفضيل rating من النشاط إن وجد
                        'clicked' => 0, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => 0,
                        'purchased' => 0,
                    ];
                }
            }
            foreach ($Clothing as $item) {
                if ($item->ActivityLog->first()) {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => $item->ActivityLog->first()->rating, // تفضيل rating من النشاط إن وجد
                        'clicked' => $item->ActivityLog->first()->incart, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => $item->ActivityLog->first()->viewed,
                        'purchased' => $item->ActivityLog->first()->purchased,
                    ];
                } else {
                    $products[] = [
                        'id' => $item->id,
                        'category' => $item->category,
                        'rating' => 0, // تفضيل rating من النشاط إن وجد
                        'clicked' => 0, // إذا لم يكن لديك حقل clicked، يمكنك حسابه
                        'viewd' => 0,
                        'purchased' => 0,
                    ];
                }
            }

            $data = [];
            $data['user_profile'] = $user_profile;
            $data['products'] = $products;
            // return json_encode($data);
            $response = Http::withHeaders([
                "x-vercel-protection-bypass" => "0Hdm1ZFrqAGIBMlgADiZCEEl90KBOOrJ",
                'api-key' => 'SABVGDFCUWQAHVDFCANSJC431243##4544@GASGDCgdcfgs',
            ])->post('https://genetic-alogrithm-api.vercel.app/recommend', $data); // {"recommended_products":[94,94,94,94,94]}

            return Product::inRandomOrder()->whereIn("id", $response->json()['recommended_products'])->get();
            // return $response->json();
        }
        return Product::inRandomOrder()->take(4)->get();
    }
    public function render()
    {
        return view('livewire.suggestions', ["suggestions" => $this->suggestions]);
    }
}
