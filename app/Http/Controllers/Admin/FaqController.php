<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('department')->latest()->paginate(10);
        $departments = Department::all();
        return view('admin.faqs.index', compact('faqs', 'departments'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        Faq::create($request->all());

        return back()->with('success', 'FAQ created successfully.');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'department_id' => 'nullable|exists:departments,id',
        ]);

        $faq->update($request->all());

        return back()->with('success', 'FAQ updated.');
    }

    public function destroy(Faq $faq)
    {
        $faq->delete();
        return back()->with('success', 'FAQ deleted.');
    }

    public function toggle(Faq $faq)
    {
        $faq->update(['is_active' => !$faq->is_active]);
        return back()->with('success', 'FAQ status updated.');
    }

    public function faq()
    {
        $faqs = Faq::where('is_active', true)
            ->orderBy('department_id')
            ->get();

        return view('student.faq.index', compact('faqs'));
    }
}
