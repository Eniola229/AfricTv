<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\Models\Post;

class PostController extends Controller
{
    public function posts(Request $request)
    {
        // Data Validation
        $request->validate([
            "user_id" => "required",
            "user_name" => "required",
            "unique_id" => "required",
            "user_email" => "required|email",
            "post_title" => "nullable",
            "post_img_path" => "nullable|image|max:2048",
            'post_vid_path' => 'nullable|mimes:mp4,avi,mov,wmv,flv',
            "post_pdf_path" => "nullable|mimes:pdf,doc,docx",
            "post_song_path" => "nullable|mimes:mp3,wav,aac,flac",
            "category" => "required",
            "link" => "nullable",
            "post_intro" => "nullable",
            "post_body" => "required",
            "post_ending" => "nullable",
            "post_views" => "nullable",
            "date" => "nullable|date",
        ]);

        // Handle image upload and resizing
        if ($request->hasFile('post_img_path')) {
            $imageFile = $request->file('post_img_path');
            $imageSize = $imageFile->getSize();

            if ($imageSize > 2048000) { // 2MB in bytes
                $image = Image::make($imageFile)->resize(500, null, function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });

                $imagePath = 'public/images/' . $imageFile->hashName();
                $image->save(storage_path('app/' . $imagePath));
            } else {
                $imagePath = $imageFile->store('public/images');
            }
        } else {
            $imagePath = "no file uploaded";
        }

        // Handle video upload
        if ($request->hasFile('post_vid_path')) {
            $videoPath = $request->file('post_vid_path')->store('public/videos');
        } else {
            $videoPath = "no file uploaded";
        }

        // Handle document upload
        if ($request->hasFile('post_pdf_path')) {
            $docPath = $request->file('post_pdf_path')->store('public/documents');
        } else {
            $docPath = "no file uploaded";
        }

        // Handle song upload
        if ($request->hasFile('post_song_path')) {
            $songPath = $request->file('post_song_path')->store('public/songs');
        } else {
            $songPath = "no file uploaded";
        }

        // Storing post data
        $post = Post::create([
            "user_id" => $request->user_id,
            "user_name" => $request->user_name,
            "unique_id" => $request->unique_id,
            "user_email" => $request->user_email,
            "post_title" => $request->post_title,
            "post_img_path" => $imagePath,
            "post_vid_path" => $videoPath,
            "post_pdf_path" => $docPath,
            "post_song_path" => $songPath,
            "category" => $request->category,
            "link" => $request->link,
            "post_intro" => $request->post_intro,
            "post_body" => $request->post_body,
            "post_ending" => $request->post_ending,
            "post_views" => $request->post_views ?? 0,
            "date" => $request->date,
        ]);

        return response()->json([
            "status" => true,
            "message" => "Post Uploaded Successfully"
        ]);
    }
    public function updateposts(Request $request){

        $postId = Post::id();
            $request->validate([
            "user_id" => "required",
            "user_name" => "required",
            "unique_id" => "required",
            "user_email" => "required|email",
            "post_title" => "nullable",
            "post_img_path" => "nullable|image|max:2048",
            'post_vid_path' => 'nullable|mimes:mp4,avi,mov,wmv,flv',
            "post_pdf_path" => "nullable|mimes:pdf,doc,docx",
            "post_song_path" => "nullable|mimes:mp3,wav,aac,flac",
            "category" => "required",
            "link" => "nullable",
            "post_intro" => "nullable",
            "post_body" => "required",
            "post_ending" => "nullable",
            "post_views" => "nullable",
            "date" => "nullable|date",
            ]);

            $posts = Post::find($postId);

    }
}
