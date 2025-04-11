<?php

namespace App\Http\Controllers;

use App\Models\Code;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function showPendingCodesForApproval(): View
    {
        $codes = Code::whereApproved(false)->get();

        return view('admin.codeToApprove', compact('codes'));
    }

    /**
     * @param Code $code
     * @return RedirectResponse
     */
    public function approveCode(Code $code): RedirectResponse
    {
        $code->approved = true;
        $code->save();

        return redirect()->back()->with('success', __('trans.Code approved successfully'));
    }
}
