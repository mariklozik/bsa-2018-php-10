<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Entity\Currency;
use App\Jobs\SendRateChangedEmail;

class CurrencyControllerApi extends Controller
{
    public function update(Request $request)
    {

//        if (Gate::denies('admin')) {
//            return redirect('/');
//        }
        $currency = Currency::find($request->id);

        $oldRate = $currency->rate;
        $newRate = $request->input('rate');

        $currency->rate = $newRate;
        $currency->save();

        $this->sendChangeRateEmail($currency, $oldRate);
        return response()->json($currency, 200);
    }

    private function sendChangeRateEmail(Currency $currency, float $oldRate) : void
    {
        $users = User::where('is_admin', false)->get();
        foreach ($users as $user) {
            SendRateChangedEmail::dispatch($user, $currency, $oldRate)->onQueue('notification');
        }
    }
}
