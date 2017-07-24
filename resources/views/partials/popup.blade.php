<div id="popup-form">
    <form id="form" class="form-inline" method="post" action="/post">
        <div class="form-group">
            <input type="hidden" name="tree_location" value="--tree_location--" />
            <input type="hidden" name="tree_id" value="--tree_id--" />
            <textarea rows="4" cols="30" class="form-control" name="treestory" id="textbox" placeholder="What's Your Tree Story?"></textarea>
        </div>
    </form>
    <input name='file' type="file" id="file" style="display:none" />
    <div id="dropbox" class="alert alert-default">
        <div class="text-center">
          <strong>Do you have a picture of this tree? 
            <br/> Click here <em>or</em> drop it in this area to upload it.
          </strong>
        </div>
    </div>

    <div class="progress" style="display:none">
        <div class="progress-bar" role="progressbar" style="width: 0%;" id="progress-bar"></div>
    </div>
    <button class="btn btn-primary" id="submit-treestory">Submit</button>
</div>
