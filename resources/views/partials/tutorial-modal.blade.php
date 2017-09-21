<div id="tutorial-modal" class="modal fade" tabindex="-1" role="dialog" 
  aria-labelledby="myLargeModalLabel">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-center">@lang('map.how_to_use_map')</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <iframe	id="tutorial-iframe" src="{{url('help')}}"></iframe>
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

