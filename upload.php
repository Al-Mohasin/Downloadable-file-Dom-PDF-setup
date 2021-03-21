<?php
#===========  UPLOAD FILE  ===========#
#===============================================================================

# Blade -- Make a Form in blade file for Upload
# Example...
<form method="post" action="{{ url('cv_upload_post') }}" enctype="multipart/form-data">
    @csrf
    <input type="file" name="cv">
    <button type="submit">Submit</button>
</form>
#===============================================================================

# Route -- create route in web.php
# Example...
Route::post("/cv_upload_post", 'FrontendController@cv_upload_post');
#===============================================================================

# Controller -- for file upload in folder & send data in Database
# Example...
public function cv_upload_post(Request $request)
{
    if ($request->hasFile("cv")) {
        $extension = $request->cv->getClientOriginalExtension();
        $cv_name = "mycv_".time().".".$extension;
        $request->cv->move(public_path("uploads/cv/"), $cv_name);
        Mycv::find(1)->update([            // Example Model "Mycv"
            "cv_file"=>$cv_name,
        ]);
        return back()->with("success", "Upload success");
    };
}
#===============================================================================

#=== END ===
