<?php

namespace App\Http\Controllers;

use App\Models\TrainingApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

/** Public "Apply for Mushroom Farming Training" form. */
class TrainingApplicationController extends Controller
{
    public function create(): View
    {
        return view('learning.apply', [
            'modes' => TrainingApplication::MODES,
            'interests' => TrainingApplication::INTERESTS,
            'experience' => TrainingApplication::EXPERIENCE,
            'timing' => TrainingApplication::START_PREFERENCES,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:32', 'regex:/^\+?[0-9][0-9\s().\-]{7,30}$/'],
            'email' => ['required', 'email', 'max:255'],
            'district' => ['required', 'string', 'max:255'],
            'training_mode' => ['required', Rule::in(array_keys(TrainingApplication::MODES))],
            'interests' => ['required', 'array', 'min:1'],
            'interests.*' => ['string', Rule::in(TrainingApplication::INTERESTS)],
            'experience' => ['required', Rule::in(array_keys(TrainingApplication::EXPERIENCE))],
            'start_preference' => ['required', Rule::in(array_keys(TrainingApplication::START_PREFERENCES))],
            'objective' => ['required', 'string', 'min:10', 'max:2000'],
        ], [
            'phone.regex' => 'Enter a valid phone number, e.g. +250 785 171 213.',
            'interests.required' => 'Select at least one area you are interested in.',
            'objective.min' => 'Please tell us a little more (at least 10 characters).',
        ]);

        // Honeypot: real visitors never see or fill this field; bots often do. Pretend success.
        if ($request->filled('website')) {
            return $this->thanks();
        }

        $data['interests'] = array_values(array_unique($data['interests']));

        // Duplicate-submit guard: a double click or refresh must not create a second row.
        $duplicate = TrainingApplication::query()
            ->where('email', $data['email'])
            ->where('phone', $data['phone'])
            ->where('created_at', '>=', now()->subMinutes(10))
            ->exists();

        if (! $duplicate) {
            TrainingApplication::query()->create($data);
        }

        return $this->thanks();
    }

    private function thanks(): RedirectResponse
    {
        return redirect()->route('learning.apply')->with('applied', true);
    }
}
