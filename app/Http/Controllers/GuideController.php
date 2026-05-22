<?php

namespace App\Http\Controllers;

use App\Models\Guide;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(Request $request): View
    {
        $query = Guide::query()
            ->forPublic()
            ->with(['languages', 'locations']);

        $this->applyFilters($query, $request);
        $this->applySort($query, $request);

        $guides = $query->paginate(12)->withQueryString();

        $languages = Language::orderBy('name')->get();
        $locations = Location::orderBy('name')->get();

        $priceBounds = Guide::query()
            ->forPublic()
            ->selectRaw('MIN(price_per_day) as min_price, MAX(price_per_day) as max_price')
            ->first();

        return view('guides.index', [
            'guides' => $guides,
            'languages' => $languages,
            'locations' => $locations,
            'priceBounds' => $priceBounds,
            'filters' => $request->only([
                'q', 'location_id', 'language_id',
                'price_min', 'price_max',
                'experience_min', 'gender', 'sort',
            ]),
        ]);
    }

    public function show(Guide $guide): View
    {
        abort_unless(in_array($guide->status, [Guide::STATUS_AVAILABLE, Guide::STATUS_BUSY], true), 404);

        $guide->load(['languages', 'locations']);

        return view('guides.show', compact('guide'));
    }

    private function applyFilters($query, Request $request): void
    {
        if ($keyword = $request->input('q')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('full_name', 'like', "%{$keyword}%")
                    ->orWhere('description', 'like', "%{$keyword}%")
                    ->orWhere('address', 'like', "%{$keyword}%");
            });
        }

        if ($request->filled('location_id')) {
            $query->whereHas('locations', fn ($q) => $q->where('locations.id', $request->integer('location_id')));
        }

        if ($request->filled('language_id')) {
            $query->whereHas('languages', fn ($q) => $q->where('languages.id', $request->integer('language_id')));
        }

        if ($request->filled('price_min')) {
            $query->where('price_per_day', '>=', (float) $request->input('price_min'));
        }

        if ($request->filled('price_max')) {
            $query->where('price_per_day', '<=', (float) $request->input('price_max'));
        }

        if ($request->filled('experience_min')) {
            $query->where('experience_years', '>=', (int) $request->input('experience_min'));
        }

        if ($gender = $request->input('gender')) {
            $query->where('gender', $gender);
        }
    }

    private function applySort($query, Request $request): void
    {
        match ($request->input('sort')) {
            'price_asc' => $query->orderBy('price_per_day'),
            'price_desc' => $query->orderByDesc('price_per_day'),
            'experience_desc' => $query->orderByDesc('experience_years'),
            'name_asc' => $query->orderBy('full_name'),
            default => $query->orderByDesc('id'),
        };
    }
}
