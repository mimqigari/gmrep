<?php

namespace App\Http\Controllers;

use App\Post;
use App\Reaction;
use App\ReactionIcon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ReactionController extends Controller
{
    public function __construct()
    {
        if (get_buzzy_config('sitevoting') == "1") {
            $this->middleware('auth', ['only' => ['vote']]);
        }
    }

    /**
     * Show Reaction Pages
     *
     * @param  $catname
     * @param  Request $req
     * @return \BladeView|bool|\Illuminate\View\View
     */
    public function show(ReactionIcon $reactionIcon)
    {
        $posts = Post::select('posts.*')
            ->leftJoin(
                'reactions',
                function ($leftJoin) {
                    $leftJoin->on('reactions.post_id', '=', 'posts.id');
                }
            )
            ->where('reactions.reaction_type', '=', $reactionIcon->reaction_type)
            ->byPublished()
            ->byLanguage()
            ->byApproved()
            ->orderBy(DB::raw('COUNT(reactions.post_id) '), 'desc')
            ->groupBy("posts.id")->paginate(15);

        $reaction = $reactionIcon;

        return view("pages.reaction", compact("posts", "reaction"));
    }

    public function vote(ReactionIcon $reactionIcon, Post $post)
    {
        if (!request()->ajax()) {
            return redirect()->route('home');
        }

        if (Reaction::currentUserHasVoteOnPost($post->id)->count() <= 2) {
            Reaction::firstOrNew([
                'post_id' => $post->id,
                'user_id' => auth()->check() ? auth()->user()->id : request()->ip(),
                'reaction_type' => $reactionIcon->reaction_type
            ])->save();
        }

        return view('_particles.post.reactions', compact("post"));
    }
}
