<?php

namespace App\Http\Controllers;

use App\Models\Code;
use App\Models\RowCategory;
use App\Models\Snippet;
use App\Models\Translation;
use App\Providers\AppServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use \Illuminate\Contracts\View\View;

class UserController extends Controller
{
    /**
     * @return View
     */
    public function showUserCodes(): View
    {
        $codes = Code::whereUserId(auth()->id())->get();

        return view('user.codes', compact('codes'));
    }

    /**
     * @return View
     */
    public function showCreateCode(): View
    {
        return view('user.createCode');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function createCode(Request $request): RedirectResponse
    {
        $codeData = $request->get('code');

        $code = Code::create([
            'user_id'          => auth()->id(),
            'code_category_id' => $codeData['category'],
        ]);

        $code->update([
            'name'        => 'trans.code.name.' . $code->id,
            'description' => 'trans.code.description.' . $code->id,
        ]);

        $this->createOrUpdateTranslations($code, $codeData);

        $this->createNewSnippets($request, $code);

        return redirect()->route('user.code.edit', $code)->with('success', __('trans.Code created successfully'));
    }

    /**
     * @param Code $code
     * @return View
     */
    public function editCode(Code $code): View
    {
        return view('user.editCode', compact('code'));
    }

    /**
     * @param Request $request
     * @param Code $code
     * @return RedirectResponse
     */
    public function updateCode(Request $request, Code $code): RedirectResponse
    {
        $codeData = $request->get('code');
        $code->update([
            'code_category_id' => $codeData['category'],
        ]);

        $this->createOrUpdateTranslations($code, $codeData);

        if ($request->has('snippets')) {
            foreach ($request->get('snippets') as $snippetId => $data) {
                $snippet = Snippet::whereId($snippetId)->first();

                $snippet->update([
                    "row"         => $data['row'],
                    'crispdm'     => $data['crispdm'],
                    'category_id' => $data['category'],
                ]);

                $this->createOrUpdateTranslations($snippet, $data);
            }
        }

        $this->createNewSnippets($request, $code);

        return redirect()->route('user.code.edit', $code)->with('success', __('trans.Code updated successfully'));
    }

    /**
     * @return View
     */
    public function showArchive(): View
    {
        $archive = Code::onlyTrashed()->where('user_id', auth()->id())->get();

        return view('user.archiveCodes', compact('archive'));
    }

    /**
     * @param Code $code
     * @return RedirectResponse
     */
    public function archiveCode(Code $code): RedirectResponse
    {
        foreach ($code->snippets as $snippet) {
            if ($snippet->codes->count() == 1) {
                $snippet->delete();
            }
        }

        $code->delete();

        return redirect()->back()->with('success', __('trans.Code archived successfully'));
    }

    /**
     * @param int $codeId
     * @return RedirectResponse
     */
    public function restoreCode(int $codeId): RedirectResponse
    {
        $code = Code::withTrashed()->findOrFail($codeId);

        // Restore the record
        if ($code) {
            $code->restore();

            foreach ($code->snippets as $snippet) {
                $snippet->restore();
            }

            return redirect()->back()->with('success', __('trans.Code restored successfully'));
        }

        return redirect()->back()->with('error', __('trans.Code cant restored'));
    }

    /**
     * @param int $codeId
     * @return RedirectResponse
     */
    public function deleteCode(int $codeId)
    {
        $code = Code::withTrashed()->findOrFail($codeId);

        $snippets = Snippet::withTrashed()
            ->join('codes_has_snippets', 'snippets.id', '=', 'codes_has_snippets.snippet_id')
            ->where('codes_has_snippets.code_id', $codeId)
            ->get();

        foreach ($snippets as $snippet) {
            if ($snippet->codes->count() == 1) {
                $snippet->forceDelete();
            }
        }

        if ($code) {
            $code->forceDelete();
        }

        return redirect()->back()->with('success', __('trans.Code deleted permanently'));
    }

    /**
     * @param Snippet $snippet
     * @return RedirectResponse
     */
    public function deleteSnippet(Snippet $snippet): RedirectResponse
    {
        $snippet->delete();

        return redirect()->back()->with('success', __('trans.Snippet deleted successfully'));
    }

    /**
     * @return View
     */
    public function showCreateRowCategory(): View
    {
        return view('user.createRowCategory');
    }

    public function createRowCategory(Request $request): RedirectResponse
    {
        $latType = RowCategory::orderByDesc('type')->first();
        $newType = $latType->type + 1;

        RowCategory::create(['type' => $newType]);

        Translation::create([
            'key'    => RowCategory::TRANS_STRING . $newType,
            'locale' => 'en',
            'value'  => $request->get('en')
        ]);

        Translation::create([
            'key'    => RowCategory::TRANS_STRING . $newType,
            'locale' => 'sk',
            'value'  => $request->get('sk')
        ]);

        return redirect()->back()->with('success', __('trans.Row category created successfully'));
    }

    /**
     * @param Request $request
     * @param Code $code
     * @return void
     */
    private function createNewSnippets(Request $request, Code $code): void
    {
        if ($request->has('newSnippets')) {
            foreach ($request->get('newSnippets') as $data) {
                $newSnippet = Snippet::create([
                    'row'         => $data['row'],
                    'crispdm'     => $data['crispdm'],
                    'category_id' => $data['category'],
                ]);

                $newSnippet->update([
                    'description' => 'trans.snippet.description.' . $newSnippet->id,
                ]);

                $this->createOrUpdateTranslations($newSnippet, $data);

                $code->snippets()->attach($newSnippet);
            }
        }
    }

    /**
     * @param Code|Snippet $model
     * @param array $translationsData
     * @return void
     */
    private function createOrUpdateTranslations(Code|Snippet $model, array $translationsData): void
    {
        $languages = ['en', 'sk'];

        $type = match (get_class($model)) {
            Code::class    => 'code',
            Snippet::class => 'snippet',
        };

        foreach ($languages as $language) {
            $localData = $translationsData[$language];
            foreach ($localData as $key => $value) {
                Translation::updateOrCreate(
                    [
                        'key'    => 'trans.' . $type . '.' . $key . '.' . $model->id,
                        'locale' => $language,
                    ],
                    [
                        'value' => $value,
                    ]
                );
            }
        }
    }
}
