<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\LanguageRequest;
use App\Models\Language;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::query()
            ->withCount('guides')
            ->orderBy('name')
            ->paginate(15);

        return view('admin.languages.index', compact('languages'));
    }

    public function create(): View
    {
        return view('admin.languages.create');
    }

    public function store(LanguageRequest $request): RedirectResponse
    {
        Language::create($request->validated());

        return redirect()
            ->route('admin.languages.index')
            ->with('success', 'Thêm ngôn ngữ thành công.');
    }

    public function edit(Language $language): View
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(LanguageRequest $request, Language $language): RedirectResponse
    {
        $language->update($request->validated());

        return redirect()
            ->route('admin.languages.index')
            ->with('success', 'Cập nhật ngôn ngữ thành công.');
    }

    public function destroy(Language $language): RedirectResponse
    {
        $language->guides()->detach();
        $language->delete();

        return redirect()
            ->route('admin.languages.index')
            ->with('success', 'Đã xóa ngôn ngữ.');
    }
}
