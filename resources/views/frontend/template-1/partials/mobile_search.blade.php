<div class="mobile-search">
    <div class="container">
        <form action="{{ route('main.search') }}" method="post">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-md-11">
                    <label>{{ translate('What are you lookking for') }}?</label>
                    <input type="text" name="search"
                        placeholder="{{ translate('Search Products') }}, {{ translate('Category') }}">
                </div>
                <div class="col-1 d-flex justify-content-end align-items-center">
                    <div class="search-cross-btn">
                        <i class="bi bi-x"></i>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
