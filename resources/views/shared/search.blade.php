<form action="" method="GET">
    <div class="input-group">
        <input type="text" name="keyword" class="form-control" placeholder="Search Something ..." value="{{ request()->get('keyword') }}">
        <button class="btn btn-success" type="submit" name="search"><i class="far fa-search"></i></button>
        <button class="btn btn-primary" type="submit" name="export"><i class="far fa-file-export"></i></button>
    </div>
</form>