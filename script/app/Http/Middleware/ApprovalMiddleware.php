<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class ApprovalMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check() && Auth::User()->status == 'approved' || Auth::User()->status == 'offline')
        {
            return $next($request);
        }else{
            if ((Auth::User()->role->id == 3 || Auth::User()->role->id == 5) && (Auth::User()->paymentStatus == '0')){
                return redirect()->route('restaurant.register_step_2');
            }
            else if (Auth::User()->role->id == 6) {
                return redirect()->route('restaurant.register_step_4');
                // if (empty(Auth::User()->business_name)) {
                //     return redirect()->route('restaurant.register_step_2');
                // } else if (empty(Auth::User()->cuisine)) {
                //     return redirect()->route('restaurant.register_step_3');
                // }
            } else {
                return redirect()->route('baker.register_step_4');
                // if (empty(Auth::User()->business_name)) {
                //     return redirect()->route('baker.register_step_2');
                // } else if (empty(Auth::User()->can_you_deliver)) {
                //     return redirect()->route('baker.register_step_3');
                // }
            }

        }
    }
}
