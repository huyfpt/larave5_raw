<?php

namespace Hegyd\Plans\Controllers\Frontend;

use Hegyd\Plans\Models\Plans;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PlansController
{
    public function index()
    {
        $plans = Plans::where('active', true)
                        ->where('start_at', '<=', Carbon::now())
                        ->where('end_at', '>=', Carbon::now())
                        ->orderBy('id', 'desc')->paginate(15);

        return view('hegyd-plans::frontend.plans.index', compact('plans'));
    }

    public function show(Request $request)
    {
        $plan = Plans::where('slug', $request->slug)->first();

        return view('hegyd-plans::frontend.plans.show', compact('plan'));
    }
}