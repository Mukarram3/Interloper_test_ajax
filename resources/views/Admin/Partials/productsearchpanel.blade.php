<div id="aside" class="col-md-3">

{{--    <form action="{{route('search')}}" class="searchform" method="post">--}}

    <!-- aside Widget -->
    <div id="get_category">

        <div class="aside">
            <h3 class="aside-title">Categories</h3>
            <div class="btn-group-vertical">

                @foreach($categories as $category)



                <div type="" class="navbar category">

                    <input type="checkbox" class="searchID" id="categoryid['{{$category->id}}']" name="category_checkbox" data-id="{{$category->id}}">
                    <label type="" for="categoryid['{{$category->id}}']" class="category_id">
                        {{$category->CategoryName}}
                    </label>
                </div>

                @endforeach

            </div>

        </div>
    </div>
    <!-- /aside Widget -->

    <!-- aside Widget -->
    <div class="aside">
        <div id="slider-wrap" class="mb-5">
            <p>
                <label for="amount">Price range:</label>
                <input type="text" id="amount" readonly style="border:0; color:#f6931f; font-weight:bold;">
            </p>

            <div id="slider-range"></div>
            <input type="hidden" id="min-value">
            <input type="hidden" id="max-value">
          </div>
    </div>
    <!-- /aside Widget -->

{{--    </form>--}}
</div>
