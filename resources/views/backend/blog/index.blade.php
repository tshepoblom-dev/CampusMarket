@extends('backend.layouts.master')
@section('content')
    <div class="row mb-35 g-4">
        <div class=" col-md-3">
            <div class="page-title text-md-start text-center">
                <h4>{{ $page_title ?? '' }}</h4>
            </div>
        </div>
        <div
            class="col-md-9 text-md-end text-center d-flex justify-content-md-end justify-content-center flex-row align-items-center flex-wrap gap-4">
            <form action="" method="get">
                <div class="input-with-btn d-flex jusify-content-start align-items-strech">
                    <input type="text" name="search" placeholder="{{ translate('Blog Title') }}...">
                    <button type="submit"><i class="bi bi-search"></i></button>
                </div>
            </form>
            <a href="{{ route('blog.create') }}" class="eg-btn btn--primary back-btn"><img
                    src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="{{ translate('Add New') }}">
                {{ translate('Add New') }}</a>
            <a href="{{ route('blog.category.list') }}" class="eg-btn btn--primary back-btn"><img
                    src="{{ asset('backend/images/icons/add-icon.svg') }}" alt="{{ translate('Category') }}">
                {{ translate('Category') }}</a>
        </div>
    </div>
    @php
        $locale = get_setting('DEFAULT_LANGUAGE', 'en');
    @endphp
    <div class="row">
        <div class="col-12">
            <div class="table-wrapper">
                <table class="eg-table table customer-table">
                    <thead>
                        <tr>
                            <th>{{ translate('S.N') }}</th>
                            <th>{{ translate('Image') }}</th>
                            <th>{{ translate('Title') }}</th>
                            <th>{{ translate('Category') }}</th>
                            <th>{{ translate('Date') }}</th>
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
                        @if ($blogs->count() > 0)
                            @foreach ($blogs as $key => $blog)
                                <tr>
                                    <td data-label="S.N">{{ ($blogs->currentpage() - 1) * $blogs->perpage() + $key + 1 }}
                                    </td>
                                    <td data-label="Image">
                                        @if (!empty($blog->image))
                                            <img src="{{ asset('uploads/blog/' . $blog->image) }}"
                                                alt="{{ $blog->title }}">
                                        @endif
                                    </td>
                                    <td data-label="Title">
                                        {{ $blog->getTranslation('title', $lang) }}
                                    </td>
                                    <td data-label="Category">{{ $blog->blog_categories->getTranslation('name', $lang) }}
                                    </td>
                                    <td data-label="Date"> {{ dateFormat($blog->created_at ) }}</td>
                                    <td data-label="Published">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input flexSwitchCheckBlog" type="checkbox"
                                                data-activations-status="{{ $blog->status }}"
                                                data-blog-id="{{ $blog->id }}"
                                                id="flexSwitchCheckBlog{{ $blog->id }}"
                                                {{ $blog->status == 1 ? 'checked' : '' }}>
                                        </div>
                                    </td>
                                    <td data-label="Language">
                                        @foreach (\App\Models\Language::all() as $key => $language)
                                            @if ($locale == $language->code)
                                                <i class="text-success bi bi-check-lg"></i>
                                            @else
                                                <a
                                                    href="{{ route('blog.edit', ['id' => $blog->id, 'lang' => $language->code]) }}"><i
                                                        class="text--primary bi bi-pencil-square"></i></a>
                                            @endif
                                        @endforeach
                                    </td>
                                    <td data-label="Action">
                                        <div
                                            class="d-flex flex-row justify-content-md-center justify-content-end align-items-center gap-2">
                                            <a target="_blank" class="eg-btn account--btn"
                                                href="{{ url('blog/' . $blog->slug) }}"><i
                                                    class="bi bi-box-arrow-up-right"></i></a>
                                            <a class="eg-btn add--btn"
                                                href="{{ route('blog.edit', ['id' => $blog->id, 'lang' => get_setting('DEFAULT_LANGUAGE', 'en')]) }}"><i
                                                    class="bi bi-pencil-square"></i></a>
                                            <form method="POST" action="{{ route('blog.delete', $blog->id) }}">
                                                @csrf
                                                <input name="_method" type="hidden" value="DELETE">
                                                <button type="submit" class="eg-btn delete--btn show_confirm"
                                                    data-toggle="tooltip" title="{{ translate('Delete') }}"><i
                                                        class="bi bi-trash"></i></button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" data-label="Not Found">
                                    <h5 class="data-not-found">{{ translate('No Data Found') }}</h5>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @push('footer')
        <div class="d-flex justify-content-center custom-pagination">
            {!! $blogs->links() !!}
        </div>
    @endpush
@endsection
