<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    // ✅ LIST PRODUCTS (For Customers & Employees)
    public function list(Request $request)
    {
        $query = Product::query();

        // Filters
        $query->when($request->keywords, fn($q) => 
            $q->where("name", "like", "%$request->keywords%"));

        $query->when($request->min_price, fn($q) => 
            $q->where("price", ">=", $request->min_price));

        $query->when($request->max_price, fn($q) => 
            $q->where("price", "<=", $request->max_price));

        $query->when($request->order_by, fn($q) => 
            $q->orderBy($request->order_by, $request->order_direction ?? "ASC"));

        $products = $query->get();

        return view('products.list', compact('products'));
    }

    // ✅ PURCHASE PRODUCT (For Customers)
    public function purchase(Request $request, Product $product)
    {
        $user = Auth::user();

        if (!$user->hasRole('customer')) {
            abort(403, 'Only customers can make purchases.');
        }

        // Check if product is in stock
        if ($product->stock < 1) {
            return redirect()->back()->with('error', 'Product is out of stock.');
        }

        // Check if user has enough credit
        if ($user->credit < $product->price) {
            return redirect()->back()->with('error', 'Insufficient account credit.');
        }

        // Deduct credit & decrease stock
        DB::transaction(function () use ($user, $product) {
            $user->decrement('credit', $product->price);
            $product->decrement('stock');

            Order::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'price' => $product->price,
            ]);
        });

        return redirect()->route('products_list')->with('success', 'Purchase successful!');
    }

    // ✅ LIST CUSTOMER'S PURCHASED PRODUCTS
    public function myOrders()
    {
        $orders = Order::where('user_id', Auth::id())->with('product')->get();
        return view('products.orders', compact('orders'));
    }

    // ✅ EDIT PRODUCT (For Employees & Admin)
    public function edit(Request $request, Product $product = null)
    {
        if (!Auth::user()->hasAnyRole(['admin', 'employee'])) {
            abort(403, 'Unauthorized access.');
        }

        $product = $product ?? new Product();
        return view('products.edit', compact('product'));
    }

    // ✅ SAVE PRODUCT (For Employees & Admin)
    public function save(Request $request, Product $product = null)
    {
        $this->validate($request, [
            'code' => ['required', 'string', 'max:32'],
            'name' => ['required', 'string', 'max:128'],
            'model' => ['required', 'string', 'max:256'],
            'description' => ['required', 'string', 'max:1024'],
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer'],
        ]);

        if (!Auth::user()->hasAnyRole(['admin', 'employee'])) {
            abort(403, 'Unauthorized access.');
        }

        $product = $product ?? new Product();
        $product->fill($request->all());
        $product->save();

        return redirect()->route('products_list')->with('success', 'Product saved successfully.');
    }

    // ✅ DELETE PRODUCT (For Employees & Admin)
    public function delete(Product $product)
    {
        if (!Auth::user()->hasPermissionTo('delete_products')) {
            abort(403, 'Unauthorized action.');
        }

        $product->delete();
        return redirect()->route('products_list')->with('success', 'Product deleted successfully.');
    }

    // ✅ LIST CUSTOMERS (For Employees)
    public function listCustomers()
    {
        if (!Auth::user()->hasRole('employee')) {
            abort(403, 'Only employees can view this.');
        }

        $customers = User::where('role', 'customer')->get();
        return view('employees.customers', compact('customers'));
    }

    // ✅ ADD CREDIT TO CUSTOMER (For Employees)
    public function addCredit(Request $request, User $customer)
    {
        if (!Auth::user()->hasRole('employee')) {
            abort(403, 'Unauthorized action.');
        }

        $this->validate($request, [
            'amount' => ['required', 'numeric', 'min:1'],
        ]);

        $customer->increment('credit', $request->amount);

        return redirect()->back()->with('success', 'Credit added successfully.');
    }
}
