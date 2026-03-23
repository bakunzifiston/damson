<?php

namespace App\Http\Controllers;

use App\Models\DmmsMonitoringRecord;
use App\Models\IncubationRecord;
use App\Models\PurchaseRecord;
use App\Models\SalesRecord;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PublicFormController extends Controller
{
    public function purchaseForm(): View
    {
        return view('forms.purchase');
    }

    public function purchaseStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:50'],
            'product_interest' => ['required', 'string', 'max:255'],
            'quantity' => ['nullable', 'integer', 'min:1'],
            'unit' => ['nullable', 'string', 'max:50'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        PurchaseRecord::query()->create($validated);

        if (Auth::check()) {
            return redirect()
                ->route('data-hub.module', ['module' => 'purchases'])
                ->with('status', 'Purchase inquiry saved.');
        }

        return redirect()
            ->route('forms.purchase')
            ->with('status', 'Purchase inquiry recorded. Our team will follow up with you.');
    }

    public function salesForm(): View
    {
        return view('forms.sales');
    }

    public function salesStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'product_line' => ['required', 'string', 'max:255'],
            'amount' => ['nullable', 'numeric', 'min:0'],
            'payment_status' => ['nullable', 'string', 'max:32'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        SalesRecord::query()->create($validated);

        if (Auth::check()) {
            return redirect()
                ->route('data-hub.module', ['module' => 'sales'])
                ->with('status', 'Sales record saved.');
        }

        return redirect()
            ->route('forms.sales')
            ->with('status', 'Sales record saved successfully.');
    }

    public function dmmsForm(): View
    {
        return view('forms.dmms');
    }

    public function dmmsStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'farm_name' => ['required', 'string', 'max:255'],
            'zone' => ['nullable', 'string', 'max:255'],
            'temperature_c' => ['nullable', 'numeric'],
            'humidity_pct' => ['nullable', 'numeric', 'between:0,100'],
            'co2_ppm' => ['nullable', 'integer', 'min:0'],
            'alert_message' => ['nullable', 'string', 'max:500'],
            'recorded_at' => ['required', 'date'],
            'notes' => ['nullable', 'string', 'max:2000'],
        ]);

        DmmsMonitoringRecord::query()->create($validated);

        if (Auth::check()) {
            return redirect()
                ->route('data-hub.module', ['module' => 'dmms'])
                ->with('status', 'DMMS reading saved.');
        }

        return redirect()
            ->route('forms.dmms')
            ->with('status', 'DMMS monitoring reading logged.');
    }

    public function incubationForm(): View
    {
        return view('forms.incubation');
    }

    public function incubationStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'batch_reference' => ['required', 'string', 'max:255'],
            'species' => ['required', 'string', 'max:255'],
            'incubation_start' => ['required', 'date'],
            'expected_fruit' => ['nullable', 'date', 'after_or_equal:incubation_start'],
            'phase' => ['nullable', 'string', 'max:64'],
            'observations' => ['nullable', 'string', 'max:2000'],
        ]);

        IncubationRecord::query()->create($validated);

        if (Auth::check()) {
            return redirect()
                ->route('data-hub.module', ['module' => 'incubation'])
                ->with('status', 'Incubation batch saved.');
        }

        return redirect()
            ->route('forms.incubation')
            ->with('status', 'Incubation batch recorded.');
    }
}
