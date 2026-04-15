<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\TrackAudience;
use Illuminate\Http\Request;

class TrackingController extends Controller
{
    //
    public function redirect(Product $product, Request $request)
    {
        $ip = $request->ip();

        // 🔥 optional anti spam (1 click per 1 jam per IP)
        $exists = TrackAudience::where('product_id', $product->id)
            ->where('ip_address', $ip)
            ->where('created_at', '>=', now()->subHour())
            ->exists();

        if (! $exists) {
            TrackAudience::create([
                'product_id' => $product->id,
                'ip_address' => $ip,
                'user_agent' => $request->userAgent(),
            ]);
        }

        // 🔥 redirect ke affiliate link asli
        return redirect($product->link);
    }
}
