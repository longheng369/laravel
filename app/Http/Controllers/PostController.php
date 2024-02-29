<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function deleteFile($fileName)
    {
        // Check if the file exists
        if (Storage::exists('public' . $fileName)) {
            // Delete the file
            Storage::delete('public' . $fileName);
            return 'File deleted successfully';
        } else {
            return 'File not found';
        }
    }

    //Get all
    public function index(){
        $posts = Post::all();
        return response()->json([
            "data" => $posts
        ]);
    }

    

    public function store(Request $request ){
        $validate = $request->validate([
            "name" => "string|max:45",
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $url = "";

        if($request->hasFile("image")){
            $image = $request->file('image')->store('public/images');
            $url = Storage::url($image);
        }

        $post = Post::create([
            "name" => $request->name,
            "image" => $url
        ]);

        return response()->json(['message' => 'Post created successfully.', 'post' => $post], 201);
    }

    // delete function 
    public function destroy(Request $request, $id){
        $post = Post::find($id);
        if($post) {
            $imageName = str_replace('/storage', '', $post->image);
            $this->deleteFile($imageName);
            $post->delete();
            return response()->json(['message' => 'Post deleted successfully.']);
        } else {
            return response()->json(['message' => 'Post not found.'], 404);
        }
    }

    public function Update(Request $request,$id){
        $post = Post::find($id);
        if($post){
            if($request->has("name")){
                $post->name = $request->input("name");
            }

            if($request->hasFile("image")){
                // check if have old image in the old post
                if($post->image !== ""){
                    // delete old image in storage
                    Storage::delete($post->image);
                }
                // store new image
                $image = $request->file('image')->store('public/images');
                // generate url for that new image
                $url = Storage::url($image);
                // update image with new path
                $post->image = $url;
            }
            // update whole post
            $post->save();

            return response()->json(["message"=> "Post update successful"]);
        }
        else{
            return response()->json(['message' => 'Post not found.'], 404);
        }
    }

    
}
