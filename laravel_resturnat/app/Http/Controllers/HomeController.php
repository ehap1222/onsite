<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $meals = Meal::with('category')->latest()->get();
        $categories = Category::all();
        return view('welcome', compact('meals', 'categories'));
    }

    public function category($id)
    {
        $category = Category::findOrFail($id);
        $meals = Meal::where('category_id', $id)->with('category')->latest()->get();
        $categories = Category::all();
        return view('welcome', compact('meals', 'categories', 'category'));
    }
}
