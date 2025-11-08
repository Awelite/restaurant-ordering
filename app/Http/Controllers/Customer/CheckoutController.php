<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\MenuItem;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    // show checkout page
    public function show()
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Your cart is empty.');
        }

        // calculate total
        $total = 0;
        foreach ($cart as $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        return view('customer.checkout.show', compact('cart', 'total'));
    }

    // process checkout
    public function process(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:1000',
            'phone'   => 'required|string|max:20',
            'payment_method' => 'required|in:COD,Razorpay',
            'address_lat' => 'nullable|numeric',
            'address_lng' => 'nullable|numeric',
            'notes' => 'nullable|string|max:1000',
        ]);

        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('customer.menu')->with('error', 'Cart is empty.');
        }

        // total calculation server-side
        $total = 0;
        foreach ($cart as $id => $item) {
            $total += ($item['price'] * $item['quantity']);
        }

        // Optional: distance check (example center point = restaurant lat/lng)
        // if you want a radius check, configure RESTAURANT_LAT/LNG and MAX_DELIVERY_KM in .env
        if ($request->address_lat && $request->address_lng) {
            $restLat = config('restaurant.latitude', env('RESTAURANT_LAT', null));
            $restLng = config('restaurant.longitude', env('RESTAURANT_LNG', null));
            $maxKm = env('MAX_DELIVERY_KM', null);

            if ($restLat && $restLng && $maxKm) {
                $distance = $this->haversineDistance($restLat, $restLng, $request->address_lat, $request->address_lng);
                if ($distance > (float)$maxKm) {
                    return back()->withInput()->with('error', "Sorry — delivery address is outside our delivery radius ({$maxKm} km).");
                }
            }
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => Auth::id(),
                'status' => 'pending',
                'payment_method' => $request->payment_method,
                'address' => $request->address,
                'address_lat' => $request->address_lat,
                'address_lng' => $request->address_lng,
                'phone' => $request->phone,
                'notes' => $request->notes,
                'total_amount' => $total,
            ]);

            // create order items
            foreach ($cart as $menuItemId => $cartItem) {
                $menu = MenuItem::find($menuItemId);
                if (!$menu) {
                    // skip missing menu items
                    continue;
                }
                OrderItem::create([
                    'order_id' => $order->id,
                    'menu_item_id' => $menu->id,
                    'quantity' => $cartItem['quantity'],
                    'price' => $cartItem['price'],
                ]);
            }

            DB::commit();

            // Clear cart
            session()->forget('cart');

            // Redirect to success / receipt page
            return redirect()->route('customer.order.success', $order->id);
        } catch (\Throwable $e) {
            DB::rollBack();
            \Log::error('Checkout error: '.$e->getMessage());
            return back()->withInput()->with('error', 'Something went wrong while placing the order. Please try again.');
        }
    }

    // show success / receipt
    public function success(Order $order)
    {
        // ensure the logged-in user owns the order (or admin)
        if (auth()->id() !== $order->user_id && auth()->user()->role !== 'admin') {
            abort(403);
        }

        $order->load('orderItems.menuItem');

        return view('customer.checkout.success', compact('order'));
    }

    // Haversine function (kilometres)
    protected function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km

        $latFrom = deg2rad($lat1);
        $lonFrom = deg2rad($lon1);
        $latTo = deg2rad($lat2);
        $lonTo = deg2rad($lon2);

        $latDelta = $latTo - $latFrom;
        $lonDelta = $lonTo - $lonFrom;

        $a = sin($latDelta / 2) * sin($latDelta / 2) +
             cos($latFrom) * cos($latTo) *
             sin($lonDelta / 2) * sin($lonDelta / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }
}
