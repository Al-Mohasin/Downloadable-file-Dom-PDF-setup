<?php
#=========  Download file by inputed link  ==========
//==============================================================================

# set a input field & button where you input the link & click for download file
# Example...
<form action="{{ url('/download_cv') }}" method="post">
    @csrf
    <input type="text" name="c_link">
    <button type="submit">Download</button>
</form>
//==============================================================================

# make a route in web.php
# Example...
Route::get("/download_cv", 'FrontendController@download_cv');
//==============================================================================

# Controller
# call it top side of Controller
use Response;

# create a function in controller
# Example...
public function download_cv(Request $request)
{
    $link = $request->c_link;
    $filename = rand(10, 1000000)."."."jpg";
    $download_file = tempnam(sys_get_temp_dir(), $filename);
    copy($link, $download_file);

    return response()->download($download_file, $filename);
}
//==============================================================================

//=== END ===//
