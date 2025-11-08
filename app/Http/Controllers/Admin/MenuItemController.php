<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;

class MenuItemController extends Controller
{
    /**
     * Display all menu items.
     */
    public function index()
    {
        // ✅ Eager load category to prevent N+1
        $menuItems = MenuItem::with('category')->latest()->get();

        return view('admin.menu.index', compact('menuItems'));
    }

    /**
     * Show form for creating a new menu item.
     */
    public function create()
    {
        // ✅ Fetch all categories for dropdown
        $categories = Category::orderBy('name')->get();
        return view('admin.menu.create', compact('categories'));
    }

    /**
     * Store a newly created menu item.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|max:2048',
        ]);

        // ✅ Handle image upload
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        // ✅ Checkbox fix — convert to boolean
        $validated['available'] = $request->boolean('available');

        // ✅ Create new record
        MenuItem::create($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item added successfully!');
    }

    /**
     * Show form for editing a menu item.
     */
    public function edit(MenuItem $menu)
    {
        $categories = Category::orderBy('name')->get();

        return view('admin.menu.edit', [
            'menuItem'  => $menu,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified menu item.
     */
    public function update(Request $request, MenuItem $menu)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'category_id'  => 'required|exists:categories,id',
            'description'  => 'nullable|string',
            'price'        => 'required|numeric|min:0',
            'image'        => 'nullable|image|max:2048',
        ]);

        // ✅ Handle image upload/update
        if ($request->hasFile('image')) {
            if ($menu->image && Storage::disk('public')->exists($menu->image)) {
                Storage::disk('public')->delete($menu->image);
            }
            $validated['image'] = $request->file('image')->store('menu', 'public');
        }

        // ✅ Checkbox fix — convert to boolean
        $validated['available'] = $request->boolean('available');

        // ✅ Update the record
        $menu->update($validated);

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item updated successfully!');
    }

    /**
     * Remove a menu item.
     */
    public function destroy(MenuItem $menu)
    {
        if ($menu->image && Storage::disk('public')->exists($menu->image)) {
            Storage::disk('public')->delete($menu->image);
        }

        $menu->delete();

        return redirect()
            ->route('admin.menu.index')
            ->with('success', 'Menu item deleted successfully!');
    }
}
