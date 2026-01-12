<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Office;
use App\Models\Faq;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function index()
    {
        $faqs = Faq::with('office')->latest()->paginate(10);
        $offices = Office::all();
        return view('admin.faqs.index', compact('faqs', 'offices'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string',
            'answer' => 'required|string',
            'office_id' => 'nullable|exists:offices,id',
        ]);

        Faq::create($request->all());

        return back()->with('success', 'FAQ created successfully.');
    }

    public function update(Request $request, Faq $faq)
    {
        $request->validate([
            'question' => 'required',
            'answer' => 'required',
            'office_id' => 'nullable|exists:offices,id',
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
            ->orderBy('office_id')
            ->get();

        return view('student.faq.index', compact('faqs'));
    }
}
