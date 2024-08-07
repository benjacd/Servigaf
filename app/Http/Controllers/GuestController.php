<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductSearchRequest;
use Illuminate\Contracts\View\View;
use App\Models\Product;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategoryGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Response;
use App\Models\Repair;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index(): View
    {
        $featured_products = Product::where('is_featured', '1') ->take(8)->get();
        return view('posts.index', compact('featured_products'));
    }


    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        return view('posts.show', compact('product'));
    }

    public function show_cart(): View
    {
        $products = Cart::content();
        return view('posts.mostrarCarro', compact('products'));
    }

    public function agendarHora(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user) {
            // Usuario autenticado
            if (!$user->client) {
                // Usuario autenticado pero sin cliente asociado
                return redirect()->route('client.create')->with('message', 'Por favor, crea un perfil de cliente para agendar una hora.');
            } else {
                // Usuario autenticado y con cliente asociado
                $client = $user->client;

                // Obtener las horas reservadas y aprobadas
                $reservedDates = Repair::where('repair_accepted', true)
                                      ->pluck('repair_date')
                                      ->toArray();

                return view('posts.agendar', compact('client', 'reservedDates'));
            }
        } else {
            // Usuario no autenticado
            return redirect()->route('login')->with('message', 'Por favor, inicia sesión para agendar una hora.');
        }
    }


    public function search(ProductSearchRequest $request)
    {
        $search_query = $request->validated()['search'];

        $products = Product::leftjoin('categories', 'products.category_id', '=', 'categories.id')
                            ->leftjoin('category_groups', 'categories.category_group_id', '=', 'category_groups.id')
                            ->where('products.name', 'like', "%$search_query%")
                            ->orWhere('categories.name', 'like', "%$search_query%")
                            ->orWhere('products.brand', 'like', "%$search_query%")
                            ->orWhere('group_name', 'like', "%$search_query%")
                            ->orwhere('description', 'like', "%$search_query%")
                            ->select('products.*')
                            ->paginate(12);

        $products->appends(["search"=>$search_query]);

        return view('posts.search-result',['products' => $products]);
        // ->with('products', $products);
    }

    public function show_category($category): View
    {
        $products = Product::join('categories', 'products.category_id', '=', 'categories.id')
                            ->join('category_groups', 'categories.category_group_id', '=', 'category_groups.id')
                            ->where('categories.name', 'like', "%$category%")
                            ->orWhere('group_name', 'like', "%$category%")
                            ->select('products.*')
                            ->paginate(12);

        $products->appends(["category"=>$category]);

        return view('posts.mostrarCategoria',['products' => $products]);
    }
}
