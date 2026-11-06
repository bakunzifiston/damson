<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\FiltersLists;
use App\Models\TrainingApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Staff view of training applications inside the existing data hub. */
class TrainingApplicationAdminController extends Controller
{
    use FiltersLists;

    public function index(Request $request): View
    {
        $query = TrainingApplication::query();

        $this->applySearch($query, $request->query('q'), ['full_name', 'phone', 'email']);

        if (array_key_exists($request->query('mode'), TrainingApplication::MODES)) {
            $query->where('training_mode', $request->query('mode'));
        }
        if (in_array($request->query('interest'), TrainingApplication::INTERESTS, true)) {
            $query->whereJsonContains('interests', $request->query('interest'));
        }
        if (array_key_exists($request->query('status'), TrainingApplication::STATUSES)) {
            $query->where('status', $request->query('status'));
        }

        [$sort, $dir] = $this->applySort($query, $request, ['created_at', 'full_name', 'training_mode', 'status'], 'created_at');

        return view('data-hub.training.index', [
            'applications' => $query->paginate(20)->withQueryString(),
            'statusCounts' => TrainingApplication::query()->selectRaw('status, COUNT(*) as n')->groupBy('status')->pluck('n', 'status'),
            'sort' => $sort,
            'dir' => $dir,
        ]);
    }

    public function show(TrainingApplication $application): View
    {
        return view('data-hub.training.show', ['application' => $application]);
    }

    public function update(Request $request, TrainingApplication $application): RedirectResponse
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(TrainingApplication::STATUSES))],
            'admin_notes' => ['nullable', 'string', 'max:5000'],
        ]);

        $application->update($data);

        return redirect()->route('data-hub.training.show', $application)->with('status', 'Application updated.');
    }
}
