<?php

namespace App\Http\Controllers;

use App\Module;

class ModuleController extends Controller
{
    public function index()
    {
        return view('modules.index', [
            'modules' => Module::all(),
            'completedModules' => auth()->check() ? auth()->user()->moduleCompletions()->pluck('completable_id') : collect([]),
        ]);
    }

    public function show($locale, Module $module)
    {
        return view('modules.show', [
            'module' => $module,
            'resources' => $module->resources,
            'skills' => $module->skills->where('is_bonus', false),
            'bonusSkills' => $module->skills->where('is_bonus', true),
            'completedResources' => auth()->check() ? auth()->user()->resourceCompletions()->pluck('completable_id') : collect([]),
            'completedSkills' => auth()->check() ? auth()->user()->skillCompletions()->pluck('completable_id') : collect([]),
        ]);
    }
}