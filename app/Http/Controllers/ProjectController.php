<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\projects;
use Yajra\DataTables\DataTables;
use App\Http\Requests\ProjectRequest;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

          if(request()->ajax())
        {

          $query = projects::query();

          return DataTables::of($query)


            ->addColumn('action', function($item){
                return '
                <div class="flex justify-center">

                   <a href="'. route('project.edit', $item->id) .'" class="bg-gray-500 text-white rounded-md px-2 py-1 mr-2">
                    <i class="fa fa-pencil" aria-hidden="true"></i> Edit
                    </a>
                    <form class="inline-block" action="'. route('project.destroy', $item->id) .'" method="POST">
                        <button class="bg-red-500 text-white rounded-md px-2 py-1 mr-2">
                        <i class="fa fa-trash" aria-hidden="true"></i> Hapus
                        </button>
                    '. method_field('delete'). csrf_field() .'
                    </form>

                </div>



                ';
            })


            ->rawColumns(['action'])




            ->make();
        }

        return view('pages.project.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.project.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProjectRequest $request)
    {
        $data = $request->all();

        projects::create($data);

        toast('Success Create Data','success');
        return redirect()->route('project.index');


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(projects $project)
    {
        return view('pages.project.edit', compact('project'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProjectRequest $request, projects $project)
    {
        $data = $request->all();

        $project->update($data);

        toast('Success Update Data','success');
        return redirect()->route('project.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(projects $project)
    {
        $project->delete();

        toast('Success Delete Data');
        return redirect()->route('project.index');

    }

}

