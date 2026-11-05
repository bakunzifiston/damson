<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Staff management of FAQs. Articles, guides and downloads live in ResourceAdminController. */
class ContentAdminController extends Controller
{
    use FiltersLists;

    public function index(Request $request): View
    {
        $query = Faq::query();
        $this->applySearch($query, $request->query('q'), ['question', 'answer', 'category']);
        [$sort, $dir] = $this->applySort($query, $request, ['question', 'category', 'sort_order'], 'sort_order', 'asc');

        return view('data-hub.content.index', ['items' => $query->paginate(20)->withQueryString(), 'sort' => $sort, 'dir' => $dir]);
    }

    public function create(): View
    {
        return view('data-hub.content.form', $this->formData(new Faq));
    }

    public function store(Request $request): RedirectResponse
    {
        Faq::query()->create($this->validated($request));

        return redirect()->route('data-hub.content.index')->with('status', 'FAQ created.');
    }

    public function edit(Faq $faq): View
    {
        return view('data-hub.content.form', $this->formData($faq));
    }

    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $faq->update($this->validated($request));

        return redirect()->route('data-hub.content.index')->with('status', 'FAQ updated.');
    }

    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('data-hub.content.index')->with('status', 'FAQ deleted.');
    }

    /** @return array<string, mixed> */
    private function formData(Faq $faq): array
    {
        return ['item' => $faq, 'categories' => Faq::query()->whereNotNull('category')->distinct()->orderBy('category')->pluck('category')];
    }

    /** @return array<string, mixed> */
    private function validated(Request $request): array
    {
        $data = $request->validate([
            'category' => ['nullable', 'string', 'max:64'],
            'question' => ['required', 'string', 'max:255'],
            'answer' => ['required', 'string', 'max:5000'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
        ]);
        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        return $data;
    }
}
