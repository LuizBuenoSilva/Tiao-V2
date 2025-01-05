<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SongController extends Controller
{
    public function index()
    {
        $topSongs = Song::where('is_approved', true)
            ->orderBy('plays', 'desc')
            ->paginate(10);

        return response()->json($topSongs);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $song = Song::create([
            'title' => $request->title,
            'youtube_link' => $request->youtube_link,
            'is_approved' => User::user()->isAdmin(),
            'plays' => 0,
        ]);

        return response()->json($song, 201);
    }

    public function update(Request $request, Song $song)
    {
        if (!User::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'youtube_link' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $song->update($request->all());

        return response()->json($song);
    }

    public function destroy(Song $song)
    {
        if (!User::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $song->delete();

        return response()->json(null, 204);
    }

    public function incrementPlays(Song $song)
    {
        $song->increment('plays');
        return response()->json(['plays' => $song->plays]);
    }
}
