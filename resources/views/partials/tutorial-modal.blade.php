<div id="tutorial-modal" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" 
  aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        @if(\App::getLocale() === 'en')
          <a href="?lang=es" type="button" 
            class="btn btn-default btn-sm" id="language-choice">
            <span class="text-muted"><span class="lang-sm lang-lbl" lang="es"></span></span>
          </a>
        @else
          <a href="?lang=en" type="button" 
            class="btn btn-default btn-sm" id="language-choice">
            <span class="text-muted"><span class="lang-sm lang-lbl" lang="en"></span></span>
          </a>
        @endif
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h1 class="modal-title text-center" >{{ config('app.name')}}</h1>
      </div>
      <div class="modal-body">
        <iframe	id="tutorial-iframe" src="{{url('help')}}?lang={{\App::getLocale()}}"></iframe>
      </div>
      <div class="modal-footer-center">
        <button type="button" class="btn btn-primary" 
          data-dismiss="modal" aria-label="Close">
            @lang('map.tell_my_story_button')
        </button>
      </div>
    </div>
  </div>
</div>

