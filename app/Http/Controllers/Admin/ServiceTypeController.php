<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\ServiceType;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ServiceTypeController extends Controller
{
    public function index()
    {
        $serviceTypes = ServiceType::with('office')->latest()->get();
        $offices = Office::all();

        return view('admin.service-types.index', compact('serviceTypes', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_types')
                    ->where('office_id', $request->office_id),
            ],
        ]);

        $name = trim(ucwords(strtolower($request->name)));

        ServiceType::create($request->only('office_id', 'name'));

        return back()->with('success', 'Service type created successfully.');
    }

    public function update(Request $request, ServiceType $serviceType)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('service_types')
                    ->where('office_id', $request->office_id)
                    ->ignore($serviceType->id),
            ],
        ]);

        $name = trim(ucwords(strtolower($request->name)));

        $serviceType->update($request->only('office_id', 'name'));

        return back()->with('success', 'Service type updated successfully.');
    }

    public function destroy(ServiceType $serviceType)
    {
        $serviceType->delete();

        return back()->with('success', 'Service type deleted successfully.');
    }
}
