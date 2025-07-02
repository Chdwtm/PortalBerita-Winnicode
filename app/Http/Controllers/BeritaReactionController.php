<?php

namespace App\Http\Controllers;

use App\Models\Berita;
use App\Models\BeritaReaction;
use Illuminate\Http\Request;

/**
 * @package App\Http\Controllers
 */
class BeritaReactionController extends Controller
{
    /**
     * Store a reaction for a berita
     * 
     * @param Request $request
     * @param Berita $berita
     * @return \Illuminate\Http\JsonResponse
     */
    public function react(Request $request, Berita $berita)
    {
        $type = $request->type; // 'like' or 'dislike'
        $user = auth()->user();

        $existingReaction = BeritaReaction::where('user_id', $user->id)
            ->where('berita_id', $berita->id)
            ->first();

        if ($existingReaction) {
            // If clicking the same reaction type, remove it
            if ($existingReaction->type === $type) {
                $existingReaction->delete();
            } else {
                // Change reaction type
                $existingReaction->update(['type' => $type]);
            }
        } else {
            // Create new reaction
            BeritaReaction::create([
                'user_id' => $user->id,
                'berita_id' => $berita->id,
                'type' => $type
            ]);
        }

        return response()->json([
            'likes' => $berita->reactions()->where('type', 'like')->count(),
            'dislikes' => $berita->reactions()->where('type', 'dislike')->count(),
            'user_reaction' => BeritaReaction::where('user_id', $user->id)
                ->where('berita_id', $berita->id)
                ->value('type')
        ]);
    }

    /**
     * Remove a reaction from a berita
     * 
     * @param Berita $berita
     * @return \Illuminate\Http\JsonResponse
     */
    public function remove(Berita $berita)
    {
        $user = auth()->user();
        
        BeritaReaction::where('user_id', $user->id)
            ->where('berita_id', $berita->id)
            ->delete();

        return response()->json([
            'likes' => $berita->reactions()->where('type', 'like')->count(),
            'dislikes' => $berita->reactions()->where('type', 'dislike')->count(),
            'user_reaction' => null
        ]);
    }
}
