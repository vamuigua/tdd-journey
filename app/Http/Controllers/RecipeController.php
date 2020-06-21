<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RecipeController extends Controller
{
    // Get all recipies
    public function all()
    {
        return Auth::user()->recipes;
    }

    // Show a single recipe's details
    public function show(Recipe $recipe)
    {
        // Check if the user is the owner of the recipe
        if ($recipe->publisher_id != Auth::id()) {
            abort(404);
            return;
        }
        return $recipe->toJson();
    }

    // create a new recipe
    public function create(Request $request)
    {
        // Validate request
        $this->validate($request, [
            'title' => 'required',
            'procedure' => 'required|min:8'
        ]);

        // Create recipe and attach to user
        $user = Auth::user();
        $recipe = Recipe::create($request->only('title', 'procedure'));
        $user->recipes()->save($recipe);

        return $recipe->toJson();
    }

    // Update recipe and return
    public function update(Request $request, Recipe $recipe)
    {
        // Check if the user is the owner of the recipe
        if ($recipe->publisher_id != Auth::id()) {
            abort(404);
            return;
        }

        // Update and return
        $recipe->update($request->only('title', 'procedure'));
        return $recipe->toJson();
    }


    // Delete a recipe
    public function delete(Recipe $recipe)
    {
        // Check if the user is the owner of the recipe
        if ($recipe->publisher_id != Auth::id()) {
            abort(404);
            return;
        }
        $recipe->delete();
    }
}
