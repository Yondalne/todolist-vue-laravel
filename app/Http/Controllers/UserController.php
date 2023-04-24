<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function update(Request $request)
    {
        $user = (auth()->user());
        // if ($user->id != auth()->user()->id) {
        //     return response()->json([
        //         "status" => false,
        //         "message" => "You can't modify an other user's profile"
        //     ]);
        // }
        $user->fill($request->all());
        if (!empty($request->file())) {
            $name = auth()->user()->pseudo."_background-image.".$request->file("background")->getClientOriginalExtension();
            $path = $request->file("background")->storeAs("backgrounds", $name, "public");
            if (Storage::exists("public/".$user->background))  {
                Storage::delete("public/".$user->background);
                $user->background = "";
            }
            // $path = "storage/".$path;
            $user->background = $path;
        }

        $user->update();

        return response()->json([
            "status" => true,
            "user" => $user,
            "message" => "User updated successfully",
        ]);
    }

    public function deleteImage(Request $request)
    {
        dd(Storage::exists("public/".$request->path));

        if (Storage::exists($request->path)) {
            Storage::delete($request->path);
            return response()->json([
                "status" => true,
                "message" => "Image deleted successfully deleted"
            ]);
        }

    }
}
