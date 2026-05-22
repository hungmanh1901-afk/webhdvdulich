<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\GuideRequest;
use App\Models\Guide;
use App\Models\Language;
use App\Models\Location;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class GuideController extends Controller
{
    public function index(): View
    {
        $guides = Guide::query()
            ->with(['languages', 'locations'])
            ->latest('id')
            ->paginate(10);

        return view('admin.guides.index', compact('guides'));
    }

    public function create(): View
    {
        return view('admin.guides.create', $this->formData());
    }

    public function store(GuideRequest $request): RedirectResponse
    {
        $data = $this->guideAttributes($request);

        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar')->store('guides', 'public');
        }

        $guide = Guide::create($data);
        $this->syncRelations($guide, $request);

        return redirect()
            ->route('admin.guides.index')
            ->with('success', 'Thêm hướng dẫn viên thành công.');
    }

    public function edit(Guide $guide): View
    {
        $guide->load(['languages', 'locations']);

        return view('admin.guides.edit', array_merge(
            ['guide' => $guide],
            $this->formData($guide)
        ));
    }

    public function update(GuideRequest $request, Guide $guide): RedirectResponse
    {
        $data = $this->guideAttributes($request);

        if ($request->hasFile('avatar')) {
            $this->deleteAvatarFile($guide->avatar);
            $data['avatar'] = $request->file('avatar')->store('guides', 'public');
        }

        $guide->update($data);
        $this->syncRelations($guide, $request);

        return redirect()
            ->route('admin.guides.index')
            ->with('success', 'Cập nhật hướng dẫn viên thành công.');
    }

    public function destroy(Guide $guide): RedirectResponse
    {
        $this->deleteAvatarFile($guide->avatar);
        $guide->languages()->detach();
        $guide->locations()->detach();
        $guide->delete();

        return redirect()
            ->route('admin.guides.index')
            ->with('success', 'Đã xóa hướng dẫn viên.');
    }

    private function formData(?Guide $guide = null): array
    {
        return [
            'languages' => Language::orderBy('name')->get(),
            'locations' => Location::orderBy('name')->get(),
            'selectedLanguageIds' => $guide
                ? $guide->languages->pluck('id')->all()
                : [],
            'selectedLocationIds' => $guide
                ? $guide->locations->pluck('id')->all()
                : [],
        ];
    }

    private function guideAttributes(GuideRequest $request): array
    {
        return $request->safe()->only([
            'full_name',
            'gender',
            'phone',
            'email',
            'address',
            'experience_years',
            'description',
            'price_per_day',
            'status',
        ]);
    }

    private function syncRelations(Guide $guide, GuideRequest $request): void
    {
        $guide->languages()->sync($request->input('language_ids', []));
        $guide->locations()->sync($request->input('location_ids', []));
    }

    private function deleteAvatarFile(?string $path): void
    {
        if ($path && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
