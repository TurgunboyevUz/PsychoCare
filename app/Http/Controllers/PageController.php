<?php
namespace App\Http\Controllers;

use App\Models\UserMood;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function doctor()
    {
        return '<h1>There should be doctor page</h1>';
    }

    public function mood(Request $request, $hash)
    {
        $data                     = base64_decode($hash);
        list($user_id, $datetime) = explode('-', $data);

        // Get the original Eloquent collection for the Blade template
        $moods = UserMood::where('tele_user_id', $user_id)
            ->with('mood')
            ->get();

        // Create transformed data for JavaScript
        $moodDataForJs = $moods->map(function ($mood) {
            return [
                'date'    => $mood->created_at,
                'value'   => $mood->mood->value,
                'comment' => $mood->comment,
                'emoji'   => $mood->mood->emoji_label,
            ];
        });

        return view('graph', [
            'moods'         => $moods,         // Original collection for Blade
            'moodDataForJs' => $moodDataForJs, // Transformed data for JS
        ]);
    }
}
