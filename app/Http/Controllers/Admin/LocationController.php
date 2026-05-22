<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LocationRequest;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LocationController extends Controller
{
    public function index(): View
    {
        $locations = Location::query()
            ->withCount('guides')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.locations.index', compact('locations'));
    }

    public function create(): View
    {
        return view('admin.locations.create');
    }

    public function store(LocationRequest $request): RedirectResponse
    {
        Location::create($request->validated());

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Thêm địa điểm thành công.');
    }

    public function edit(Location $location): View
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(LocationRequest $request, Location $location): RedirectResponse
    {
        $location->update($request->validated());

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Cập nhật địa điểm thành công.');
    }

    public function destroy(Location $location): RedirectResponse
    {
        $location->guides()->detach();
        $location->delete();

        return redirect()
            ->route('admin.locations.index')
            ->with('success', 'Đã xóa địa điểm.');
    }
}
