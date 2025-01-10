@extends('backend.layouts.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('backend/css/nestable.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/css/menu.css') }}">
@endpush
@section('breadcrumb')
    <div class="breadcrumb-area">
        <h5>{{ translate('Dashboard') }}</h5>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('backend.dashboard') }}">{{ translate('Dashboard') }}</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ translate('Menu') }}</li>
            </ol>
        </nav>
    </div>
@endsection
@section('content')
    <div class="row mb-35">
        <div class="page-title d-flex gap-3 align-items-center page-menu-list">
            @if (count($menus) > 0)
                <h6 class="text-sucess">{{ translate('Select a menu') }} </h6>
                <div class="page-menu-item-list d-flex">
                    <form class="d-flex gap-3" id="menu-form" method="GET" action="{{ route('menu.list') }}">
                        @foreach ($menus as $menu)
                            <div class="form-check">
                                <input
                                    class="form-check-input menu-change {{ $selectedMenu ? ($menu->id == $selectedMenu ? '' : '') : ($loop->first ? 'default-checked' : '') }}"
                                    type="checkbox"
                                    @if ($selectedMenu) {{ $menu->id == $selectedMenu ? 'checked' : '' }}

                                     @else
                                     {{ $loop->first ? 'checked' : '' }} @endif
                                    value="{{ $menu->id }}" id="menu{{ $menu->id }}" name="id">
                                <label class="form-check-label" for="menu{{ $menu->id }}">
                                    {{ $menu->getTranslation('name') }}</label>
                            </div>
                        @endforeach
                    </form>
                </div>
            @endif
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4">
            <div class="eg-card product-card add-menu-item">
                <h4><span>{{ translate('Add Menu Item') }}</span></h4>
                <div class="row">
                    <div class="col-12">
                        <div class="accordion item-area-list" id="accordionMenu">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="categoryList">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#categories-list" aria-expanded="true"
                                        aria-controls="categories-list">
                                        {{ translate('Categories') }}
                                    </button>
                                </h2>
                                <div id="categories-list" class="accordion-collapse collapse" aria-labelledby="categoryList"
                                    data-bs-parent="#accordionMenu">
                                    <div class="accordion-body">
                                        <input type="hidden" name="menu_type" value="category" id="menu_type">
                                        @foreach ($categories as $category)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    name="categories[]"value="{{ $category->id }}"
                                                    id="category{{ $category->id }}">
                                                <label class="form-check-label" for="category{{ $category->id }}">
                                                    {{ $category->getTranslation('name') }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="mt-2"></div>
                                        <div class="justify-content-between">
                                            <label class="btn btn-sm btn-default border-3 border-secondary"><input
                                                    class="form-check-input checked-all-item" type="checkbox">
                                                {{ translate('Select All') }}</label>
                                            <button type="button"
                                                class="pull-right btn btn-default btn-sm border-3 border-secondary add-menu"
                                                id="add-categories"> {{ translate('Add to Menu') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="pagesList">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#pages-list" aria-expanded="true" aria-controls="pages-list">
                                        {{ translate('Pages') }}
                                    </button>
                                </h2>
                                <div id="pages-list" class="accordion-collapse collapse pages-list"
                                    aria-labelledby="pagesList" data-bs-parent="#accordionMenu">
                                    <div class="accordion-body">
                                        <input type="hidden" name="menu_type" value="page" id="menu_type">
                                        @foreach ($pages as $page)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="{{ $page->id }}"
                                                    name="pages[]" id="page{{ $page->id }}">
                                                <label class="form-check-label cursor-pointer "
                                                    for="page{{ $page->id }}">
                                                    {{ $page->getTranslation('page_name') }}
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="mt-2"></div>
                                        <div class="justify-content-between">
                                            <label class="btn btn-sm btn-default border-3 border-secondary"><input
                                                    class="form-check-input checked-all-item" type="checkbox">
                                                {{ translate('Select All') }}</label>
                                            <button type="button"
                                                class="pull-right btn btn-default btn-sm border-3 border-secondary add-menu"
                                                id="add-pages">{{ translate('Add to Menu') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="blogsList">
                                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#blogs-list" aria-expanded="true" aria-controls="blogs-list">
                                        {{ translate('Blogs') }}
                                    </button>
                                </h2>
                                <div id="blogs-list" class="accordion-collapse collapse pages-list"
                                    aria-labelledby="blogsList" data-bs-parent="#accordionMenu">
                                    <div class="accordion-body">
                                        <input type="hidden" name="menu_type" value="blog" id="menu_type">
                                        @foreach ($blogs as $blog)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    value="{{ $blog->id }}" id="blog{{ $blog->id }}"
                                                    name="blogs[]">
                                                <label class="form-check-label" for="blog{{ $blog->id }}">
                                                    {{ Str::limit($blog->getTranslation('title'), 15) }}...
                                                </label>
                                            </div>
                                        @endforeach
                                        <div class="mt-2"></div>
                                        <div class="justify-content-between">
                                            <label class="btn btn-sm btn-default border-3 border-secondary ">
                                                <input class="form-check-input checked-all-item" type="checkbox">
                                                {{ translate('Select All') }}</label>
                                            <button type="button"
                                                class="pull-right btn btn-default btn-sm border-3 border-secondary add-menu"
                                                id="add-blogs"> {{ translate('Add to Menu') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="customLink">
                                    <button class="accordion-button" type="button"
                                        data-bs-toggle="collapse"data-bs-target="#custom-link" aria-expanded="true"
                                        aria-controls="custom-link">{{ translate('Custom Link') }}
                                    </button>
                                </h2>
                                <div id="custom-link" class="accordion-collapse collapse" aria-labelledby="customLink"
                                    data-bs-parent="#accordionMenu">
                                    <div class="accordion-body">
                                        <input type="hidden" name="menu_type" value="custom" id="menu_type">
                                        <div class="form-inner mb-3">
                                            <label>{{ translate('Menu Name') }}<span>*</span></label>
                                            <input type="text" class="username-input" name="custom_menu_name"
                                                id="custom_menu_name" placeholder="Menu Name">
                                            <div class="text-danger"></div>

                                        </div>
                                        <div class="form-inner mb-3">
                                            <label> {{ translate('Link') }}</label>
                                            <input type="text" class="username-input" name="custom_link"
                                                id="custom_link" placeholder="https://">
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="newTap"
                                                name="new_tap">
                                            <label class="form-check-label"
                                                for="newTap">{{ translate('Open In New Window') }} ?</label>
                                        </div>


                                        <div class="justify-content-between">
                                            <button type="button"
                                                class="pull-right btn btn-default btn-sm border-3 border-secondary add-menu"
                                                id="add-custom-menu"> {{ translate('Add to Menu') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="col-lg-8">
            <div class="eg-card product-card menu-structure">
                <h4><span>{{ translate('Menu Structure') }}</span></h4>

                <input type="hidden" name="lang" id="lang" value="{{ \App::getLocale() }}">

                <p> {{ translate('add') }}
                    {{ translate('Categories') }},{{ translate('Pages') }},{{ translate('Blogs') }} or
                    {{ translate('Custom Link') }} {{ translate('to the menu') }} </p>

                <div class="dd" id="nestable">
                    <ol class="dd-list">

                        @if (!empty($itemsWithChildrens))
                            @foreach ($itemsWithChildrens as $item)
                                <li class="dd-item" data-id="{{ $item->id }}">
                                    <div class="dd-handle">
                                        @if ($item->menu_type == 'page')
                                            {{ $item?->page?->getTranslation('page_name') }}
                                            (<b>{{ translate("$item->menu_type") }}</b>)
                                        @elseif ($item->menu_type == 'category')
                                            {{ $item->category->getTranslation('name') }}
                                            (<b>{{ translate("$item->menu_type") }}</b>)
                                        @elseif ($item->menu_type == 'blog')
                                            {{ $item?->blog?->getTranslation('title') }}
                                            (<b>{{ translate("$item->menu_type") }}</b>)
                                        @else
                                            {{ $item->getTranslation('title') }}
                                            (<b>{{ translate("$item->menu_type") }}</b>)
                                        @endif
                                    </div>
                                    <div class='action-area'>
                                        @if ($item->menu_type == 'custom')
                                            <a href="#" class="btn add--btn shadow me-2 edit-menu-item"
                                                data-bs-toggle="modal" data-bs-target="#editMenuItemModal"
                                                data-id="{{ $item->id }}">
                                                <i class="bi bi-pencil-square"></i>
                                            </a>
                                        @endif
                                        <a href='#' class='btn btn-danger delete cs-danger shadow '
                                            data-id="{{ $item->id }}">
                                            <i class="bi bi-trash"></i>

                                        </a>
                                    </div>
                                    @if ($item->childrens->count() > 0)
                                        <ol class="dd-list">
                                            @foreach ($item->childrens as $childItem)
                                                <li class="dd-item" data-id="{{ $childItem->id }}">
                                                    <div class="dd-handle">
                                                        @if ($childItem->menu_type == 'page')
                                                            {{ $childItem?->page?->getTranslation('page_name') }}
                                                            (<b>{{ translate("$childItem->menu_type") }}</b>)
                                                        @elseif ($childItem->menu_type == 'category')
                                                            {{ $childItem->category->getTranslation('name') }}
                                                            (<b>{{ translate("$childItem->menu_type") }}</b>)
                                                        @elseif ($childItem->menu_type == 'blog')
                                                            {{ $childItem?->blog?->getTranslation('title') }}
                                                            (<b>{{ translate("$childItem->menu_type") }}</b>)
                                                        @else
                                                            {{ $childItem->getTranslation('title') }}
                                                            (<b>{{ translate("$childItem->menu_type") }}</b>)
                                                        @endif
                                                    </div>

                                                    <div class='action-area'>

                                                        @if ($childItem->menu_type == 'custom')
                                                            <a href="#"
                                                                class="btn add--btn shadow me-2 edit-menu-item"
                                                                data-bs-toggle="modal" data-bs-target="#editMenuItemModal"
                                                                data-id="{{ $childItem->id }}">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </a>
                                                        @endif


                                                        <a href='#' class='btn btn-danger delete cs-danger shadow '
                                                            data-id="{{ $childItem->id }}">
                                                            <i class="bi bi-trash"></i>
                                                        </a>
                                                    </div>

                                                    @if ($childItem->childrens->count() > 0)
                                                        <ol class="dd-list">
                                                            @foreach ($childItem->childrens as $child)
                                                                <li class="dd-item" data-id="{{ $child->id }}">
                                                                    <div class="dd-handle">

                                                                        <div class="dd-handle">
                                                                            @if ($child->menu_type == 'page')
                                                                                {{ $child?->page?->getTranslation('page_name') }}
                                                                                (<b>{{ translate("$child->menu_type") }}</b>)
                                                                            @elseif ($child->menu_type == 'category')
                                                                                {{ $child->category->getTranslation('name') }}
                                                                                (<b>{{ translate("$child->menu_type") }}</b>)
                                                                            @elseif ($child->menu_type == 'blog')
                                                                                {{ $child?->blog?->getTranslation('title') }}
                                                                                (<b>{{ translate("$child->menu_type") }}</b>)
                                                                            @else
                                                                                {{ $child->getTranslation('title') }}
                                                                                (<b>{{ translate("$child->menu_type") }}</b>)
                                                                            @endif
                                                                        </div>

                                                                    </div>

                                                                    <div class='action-area'>
                                                                        @if ($child->menu_type == 'custom')
                                                                            <a href="#"
                                                                                class="btn add--btn shadow me-2 edit-menu-item"
                                                                                data-bs-toggle="modal"
                                                                                data-bs-target="#editMenuItemModal" d
                                                                                data-id="{{ $child->id }}">
                                                                                <i class="bi bi-pencil-square"></i>
                                                                            </a>
                                                                        @endif
                                                                        <a href='#'
                                                                            class='btn btn-danger delete cs-danger shadow '
                                                                            data-id="{{ $child->id }}">
                                                                            <i class="bi bi-trash"></i>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ol>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                </li>
                            @endforeach
                        @endif

                    </ol>
                </div>

            </div>
        </div>
    </div>


    <div class="modal fade menu-modal" id="editMenuItemModal" tabindex="-1" aria-labelledby="editMenuItemModal"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <p class="modal-title" id="exampleModalLabel">{{ translate('Menu Edit') }}</p>
                    <a type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </a>
                </div>
                <div class="modal-body">
                    <form action="{{ route('menu.item.update') }}" method="POST" class="add-form">
                        @csrf
                        <input type="hidden" id="menuItemId" name="id" />
                        <div class="form-inner mb-3">
                            <label> {{ translate('Menu Name Item') }} <span>*</span></label>
                            <input type="text" class="username-input" id="menuItemName" name="title"
                                placeholder="Menu Item Name">
                            <span class="text-danger error-text title_err"></span>
                        </div>
                        <div class="custom-field">

                        </div>

                        <div class="button-group d-flex justify-content-end mt-30">
                            <button type="button" class="btn btn-danger sm-btn shadow me-2"
                                data-bs-dismiss="modal">{{ translate('Close') }}</button>
                            <button type="submit"
                                class="eg-btn btn--green sm-btn shadow">{{ translate('Update') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('backend/js/nestable.min.js') }}"></script>
    <script src="{{ asset('backend/js/sweetalert2.js') }}"></script>
    @include('js.admin.menu')
@endpush
