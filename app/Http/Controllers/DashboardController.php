<?php

namespace App\Http\Controllers;

use App\Models\RowCategory;
use App\Models\Snippet;
use App\Models\Translation;
use Illuminate\Http\Request;
use \Illuminate\View\View;
use \Illuminate\Http\JsonResponse;

class DashboardController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $snippets = Snippet::all()->groupBy('category_id')->sortKeys();

        return view('home', compact('snippets'));
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function ajaxList(Request $request): JsonResponse
    {
        $query = Snippet::query();

        $query->when($request->has('snippetCategories'), function ($query) use ($request) {
            $snippetCategories = $request->get('snippetCategories');
            $query->whereIn('category_id', $snippetCategories);
        });

        $query->when($request->has('crispdm'), function ($query) use ($request) {
            $crispdms = $request->get('crispdm');
            $query->whereIn('crispdm', $crispdms);
        });

        $query->when($request->has('codeCategories'), function ($query) use ($request) {
            $codeCategories = $request->get('codeCategories');

            $query->whereHas('codes', function ($query) use ($codeCategories) {
                $query->whereIn('code_category_id', $codeCategories);
            });
        });

        $query->when($request->has('search'), function ($query) use ($request) {
            $search = $request->get('search');
            $query->where(function ($query) use ($search) {
                $searchInTranslation = Translation::where('value', 'like', '%' . $search . '%')->get();

                $snippetIds = [];
                if ($searchInTranslation->count() > 0) {

                    foreach ($searchInTranslation as $translation) {
                        $exploded = explode('.', $translation->key);
                        $snippetIds[] = (int)end($exploded);
                    }
                }
                $query->whereIn('id', $snippetIds);
                $query->orWhere('row', 'like', '%' . $search . '%');
            });
        });

        $snippets = $query->get()->groupBy('category_id')->sortBy('category_id');

        //RESTRUCTURING THE DATA FOR EASIER AJAX HANDLING
        $result = $snippets->map(function ($group, $categoryId) {
            return [
                'category_id'   => $categoryId,
                'category_name' => __(RowCategory::TRANS_STRING . $categoryId),
                'snippets'      => $group->map(function ($snippet) {
                    return [
                        'id'          => $snippet->id,
                        'description' => __($snippet->description),
                        'crispdm'     => Snippet::getCrispdm($snippet->crispdm),
                        'row'         => $snippet->row
                    ];
                }),
            ];
        });
        return response()->json($result);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function fetchWholeCode(Request $request): JsonResponse
    {
        if ($request->has('snippetId')) {
            $snippet = Snippet::whereId($request->get('snippetId'))->first();

            $codes = $snippet->codes;

            return response()->json([
                'html' => view('component.codeModalContentAjax', compact('codes'))->render()
            ]);
        }

        return response()->json();
    }
}
