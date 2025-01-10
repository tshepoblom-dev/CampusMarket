@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex justify-content-between align-items-center">
            <h4>{{ $page_title ?? '' }}</h4>
            <button type="button" class="eg-btn btn--primary back-btn" data-bs-toggle="modal"
                data-bs-target="#staticBackdrop"><img src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="Add New">
                {{ translate('Add New') }}</button>
        </div>
    </div>
    @php
        $locale = get_setting('DEFAULT_LANGUAGE', 'en');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table category-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('Category') }}</th>
                            <th>{{ translate('Blog') }}</th>
                            <th>{{ translate('Status') }}</th>
                            <th>{{ translate('Published') }}</th>
                            <th>
                                @foreach (\App\Models\Language::all() as $key => $language)
                                    <img src="{{ asset('assets/img/flags/' . $language->code . '.png') }}" class="mr-2">
                                @endforeach
                            </th>
                            <th>{{ translate('Option') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $key => $category)
                            <tr>
                                <td data-label="S.N">
                                    {{ ($categories->currentpage() - 1) * $categories->perpage() + $key + 1 }}</td>
                                <td data-label="Image">
                                    @if (!empty($category->image))
                                        <img src="{{ asset('uploads/blog/' . $category->image) }}"
                                            alt="{{ $category->name }}" width="20">
                                    @endif
                                </td>
                                <td data-label="Category Name">{{ $category->getTranslation('name') }}</td>
                                <td data-label="Product">10</td>
                                <td data-label="Status">
                                    <span id="statusBlockBlogCat{{ $category->id }}">
                                        @if ($category->status == 1)
                                            <button class="eg-btn green-light--btn">{{ translate('Active') }}</button>
                                        @else
                                            <button class="eg-btn red-light--btn">{{ translate('Inactive') }}</button>
                                        @endif
                                    </span>
                                </td>
                                <td data-label="Published">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input flexSwitchCheckBlogCat" type="checkbox"
                                            data-activations-status="{{ $category->status }}"
                                            data-category-id="{{ $category->id }}"
                                            id="flexSwitchCheckBlogCat{{ $category->id }}"
                                            {{ $category->status == 1 ? 'checked' : '' }}>
                                    </div>
                                </td>
                                <td data-label="Language">
                                    @foreach (\App\Models\Language::all() as $key => $language)
                                        @if ($locale == $language->code)
                                            <i class="text-success bi bi-check-lg"></i>
                                        @else
                                            <a
                                                href="{{ route('blog.category.edit', ['id' => $category->id, 'lang' => $language->code]) }}"><i
                                                    class="text--primary bi bi-pencil-square"></i></a>
                                        @endif
                                    @endforeach
                                </td>
                                <td data-label="Option">
                                    <div
                                        class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                        <a class="eg-btn add--btn"
                                            href="{{ route('blog.category.edit', ['id' => $category->id, 'lang' => get_setting('DEFAULT_LANGUAGE', 'en')]) }}"><i
                                                class="bi bi-pencil-square"></i></a>
                                        <form method="POST" action="{{ route('blog.category.delete', $category->id) }}">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button type="submit" class="eg-btn delete--btn show_confirm"
                                                data-toggle="tooltip" title='Delete'><i class="bi bi-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @include('backend.blog.category_modal')

    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $categories->links() !!}
        </div>
    @endpush
@endsection
