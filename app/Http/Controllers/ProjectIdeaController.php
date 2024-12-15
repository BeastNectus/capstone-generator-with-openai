<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Industry;
use App\Models\ProjectType;
use App\Models\GeneratedIdea;
use OpenAI\Laravel\Facades\OpenAI;
use Illuminate\Support\Facades\Log;


class ProjectIdeaController extends Controller
{
    public function index()
    {
        $industries = Industry::all();
        $projectTypes = ProjectType::all();
        $difficulties = ['Beginner', 'Intermediate', 'Advanced'];
        
        return view('project-idea.index', compact('industries', 'projectTypes', 'difficulties'));
    }
    
    public function generate(Request $request)
    {
        $request->validate([
            'industry_id' => 'required|exists:industries,id',
            'project_type_id' => 'required|exists:project_types,id',
            'difficulty' => 'required|in:Beginner,Intermediate,Advanced',
        ]);

        $industry = Industry::find($request->industry_id);
        $projectType = ProjectType::find($request->project_type_id);

        try {
            $systemMessage = <<<EOT
    You are a helpful project idea generator that provides detailed capstone project suggestions.
    Always return your response as valid JSON with the following structure:
    {
        "title": "A concise project title",
        "description": "A short 1 sentence description of the project",
        "programming_languages": ["Language1", "Language2"],
        "suggested_roles": ["Role1", "Role2"],
        "similar_projects": [
            {
                "name": "Project Name",
                "link": "URL to the project (Demo)"
            }
        ],
        "timeline": {
            "planning_phase": "Detailed planning phase description and duration",
            "development_phase": "Detailed development phase description and duration",
            "testing_phase": "Detailed testing phase description and duration",
            "deployment_phase": "Detailed deployment phase description and duration",
            "total_duration": "Estimated total project duration"
        }
    }
    When providing similar projects, include real, existing projects with actual demo links.
    EOT;

            $prompt = <<<EOT
    Generate a capstone project idea for {$industry->name} industry, 
    project type: {$projectType->name}, difficulty level: {$request->difficulty}.
    Include a detailed project description, recommended programming languages,
    team roles, similar existing projects (with real demo links), and a comprehensive timeline breakdown.
    EOT;

            $response = OpenAI::chat()->create([
                'model' => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $systemMessage
                    ],
                    [
                        'role' => 'user',
                        'content' => $prompt
                    ]
                ],
                'temperature' => 0.7,
                'max_tokens' => 500,
            ]);

            $generatedContent = json_decode($response->choices[0]->message->content, true);

            if (!$generatedContent || json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response from OpenAI');
            }

            $idea = GeneratedIdea::create([
                'title' => $generatedContent['title'],
                'description' => $generatedContent['description'],
                'programming_languages' => $generatedContent['programming_languages'],
                'suggested_roles' => $generatedContent['suggested_roles'],
                'similar_projects' => $generatedContent['similar_projects'],
                'timeline' => $generatedContent['timeline'],
                'industry_id' => $request->industry_id,
                'project_type_id' => $request->project_type_id,
                'difficulty' => $request->difficulty,
            ]);

            $idea->load(['industry', 'projectType']); 
            
            return response()->json($idea->fresh());

        } catch (\Exception $e) {
            Log::error('OpenAI API Error: ' . $e->getMessage());
            return response()->json([
                'error' => 'Failed to generate project idea: ' . $e->getMessage()
            ], 500);
        }
    }
}
