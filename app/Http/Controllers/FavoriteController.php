<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Word;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function index()
    {
        $favoriteWords = Auth::user()->favoriteWords()
            ->with('category')
            ->paginate(20);

        return view('favorites.index', compact('favoriteWords'));
    }

    public function store(Word $word)
    {
        $user = Auth::user();

        if (!$word->isFavoritedBy($user)) {
            Favorite::create([
                'user_id' => $user->id,
                'word_id' => $word->id,
            ]);

            return back()->with('success', 'Word added to favorites!');
        }

        return back()->with('info', 'Word is already in your favorites.');
    }

    public function destroy(Word $word)
    {
        $user = Auth::user();
        
        Favorite::where('user_id', $user->id)
            ->where('word_id', $word->id)
            ->delete();

        return back()->with('success', 'Word removed from favorites.');
    }

    public function toggle(Word $word)
    {
        $user = Auth::user();

        if ($word->isFavoritedBy($user)) {
            $this->destroy($word);
            $message = 'Word removed from favorites.';
        } else {
            $this->store($word);
            $message = 'Word added to favorites!';
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => $message]);
        }

        return back()->with('success', $message);
    }
}