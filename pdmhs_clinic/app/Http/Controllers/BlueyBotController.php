<?php

namespace App\Http\Controllers;

use App\Services\BlueyHealthBot;
use Illuminate\Http\Request;

class BlueyBotController extends Controller
{
    private $bluey;

    public function __construct(BlueyHealthBot $bluey)
    {
        $this->bluey = $bluey;
    }

    /**
     * Show Bluey chat interface
     */
    public function index()
    {
        $topics = $this->bluey->getTopics();
        $healthTip = $this->bluey->getHealthTip();
        
        return view('bluey.chat', compact('topics', 'healthTip'));
    }

    /**
     * Process question via AJAX
     */
    public function ask(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:500'
        ]);

        $response = $this->bluey->ask($request->question);

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

    /**
     * Get random health tip
     */
    public function tip()
    {
        return response()->json([
            'success' => true,
            'tip' => $this->bluey->getHealthTip()
        ]);
    }

    /**
     * Get all topics
     */
    public function topics()
    {
        return response()->json([
            'success' => true,
            'topics' => $this->bluey->getTopics()
        ]);
    }
}
