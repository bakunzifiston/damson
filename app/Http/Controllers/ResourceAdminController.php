<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\LearningItem;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** One admin for all Learning resources: articles, guides and downloads. */
class ResourceAdminController extends Controller
{
    use FiltersLists;

    public function index(Request $request): View
    {
        $query = LearningItem::query();

        $type = array_key_exists($request->query('type'), LearningItem::TYPES) ? $request->query('type') : null;
        if ($type) {
            $query->ofType($type);
        }
        $this->applySearch($query, $request->query('q'), ['title', 'excerpt', 'category']);
        [$sort, $dir] = $this->applySort($query, $request, ['title', 'type', 'category', 'is_published', 'updated_at'], 'updated_at');

        return view('data-hub.resources.index', [
            'items' => $query->paginate(20)->withQueryString(),
            'type' => $type,
            'counts' => LearningItem::query()->selectRaw('type, COUNT(*) as n')->groupBy('type')->pluck('n', 'type'),
            'sort' => $sort, 'dir' => $dir,
        ]);
    }

    public function create(Request $request): View
    {
        $item = new LearningItem(['type' => array_key_exists($request->query('type'), LearningItem::TYPES) ? $request->query('type') : LearningItem::TYPE_ARTICLE]);
        $item->is_published = true;

        return view('data-hub.resources.form', $this->formData($item));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        $data['slug'] = $this->uniqueSlug($data['type'], ($data['slug'] ?? '') ?: $data['title']);
        if ($request->hasFile('file')) {
            $data['file_path'] = $request->file('file')->store('library', 'public');
        }
        unset($data['file'], $data['remove_file']);

        LearningItem::query()->create($data);

        return redirect()->route('data-hub.resources.index', ['type' => $data['type']])->with('status', 'Resource created.');
    }

    public function edit(LearningItem $resource): View
    {
        return view('data-hub.resources.form', $this->formData($resource));
    }

    public function update(Request $request, LearningItem $resource): RedirectResponse
    {
        $data = $this->validated($request, $resource);

        // The slug is part of the public URL: keep it unless staff explicitly set a new one (or the type changed).
        if (! empty($data['slug']) && ($data['slug'] !== $resource->slug || $data['type'] !== $resource->type)) {
            $data['slug'] = $this->uniqueSlug($data['type'], $data['slug'], $resource->id);
        } elseif ($data['type'] !== $resource->type) {
            $data['slug'] = $this->uniqueSlug($data['type'], $resource->slug, $resource->id);
        } else {
            unset($data['slug']);
        }

        if ($request->hasFile('file')) {
            $this->deleteFile($resource->file_path);
            $data['file_path'] = $request->file('file')->store('library', 'public');
        } elseif ($request->boolean('remove_file')) {
            $this->deleteFile($resource->file_path);
            $data['file_path'] = null;
        }
        unset($data['file'], $data['remove_file']);

        $resource->update($data);

        return redirect()->route('data-hub.resources.index', ['type' => $resource->type])->with('status', 'Resource updated.');
    }

    public function destroy(LearningItem $resource): RedirectResponse
    {
        $this->deleteFile($resource->file_path);
        $type = $resource->type;
        $resource->delete();

        return redirect()->route('data-hub.resources.index', ['type' => $type])->with('status', 'Resource deleted.');
    }

    /** @return array<string, mixed> */
    private function formData(LearningItem $item): array
    {
        return [
            'item' => $item,
            'types' => LearningItem::TYPES,
            'difficulties' => LearningItem::DIFFICULTIES,
            'categories' => LearningItem::query()->ofType(LearningItem::TYPE_DOWNLOAD)->whereNotNull('category')->distinct()->orderBy('category')->pluck('category'),
            'formats' => ['pdf', 'document', 'spreadsheet', 'infographic', 'video', 'link', 'other'],
        ];
    }

    /** @return array<string, mixed> */
    private function validated(Request $request, ?LearningItem $item = null): array
    {
        $isType = fn (string ...$types) => in_array($request->input('type'), $types, true);

        $request->merge([
            'is_published' => $request->boolean('is_published'),
            'remove_file' => $request->boolean('remove_file'),
        ]);

        $data = $request->validate([
            'type' => ['required', Rule::in(array_keys(LearningItem::TYPES))],
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'regex:/^[a-z0-9]+(?:-[a-z0-9]+)*$/'],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'body' => [Rule::requiredIf($isType('article', 'guide')), 'nullable', 'string', 'max:100000'],
            'difficulty' => [Rule::requiredIf($isType('guide')), 'nullable', Rule::in(LearningItem::DIFFICULTIES)],
            'category' => [Rule::requiredIf($isType('download')), 'nullable', 'string', 'max:64'],
            'format' => [Rule::requiredIf($isType('download')), 'nullable', 'string', 'max:32'],
            'external_url' => ['nullable', 'url:http,https', 'max:255'],
            'file' => ['nullable', 'file', 'mimes:pdf,doc,docx,xls,xlsx,ppt,pptx,csv,txt,zip,jpg,jpeg,png', 'max:10240'],
            'remove_file' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0', 'max:65535'],
            'is_published' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ]);

        $data['sort_order'] = (int) ($data['sort_order'] ?? 0);

        // Fields that only make sense for one type are cleared so they never leak onto other types.
        if (! $isType('article', 'guide')) {
            $data['body'] = null;
        }
        if (! $isType('guide')) {
            $data['difficulty'] = null;
        }
        if (! $isType('download')) {
            $data['format'] = $data['external_url'] = null;
            $data['category'] = $isType('article', 'guide') ? ($data['category'] ?? null) : null;
        }
        if ($isType('article') && $data['is_published'] && empty($data['published_at'])) {
            $data['published_at'] = $item?->published_at ?? now();
        }

        return $data;
    }

    private function deleteFile(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }

    private function uniqueSlug(string $type, string $source, ?int $ignoreId = null): string
    {
        $base = Str::slug($source) ?: 'item';
        $slug = $base;
        $n = 1;
        while (LearningItem::query()->where('type', $type)->where('slug', $slug)->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))->exists()) {
            $slug = $base.'-'.$n++;
        }

        return $slug;
    }
}
