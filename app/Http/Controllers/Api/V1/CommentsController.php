<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comments;

class CommentsController extends Controller
{
    public function comments(Request $request) {
        $request->validate([
            "post_id" => "required",
            "post_email" => "required",
            "user_id" => "required",
            "user_email" => "required|email",
            "user_name" => "required",
            "unique_id" => "required",
            "comments" => "required",
            "comments_vid_path" => "nullable|mimes:mp4,avi,mov,wmv,flv",
            'comments_img_path' => 'array',
            'comments_img_path.*' => "nullable|image|max:2048",
            "comments_link" => "nullable",
        ]);


        $imagePaths = [];
        if ($request->hasFile('comments_img_path')) {
            foreach ($request->file('comments_img_path') as $imageFile) {
                $imageSize = $imageFile->getSize();

                if ($imageSize > 2048000) { // 2MB in bytes
                    $image = Image::make($imageFile)->resize(500, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });

                    $imagePath = 'public/commentsimages/' . $imageFile->hashName();
                    $image->save(storage_path('app/' . $imagePath));
                } else {
                    $imagePath = $imageFile->store('public/commentsimages');
                }
                $imagePaths[] = $imagePath;
            }
        } else {
            $imagePaths[] = "no image uploaded";
        }

        // Handle video upload
        if ($request->hasFile('comments_vid_path')) {
            $videoPath = $request->file('comments_vid_path')->store('public/commentsvideos');
        } else {
            $videoPath = "no file uploaded";
        }


        $comments = Comments::create([
            "post_id" => $request->post_id,
            "post_email" => $request->post_email,
            "user_id" => $request->user_id,
            "user_email" => $request->user_email,
            "user_name" => $request->user_name,
            "unique_id" => $request->unique_id,
            "comments" => $request->comments,
            "comments_vid_path" => $videoPath,
            "comments_img_path" => $imageFile,
            "comments_link" => $request->comments_link,
        ]);

        return reponse()->json([
            "status" => true,
            "message" => "Comment Uploaded Successfully"
        ]);
 
    }
}
