<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Suggestion;
use App\Models\Song;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class SuggestionController extends Controller
{
    public function index()
    {
        if (!User::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $suggestions = Suggestion::with('user')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return response()->json($suggestions);
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

        $suggestion = Suggestion::create([
            'user_id' => Auth::id(),
            'title' => $request->title,
            'youtube_link' => $request->youtube_link,
            'status' => 'pending'
        ]);

        return response()->json($suggestion, 201);
    }

    public function approve(Suggestion $suggestion)
    {
        if (!User::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $suggestion->update(['status' => 'approved']);

        // Criar nova música quando a sugestão for aprovada
        $song = Song::create([
            'title' => $suggestion->title,
            'youtube_link' => $suggestion->youtube_link,
            'is_approved' => true,
            'plays' => 0,
        ]);

        return response()->json([
            'suggestion' => $suggestion,
            'song' => $song
        ]);
    }

    public function reject(Request $request, Suggestion $suggestion)
    {
        if (!User::user()->isAdmin()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validator = Validator::make($request->all(), [
            'rejection_reason' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $suggestion->update([
            'status' => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        return response()->json($suggestion);
    }
}
