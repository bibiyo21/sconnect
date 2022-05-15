<form id="cog-pagination" name="cog-pagination" class="row row-cols-lg-auto g-3 align-items-center">
    <div class="col-12">
        <span>Show</span>
    </div>
    <div class="col-12">
        <input name="limit" style="width: 100px;" type="number" class="form-control" value="{{ request()->get('limit', 100) }}">
    </div>

    <div class="col-12">
        <span> Page</span>
    </div>
    <div class="col-12">
        <input name="page" style="width: 100px;" type="number" class="form-control" value="{{ request()->get('page', 1) }}">
    </div>
    <div class="col-12">
        <span> / {{ $paginator->lastPage() }}</span>
    </div>
    <div class="col-12">
        <div class="btn-group">
            <a href="{{ $paginator->appends(Request::except('page'))->url(1) }}" class="btn btn-outline-primary"><i class="fas fa-chevron-double-left"></i></a>
            @if($paginator->onFirstPage())
                <span class="btn btn-outline-primary"><i class="fas fa-chevron-left"></i></span>
            @else 
                <a href="{{ $paginator->appends(Request::except('page'))->previousPageUrl() }}" class="btn btn-outline-primary"><i class="fas fa-chevron-left"></i></a>
            @endif

            @if($paginator->hasMorePages())
                <a href="{{ $paginator->appends(Request::except('page'))->nextPageUrl() }}" class="btn btn-outline-primary"><i class="fas fa-chevron-right"></i></a>
            @else 
                <span class="btn btn-outline-primary"><i class="fas fa-chevron-right"></i></span>
            @endif
                
            <a href="{{ $paginator->appends(Request::except('page'))->url($paginator->lastPage()) }}" class="btn btn-outline-primary"><i class="fas fa-chevron-double-right"></i></a>
        </div>
    </div>
    <button class="d-none" type="submit"></button>
</form>