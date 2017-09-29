<div id="popup">
    <h6>@lang('site.tree_info')</h6>
    <table class="table table-sm">
        <thead>
            <tr>
                <th>@lang('site.height')</th>
                <th>@lang('site.location')</th>
                <th>@lang('site.tree_id')</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><span id="tree-height"></span> ft.</td>
                <td><span id="tree-location"></span></td>
                <td><span id="tree-id"></span></td>
            </tr>
        </tbody>
    </table>
    <h6>@lang('site.whats_your_story')</h6>
    <div id="popup-form">
        <form id="form" class="form" method="post" action="/post">
            <div class="form-group">
                <input type="hidden" name="tree_location" value="--tree_location--" />
                <input type="hidden" name="tree_id" value="--tree_id--" />
                <textarea rows="10" class="form-control" name="treestory" id="textbox"
                          placeholder="@lang('site.share_here')"></textarea>
            </div>
        </form>
        <input name='file' type="file" id="file" style="display:none" />
        <div id="dropbox" class="alert alert-default">
            <div class="text-center">
              <strong>@lang('site.do_you_have_a_photo')
              </strong>
            </div>
        </div>

        <div class="progress" style="display:none">
            <div class="progress-bar" role="progressbar" style="width: 0%;" id="progress-bar"></div>
        </div>
        <button class="btn btn-primary" id="submit-treestory">@lang('site.submit')</button>
    </div>
</div>
