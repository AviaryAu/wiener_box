<?php

namespace App\Http\Controllers;

use App\Models\DeliveryArea;
use App\Models\WaitlistEntry;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class LaunchController extends Controller
{
    public function check(Request $request): JsonResponse
    {
        $data = $request->validate(['postcode' => ['required', 'string', 'regex:/^[0-9]{4}$/']]);
        $area = DeliveryArea::where('postcode', $data['postcode'])->where('status', 'planned')->first();

        return response()->json([
            'postcode' => $data['postcode'], 'planned' => (bool) $area, 'available' => false,
            'suburb' => $area?->suburb, 'price' => $area?->price,
            'message' => $area ? 'Your area is in our proposed Sydney launch zone. Join the list for confirmation when delivery opens.' : 'We haven’t confirmed delivery to your postcode yet. Join the list to help us plan where to go next.',
        ]);
    }

    public function waitlist(Request $request): RedirectResponse
    {
        $request->merge(['email' => strtolower(trim((string) $request->input('email')))]);
        $data = $request->validate([
            'email' => 'required|email|max:254', 'postcode' => ['required', 'string', 'regex:/^[0-9]{4}$/'],
            'interest' => 'required|in:subscription,gift,shop', 'consent' => 'accepted', 'website' => 'nullable|max:0',
        ]);
        WaitlistEntry::firstOrCreate(['email' => $data['email']], [
            'postcode' => $data['postcode'], 'interest' => $data['interest'],
            'consented_at' => now(), 'consent_version' => 'launch-v1',
        ]);

        return back()->with('message', 'You’re on the list! We’ll email when we have launch news for you.');
    }
}
