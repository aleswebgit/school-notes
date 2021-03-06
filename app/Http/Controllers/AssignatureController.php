<?php

namespace App\Http\Controllers;

use App\Models\Assignature;
use App\Models\Student;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class AssignatureController extends Controller {
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index() {
    $user = User::find(Auth::user()->id);
    
    $isAdmin = $user->isAdmin();
    $isProfessor = $user->isProfessor();
    $isTutor = $user->isTutor();
    $isStudent = $user->isStudent();

    if($isAdmin) {
      $assignatures = Assignature::with('user')->get();
    }
    if($isProfessor) {
      $assignatures = Assignature::where('user_id', Auth::user()->id)->with('user')->get();
    }
    if($isTutor) {
      $assignatures = Assignature::where('user_id', Auth::user()->id)->with('user')->get();
    }
    if($isStudent) {
      $student = Student::where('user_id', Auth::user()->id)->first();
      $studentCourse = $student->course;
      $assignatures = Assignature::where('course', $studentCourse)->with('user')->get();
    }
    return Inertia::render('Assignatures/Index', [
      'assignatures' => $assignatures,
      'isAdmin' => $isAdmin,
      'isProfessor' => $isProfessor,
      'isTutor' => $isTutor,
      'isStudent' => $isStudent,
    ]);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return Inertia::render('Assignatures/Create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    $request->validate([
      'name' => 'required',
      'description' => 'required',
      'course' => 'required',
      'year' => 'required',
      'user_id' => 'required',
    ]);

    $assignature = Assignature::create($request->all());
    $assignature->save();

    return redirect()->route('assignatures.index');
  }

  /**
   * Display the specified resource.
   *
   * @param  \App\Models\Assignature  $assignature
   * @return \Illuminate\Http\Response
   */
  public function show(Assignature $assignature) {
    return Inertia::render('Assignatures/Show', $assignature);
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  \App\Models\Assignature  $assignature
   * @return \Illuminate\Http\Response
   */
  public function edit(Assignature $assignature) {
    $professors = User::where('is_professor', true)->get();

    return Inertia::render('Assignatures/Edit', [
      'assignature' => $assignature,
      'professors' => $professors,
    ]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \App\Models\Assignature  $assignature
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, Assignature $assignature) {
    $request->validate([
      'name' => 'required',
      'description' => 'required',
      'course' => 'required',
      'year' => '',
      'user_id' => '',
    ]);

    $assignature->update($request->all());

    return Redirect::route('assignatures.index');
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  \App\Models\Assignature  $assignature
   * @return \Illuminate\Http\Response
   */
  public function destroy(Assignature $assignature) {
    Assignature::destroy($assignature->id);
    return redirect()->route('assignatures.index');
  }
}
