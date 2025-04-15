@extends('core.index')
@section('content')
    @use(App\Models\CodeCategory)
    @use(App\Models\Snippet)
    @use(App\Models\RowCategory)
    @use(App\Models\Code)

    @if(session('success'))
        <div class="alert alert-success" role="alert">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function () {
                $('.alert').hide();
            }, 3000);
        </script>
    @endif

    <h1 class="text-center my-3">{{ __('trans.Editing') }}: {{ __($code->name) }} #{{ $code->id }}</h1>
    <form action="{{ route('user.code.update', $code) }}" method="post">
        @csrf
        <div class="p-2 bg-dark-subtle">
            <div class="row">
                <div class="row col-6">
                    <div class="mb-3 col-11">
                        <label for="codeNameEN" class="form-label">{{ __("trans.Code name") }} EN</label>
                        <input type="text" class="form-control" id="codeNameEN" name="code[en][name]"
                               value="{{ trans($code->name, [], 'en') }}" required>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-end">
                        <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                           onclick="getTranslation($(this))" data-local="en" role="button" data-target-id="codeNameSK">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
                <div class="row col-6">
                    <div class="mb-3 col-11">
                        <label for="codeNameSK" class="form-label">{{ __("trans.Code name") }} SK</label>
                        <input type="text" class="form-control" id="codeNameSK" name="code[sk][name]"
                               value="{{ trans($code->name, [], 'sk') }}" required>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-end">
                        <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                           onclick="getTranslation($(this))" data-local="sk" role="button" data-target-id="codeNameEN">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="row col-6">
                    <div class="mb-3 col-11">
                        <label for="descriptionEN" class="form-label">{{ __("trans.Code description") }} EN</label>
                        <textarea class="form-control" id="descriptionEN" rows="1"
                                  name="code[en][description]">{{ trans($code->name, [], 'en') }}</textarea>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-end">
                        <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                           onclick="getTranslation($(this))" data-local="en" role="button"
                           data-target-id="descriptionSK">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
                <div class="row col-6">
                    <div class="mb-3 col-11">
                        <label for="descriptionSK" class="form-label">{{ __("trans.Code description") }} SK</label>
                        <textarea class="form-control" id="descriptionSK" rows="1"
                                  name="code[sk][description]">{{ trans($code->name, [], 'sk') }}</textarea>
                    </div>
                    <div class="col-1 d-flex justify-content-center align-items-end">
                        <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                           onclick="getTranslation($(this))" data-local="sk" role="button"
                           data-target-id="descriptionEN">
                            <i class="bi bi-translate"></i>
                        </a>
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="codeType" class="form-label">{{ __("trans.Code category") }}</label>
                <select class="form-select" id="codeType" name="code[category]">
                    @foreach(CodeCategory::getTypes() as $categoryId => $categoryName)
                        <option value="{{ $categoryId }}" @selected($code->code_category_id == $categoryId)>
                            {{ __('trans.'.$categoryName) }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-primary my-3">{{ __("trans.Submit") }}</button>
        <h3 class="mt-5 mb-3">Snippets</h3>
        @foreach ($code->snippets as $snippet)
            <div class="mb-4 p-2 @if($loop->odd) bg-secondary-subtle @else bg-dark-subtle @endif">
                <div class="row">
                    <div class="row col-6">
                        <div class="mb-3 col-11">
                            <label for="snippetDescriptionEn{{ $snippet->id }}"
                                   class="form-label">{{ __("trans.Description") }} EN</label>
                            <input type="text" id="snippetDescriptionEn{{ $snippet->id }}"
                                   name="snippets[{{ $snippet->id }}][en][description]" class="form-control"
                                   value="{{ trans($snippet->description, [], 'en') }}" required>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-end">
                            <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                               onclick="getTranslation($(this))" data-local="en" role="button" data-target-id="snippetDescriptionSk{{ $snippet->id }}">
                                <i class="bi bi-translate"></i>
                            </a>
                        </div>
                    </div>
                    <div class="row col-6">
                        <div class="mb-3 col-11">
                            <label for="snippetDescriptionSk{{ $snippet->id }}"
                                   class="form-label">{{ __("trans.Description") }} SK</label>
                            <input type="text" id="snippetDescriptionSk{{ $snippet->id }}"
                                   name="snippets[{{ $snippet->id }}][sk][description]" class="form-control"
                                   value="{{ trans($snippet->description, [], 'sk') }}" required>
                        </div>
                        <div class="col-1 d-flex justify-content-center align-items-end">
                            <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                               onclick="getTranslation($(this))" data-local="en" role="button" data-target-id="snippetDescriptionEn{{ $snippet->id }}">
                                <i class="bi bi-translate"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="snippetRow{{ $snippet->id }}" class="form-label">{{ __("trans.Code") }}</label>
                    <textarea class="form-control" id="snippetRow{{ $snippet->id }}"
                              name="snippets[{{ $snippet->id }}][row]"
                              rows="1" required>{{ $snippet->row }}</textarea>
                </div>
                <div class="row">
                    <div class="col-6">
                        <label for="crispdm{{ $snippet->id }}" class="form-label">Crispdm</label>
                        <select class="form-select" id="crispdm{{ $snippet->id }}"
                                name="snippets[{{ $snippet->id }}][crispdm]">
                            @foreach(Snippet::getAllCrispdm() as $crispdmId => $crispdmName)
                                <option value="{{ $crispdmId }}" @selected($snippet->crispdm == $crispdmId)>
                                    {{ __('trans.'.$crispdmName) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-6">
                        <label for="category{{ $snippet->id }}"
                               class="form-label">{{ __("trans.Row category") }}</label>
                        <select class="form-select" id="category{{ $snippet->id }}"
                                name="snippets[{{ $snippet->id }}][category]">
                            @foreach(RowCategory::getAllCategoriesForSelect() as $categoryId => $categoryName)
                                <option value="{{ $categoryId }}" @selected($snippet->category_id == $categoryId)>
                                    {{ __(RowCategory::TRANS_STRING . $categoryId) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <a class="my-3 btn btn-danger me-2" href="{{ route('user.snippet.delete', $snippet) }}"
                   title="{{ __("Delete") }}">
                    <i class="bi bi-trash"></i>
                </a>
            </div>
            @if (!$loop->last)
                <hr>
            @endif

            @if($loop->last)
                <div id="newSnippets" data-last-row-index="{{ $loop->iteration }}"></div>
            @endif
        @endforeach

        @if(count($code->snippets) == 0)
            <div id="newSnippets" data-last-row-index="1"></div>
        @endif

        <div class="row mb-3 d-flex justify-content-center">
            <a class="col-2 btn btn-success" id="addNewRow" title="{{ __("trans.Add new snippet") }}">
                <i class="bi bi-plus-circle" style="font-size: 1.5rem"></i>
            </a>
        </div>

        <button type="submit" class="btn btn-primary my-3">{{ __("trans.Submit") }}</button>
    </form>

    <script>
        $("textarea").each(function () {
            this.style.height = this.scrollHeight + "px";
            this.style.overflowY = "hidden";
            this.style.resize = "none";
        }).on("input", function () {
            this.style.height = "auto";
            this.style.height = this.scrollHeight + "px";
        });

        $("#addNewRow").click(function () {
            const lastRowIndex = parseInt($("#newSnippets").data("last-row-index")) + 1;
            $("#newSnippets").data("last-row-index", lastRowIndex);
            $("#newSnippets").append(`
                <div id="newSnippetContainer${lastRowIndex}">
                    <hr>
                    <div class="mb-4 p-2 ${lastRowIndex % 2 === 0 ? 'bg-dark-subtle' : 'bg-secondary-subtle'}">
                        <div class="row">
                            <div class="row col-6">
                                <div class="mb-3 col-11">
                                    <label for="snippetDescriptionEn${lastRowIndex}" class="form-label">${"{{ __("trans.Description") }}"} En</label>
                                    <input type="text" id="snippetDescriptionEn${lastRowIndex}"
                                           name="newSnippets[${lastRowIndex}][en][description]" class="form-control" value="" required>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-end">
                                    <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                                       onclick="getTranslation($(this))" data-local="en" role="button" data-target-id="snippetDescriptionSk${lastRowIndex}">
                                        <i class="bi bi-translate"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="row col-6">
                                <div class="mb-3 col-11">
                                    <label for="snippetDescriptionSk${lastRowIndex}" class="form-label">${"{{ __("trans.Description") }}"} SK</label>
                                    <input type="text" id="snippetDescriptionSk${lastRowIndex}"
                                           name="newSnippets[${lastRowIndex}][sk][description]" class="form-control" value="" required>
                                </div>
                                <div class="col-1 d-flex justify-content-center align-items-end">
                                    <a class="btn btn-info mb-3" style="font-size: 13px; height: 38px" href="javascript:void(0);"
                                       onclick="getTranslation($(this))" data-local="sk" role="button" data-target-id="snippetDescriptionEn${lastRowIndex}">
                                        <i class="bi bi-translate"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="snippetRow${lastRowIndex}" class="form-label">${"{{ __("trans.Code") }}"}</label>
                            <textarea class="form-control" id="snippetRow${lastRowIndex}"
                                      name="newSnippets[${lastRowIndex}][row]" rows="1" required></textarea>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="crispdm${lastRowIndex}" class="form-label">Crispdm</label>
                                <select class="form-select" id="crispdm${lastRowIndex}" name="newSnippets[${lastRowIndex}][crispdm]">
                                    @foreach(Snippet::getAllCrispdm() as $crispdmId => $crispdmName)
                                        <option value="{{ $crispdmId }}">{{ __($crispdmName) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-6">
                                <label for="category${lastRowIndex}" class="form-label">${"{{ __("trans.Row category") }}"}</label>
                                <select class="form-select" id="category${lastRowIndex}" name="newSnippets[${lastRowIndex}][category]">
                                    @foreach(RowCategory::getAllCategoriesForSelect() as $categoryId => $categoryName)
                                        <option value="{{ $categoryId }}">{{ __(RowCategory::TRANS_STRING . $categoryId) }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <a class="my-3 btn btn-danger me-2" onclick="$('#newSnippetContainer${lastRowIndex}').remove()"
                            title=${"{{ __('trans.Delete') }}"}>
                            <i class="bi bi-trash"></i>
                        </a>
                    </div>
                </div>
            `);

            $("textarea").each(function () {
                this.style.height = this.scrollHeight + "px";
                this.style.overflowY = "hidden";
                this.style.resize = "none";
            }).on("input", function () {
                this.style.height = "auto";
                this.style.height = this.scrollHeight + "px";
            });
        });
    </script>

    <script src="{{ asset('js/translatorForCreateAndEdit.js') }}"></script>
@endsection
