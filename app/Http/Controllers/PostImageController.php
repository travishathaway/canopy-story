<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostImage;

class PostImageController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

  /**
   * Handles the creation of a post image
   */
  public function create(Request $request)
  {
      $filename = $request->resumableIdentifier . $request->resumableFilename;
      $path = $request->file('file')->storeAs(
          'public', $filename
      );
      return $path;
  }
}
