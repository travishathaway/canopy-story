<div class="row first-block front-page-bg tree-image-1">
    <div class="first-block-content">
        <div class="row">
            <div class="col-md">
                <h1 class="title-text">Canopy Story</h1>
                <p class="sub-text">
                    Telling the stories of trees and the impact they make 
                    on our communities.
                </p>
            </div>
            <div class="col-md">
                <div class="front-page-actions d-none d-md-block">
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-primary btn-lg" href="{{ route('map') }}">
                                @lang('menu.tell_story')
                            </a>
                            <a class="btn btn-secondary btn-lg" href="{{ route('post') }}">
                                @lang('menu.find_stories')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-none d-sm-none">
                    <div class="row">
                        <div class="col">
                            <a class="btn btn-primary btn-lg" href="{{ route('map') }}">
                                @lang('menu.tell_story')
                            </a>
                            <a class="btn btn-secondary btn-lg" href="{{ route('post') }}">
                                @lang('menu.find_stories')
                            </a>
                        </div>
                    </div>
                </div>
                <div class="d-sm-block d-md-none d-lg-none d-xl-none">
                    <a class="btn btn-primary" href="{{ route('map') }}">
                        @lang('menu.tell_story')
                    </a>
                    <a class="btn btn-secondary" href="{{ route('post') }}">
                        @lang('menu.find_stories')
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

