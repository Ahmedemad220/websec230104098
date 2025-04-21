<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    public function list(Request $request)
    {
        $query = Product::query();

        $query->when($request->keywords, fn($q) =>
            $q->where("name", "like", "%$request->keywords%"));

        $query->when($request->min_price, fn($q) =>
            $q->where("price", ">=", $request->min_price));

        $query->when($request->max_price, fn($q) =>
            $q->where("price", "<=", $request->max_price));

        $query->when($request->order_by, fn($q) =>
            $q->orderBy($request->order_by, $request->order_direction ?? "ASC"));

        $products = $query->get();
        $customers = User::role('customer')->get();

        return view('products.list', compact('products', 'customers'));
    }

    public function purchase(Product $product)
    {
        $user = auth()->user();

        if ($user->credit < $product->price) {
            return view('errors.insufficient_credit');
        }

        if ($product->quantity <= 0) {
            return redirect()->back()->with('error', 'Out of stock!');
        }

        DB::transaction(function () use ($user, $product) {
            // 1. Create order
            Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'price' => $product->price,
                'status' => 'pending'
            ]);
            $product->decrement('quantity');
            $user->credit -= $product->price;
            $user->save();
        });

        return redirect()->route('products_list')->with('success', 'Purchase successful!');
    }

    public function myOrders()
    {
        $orders = \App\Models\Order::where('user_id', Auth::id())
            ->with(['product', 'user'])
            ->get();
    
        return view('products.orders', compact('orders'));
    }
    

    public function edit(Request $request, Product $product = null)
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized access.');
        }

        $product = $product ?? new Product();
        return view('products.edit', compact('product'));
    }

    public function save(Request $request, Product $product = null)
    {
        $validator = Validator::make($request->all(), [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
            'quantity' => ['required', 'integer'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized access.');
        }

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    public function delete(Product $product)
    {
        if (!Auth::user()->hasAnyRole(['Admin', 'Employee'])) {
            abort(403, 'Unauthorized action.');
        }

        if (!Auth::user()->can('delete_products')) {
            abort(403, 'Permission denied.');
        }

        $product->delete();
        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }

    public function listCustomers()
    {
        if (!Auth::user()->hasRole('Employee')) {
            abort(403, 'Only employees can view this.');
        }

        $customers = User::role('customer')->get();
        return view('employees.customers', compact('customers'));
    }

    public function addCredit(Request $request, User $customer)
    {
        if (!Auth::user()->hasRole('Employee')) {
            abort(403, 'Unauthorized action.');
        }

        $validator = Validator::make($request->all(), [
            'amount' => ['required', 'numeric', 'min:0.01'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $customer->increment('credit', $request->amount);

        return redirect()->back()->with('success', 'Credit added successfully.');
    }

public function listOrders()
{
    $orders = Order::with('product', 'user')->get();

    return view('products.listorders', compact('orders'));
}

public function updateStatus(Request $request, $orderId)
{
    $validated = $request->validate([
        'status' => 'required|string|in:pending,completed,canceled',
    ]);

    $order = Order::findOrFail($orderId);

    $order->status = $validated['status'];
    $order->save();

    return redirect()->route('orders.list')->with('success', 'Order status updated successfully.');
}




}
