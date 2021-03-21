<?php
#==============  Downloadable file setup  =================
//==============================================================================

# set a button link where you want to click for download file
# Example...
<a href="{{ url('/download_cv') }}">Download</a>
//==============================================================================

# make a route in web.php
# Example...
Route::get("/download_cv", 'FrontendController@download_cv');
//==============================================================================

# Controller
# call it top side of Controller
use Response;

# now create a function in controller
# Example...
function download_cv(){
    $filename = Mycv::find(1)->cv_file;  # Example Model "Mycv"
    $file = public_path("/uploads/cv/".$filename);

    // return Response::download($file);   # use for only Download
    # OR -- use this code for view in Browser
    return Response::make(file_get_contents($file), 200, [
        'Content-Type' => 'application/pdf',
        'Content-Disposition' => 'inline; filename="'.$filename.'"'
    ]);
}
//==============================================================================

//=== END ===//
