<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Technology;
use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::orderby('updated_at', 'DESC')->get();

        return view('admin.projects.index',compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        $project = new Project();
        $types =Type::all();
        $technologies= Technology::all();
        $project_technologies=[];
        return view('admin.projects.create',compact('project', 'types','technologies', 'project_technologies'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data= $request->all();
        $request->validate([
        'title'=>'required|string|',
        'description'=>'required|string|',
        'thumb'=>'nullable|image|mimes:jpeg,jpg,png,svg',
        'type_id'=> 'nullable|exists:types,id',
        'technologies' => 'nullable|exists:technologies,id',
        
        ]);

        $project = new Project();
        
        $data['slug']=Str::slug($data['title'], '-');
 
        
        if(array_key_exists('thumb', $data)){
          $img_url =  Storage::put('projects',$data['thumb'] );
          $data['thumb']=$img_url;
        };


        $project->fill($data);

        $project->save();

        if(Arr::exists($data, 'technologies')) $project->technologies()->attach($data['technologies']);
    
        return to_route('admin.projects.show', $project->id);
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
       
        $project= Project::findorfail($id);
        $types =Type::all();
        $technologies= Technology::all();
        $project_technologies= $project->technologies->pluck('id')->toArray();

        return view('admin.projects.edit',compact('project', 'types','technologies', 'project_technologies'));
    }

    /** 
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $data= $request->all();
        $request->validate([
        'title'=>['required', 'string', Rule::unique('projects')->ignore($project->id)],
        'description'=>'|string|',
        'thumb'=>'nullable|image|mimes:jpeg,jpg,png,svg',
        'type_id'=> 'nullable|exists:types,id',
        'technologies' => 'nullable|exists:technologies,id'
        
        ]);

      
        
        $data['slug']=Str::slug($data['title'], '-');

        if(array_key_exists('thumb', $data)){
            if($project->thumb) Storage::delete($project->thumb);
            $img_url =  Storage::put('projects',$data['thumb'] );
            $data['thumb'] = $img_url;
          };

        $project->update($data);

        if(Arr::exists($data , 'technologies')) $project->technologies()->sync($data['technologies']);
        else  if(count($project->technologies))  $project->tecnologies()->detach();
        
        return to_route('admin.projects.show', $project->id)->with('type', 'success')->with('message','Progetto modificato con successo');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $project = Project::findOrFail($id);

        if($project->thumb)Storage::delete($project->thumb);
        
        if(count($project->technologies))  $project->tecnologies()->detach();
        
        $project->delete();
        return to_route('admin.projects.index')
            ->with('message', "Il progetto '$project->title' è stato eliminato con successo")
            ->with('type', 'success');
    }
}
