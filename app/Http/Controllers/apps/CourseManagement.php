<?php

namespace App\Http\Controllers\apps;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Section;
use App\Models\Lesson;
use App\Models\Quiz;
use App\Models\Data_Bangkom;
use App\Models\Question;
use App\Models\ExamQuestion;
use App\Models\Exam;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class CourseManagement extends Controller
{
    public function index()
    {
        $courses = Course::all();
        $diklat_options = Data_Bangkom::pluck('nama_diklat')->unique()->toArray();
        return view('content.apps.Course-Management', compact('courses', 'diklat_options'));
    }


    public function data()
    {
        $courses = Course::query();
        return DataTables::of($courses)
            ->addIndexColumn()
            ->editColumn('thumbnail', function($course) {
                // Use the new directory path for thumbnails
                return $course->thumbnail ? asset('asset/img/thumbnails/' . basename($course->thumbnail)) : null;
            })
            ->editColumn('title', function($course) {
                return '<a href="' . route('courses.detail', $course->id) . '">' . $course->title . '</a>';
            })
            ->addColumn('time_period', function($course) {
                return $course->start_date . ' to ' . $course->end_date;
            })
            ->addColumn('check_in_time', function($course) {
                return $course->check_in_start . ' - ' . $course->check_in_end;
            })
            ->addColumn('material', function($course) {
                // Use the new directory path for materials
                return $course->material ? asset('asset/materials/' . basename($course->material)) : null;
            })
            ->addColumn('nama_diklat', function($course) {
                return $course->nama_diklat;
            })
            ->rawColumns(['title'])
            ->make(true);
    }


    public function store(Request $request)
    {
        $request->validate([
            'nama_diklat' => 'required|string|exists:daftar_diklat,nama_diklat',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'material' => 'nullable|file|mimes:ppt,pptx|max:10240',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'check_in_start' => 'required|date_format:H:i',
            'check_in_end' => 'required|date_format:H:i|after:check_in_start',
        ]);

        $thumbnailPath = null;
        $materialPath = null;

        if ($request->hasFile('thumbnail')) {
            $thumbnailPath = $request->file('thumbnail')->move('asset/img/thumbnails', $request->file('thumbnail')->getClientOriginalName());
        }

        if ($request->hasFile('material')) {
            $materialPath = $request->file('material')->move('asset/materials', $request->file('material')->getClientOriginalName());
        }

        $course = Course::create([
            'nama_diklat' => $request->nama_diklat,
            'title' => $request->title,
            'description' => $request->description,
            'thumbnail' => $thumbnailPath,
            'material' => $materialPath,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'check_in_start' => $request->check_in_start,
            'check_in_end' => $request->check_in_end,
        ]);

        return response()->json([
            'success' => true,
            'course' => $course,
            'thumbnail_url' => asset($course->thumbnail),
            'material_url' => $course->material ? asset($course->material) : null,
        ]);
    }


    public function update(Request $request)
    {

        $course = Course::findOrFail($request->id);

        $course->nama_diklat = $request->nama_diklat;
        $course->title = $request->title;
        $course->description = $request->description;
        $course->start_date = $request->start_date;
        $course->end_date = $request->end_date;
        $course->check_in_start = $request->check_in_start;
        $course->check_in_end = $request->check_in_end;

        if ($request->hasFile('thumbnail')) {
            // Delete old thumbnail
            if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
                unlink(public_path($course->thumbnail));
            }
            $thumbnailPath = $request->file('thumbnail')->store('asset/img/thumbnails', 'public');
            $course->thumbnail = $thumbnailPath;
        }

        if ($request->hasFile('material')) {
            // Delete old material
            if ($course->material && file_exists(public_path($course->material))) {
                unlink(public_path($course->material));
            }
            $materialPath = $request->file('material')->store('asset/materials', 'public');
            $course->material = $materialPath;
        }

        $course->save();

        return response()->json(['success' => true]);
    }




    public function destroy($id)
    {
        $course = Course::findOrFail($id);
        if ($course->thumbnail && file_exists(public_path($course->thumbnail))) {
            unlink(public_path($course->thumbnail)); // Delete the thumbnail file
        }
        $course->delete();

        return response()->json(['success' => true]);
    }



    //untuk course detail
    public function detail($courseId)
    {
        $course = Course::with('sections.lessons', 'sections.quizzes')->findOrFail($courseId);

        return view('content.apps.management-detail', compact('course'));
    }


    public function storeSection(Request $request, $courseId)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'order' => 'required|integer',
        ]);

        $course = Course::findOrFail($courseId);
        $course->sections()->create($request->only('title', 'order'));

        return response()->json(['success' => true]);
    }

    public function deleteSection($sectionId)
    {
        $section = Section::findOrFail($sectionId);
        $section->delete();

        return response()->json(['success' => true]);
    }

    public function lesson($sectionId)
    {
        $section = Section::with('lessons')->findOrFail($sectionId);
        return view('content.apps.lesson-detail', compact('section','sectionId'));
    }

    public function storeLesson(Request $request, $sectionId)
{
    $validated = $request->validate([
        'order' => 'required|integer',
        'title' => 'required|string|max:255',
        'type' => 'required|in:video,pdf',
        'content_url' => 'nullable|string|url', // For video URL
        'content_file' => 'nullable|file|mimes:mp4,pdf|max:20480', // For file upload
        'duration' => 'required|integer|min:1',
    ]);

    if ($request->hasFile('content_file')) {
        // Save file directly to public/lessons directory
        $file = $request->file('content_file');
        $fileName = uniqid() . '_' . $file->getClientOriginalName(); // Unique file name
        $filePath = public_path('lessons'); // Path to public/lessons directory

        // Ensure the directory exists
        if (!file_exists($filePath)) {
            mkdir($filePath, 0755, true);
        }

        // Move file to the public directory
        $file->move($filePath, $fileName);

        // Set the public URL for the file
        $validated['content'] = '/dev/corpu2/simapeka/public/lessons/' . $fileName;
    } else {
        // Use the URL for content
        $validated['content'] = $validated['content_url'];
    }

    $validated['section_id'] = $sectionId;
    Lesson::create($validated);

    return response()->json(['success' => true]);
}



    public function updateLesson(Request $request, $sectionId, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);

        $validated = $request->validate([
            'order' => 'required|integer',
            'title' => 'required|string|max:255',
            'type' => 'required|in:video,pdf',
            'content_url' => 'nullable|string|url', // For video URL
            'content_file' => 'nullable|file|mimes:mp4,pdf|max:20480', // For file upload
            'duration' => 'required|integer|min:1',
        ]);

        if ($request->hasFile('content_file')) {
            // Remove old file if exists
            if ($lesson->type === 'video' || $lesson->type === 'pdf') {
                Storage::delete($lesson->content);
            }

            // Store new file and update 'content' field
            $filePath = $request->file('content_file')->store('lessons');
            $validated['content'] = $filePath;
        } else {
            // Update the URL for content if provided
            $validated['content'] = $validated['content_url'] ?? $lesson->content;
        }

        $lesson->update($validated);

        return response()->json(['success' => true]);
    }


    public function destroyLesson($sectionId, $lessonId)
    {
        $lesson = Lesson::where('section_id', $sectionId)->findOrFail($lessonId);

        // Remove file from storage if it exists
        if ($lesson->type === 'video' || $lesson->type === 'pdf') {
            Storage::delete($lesson->content);
        }

        $lesson->delete();

        return response()->json(['success' => true]);
    }



    public function showLesson($sectionId, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        return response()->json(['success' => true, 'lesson' => $lesson]);
    }


    //quiz
    public function quiz($sectionId)
    {
        $section = Section::with('quizzes')->findOrFail($sectionId);
        return view('content.apps.quiz', compact('section','sectionId'));
    }

    public function quizStore(Request $request)
    {
        $request->validate([
            'section_id' => 'required|exists:sections,id',
            'title' => 'required|string|max:255',
            'points' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        $quiz = Quiz::create($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Quiz added successfully!',
            'quiz' => $quiz,
        ]);
    }

    public function quizUpdate(Request $request, $id)
    {
        $quiz = Quiz::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'points' => 'required|integer|min:0',
            'duration' => 'required|integer|min:1',
            'status' => 'required|boolean',
        ]);

        $quiz->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Quiz updated successfully!',
            'quiz' => $quiz,
        ]);
    }

    public function quizShow($id)
    {
        $quiz = Quiz::findOrFail($id);

        return response()->json($quiz);
    }

    public function quizDestroy($id)
    {
        $quiz = Quiz::findOrFail($id);

        // Ensure related questions are deleted
        $quiz->questions()->delete();

        $quiz->delete();

        return response()->json([
            'success' => true,
            'message' => 'Quiz deleted successfully!',
        ]);
    }


    public function question($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        return view('content.apps.question', compact('quiz','quizId'));
    }


    public function questionStore(Request $request, $quizId)
{
    $validated = $request->validate([
        'question_text' => 'required|string|max:255',
        'type' => 'required|in:essay,multiple_choice',
        'options' => 'nullable|array', // Expecting an array for multiple choice
        'correct_answer' => 'nullable|string',
        'points' => 'required|numeric|min:1',
    ]);

    // Ensure the quiz exists
    if (!Quiz::find($quizId)) {
        return response()->json(['error' => 'Quiz not found.'], 404);
    }

    $validated['quiz_id'] = $quizId;

    // Handle options for multiple-choice questions
    if ($validated['type'] === 'multiple_choice') {
        if (empty($validated['options'])) {
            return response()->json(['error' => 'Options are required for multiple choice questions.'], 422);
        }

        // Ensure options are stored as a JSON array
        $validated['options'] = array_values($validated['options']); // Ensures keys are numeric
    } else {
        $validated['options'] = null; // No options for essay questions
    }

    // Create the question
    Question::create($validated);

    return response()->json(['success' => true, 'message' => 'Question saved successfully']);
}



    public function questionUpdate(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        $validated = $request->validate([
            'question_text' => 'required|string|max:255',
            'type' => 'required|in:essay,multiple_choice',
            'options' => 'nullable|array',
            'correct_answer' => 'nullable|string',
            'points' => 'required|numeric|min:1',
        ]);

        if ($validated['type'] === 'multiple_choice' && empty($validated['options'])) {
            return response()->json(['error' => 'Options are required for multiple choice questions.'], 422);
        }

        $validated['options'] = $validated['type'] === 'multiple_choice' ? json_encode($validated['options']) : null;

        $question->update($validated);

        return response()->json(['success' => true, 'message' => 'Question updated successfully.']);
    }

    public function questionDestroy($id)
    {
        $question = Question::findOrFail($id);
        $question->delete();

        return response()->json(['success' => true, 'message' => 'Question deleted successfully.']);
    }


    public function exams($courseId)
    {
        $course = Course::with('exams')->findOrFail($courseId);
        return view('content.apps.exam-management', compact('course', 'courseId'));
    }


    public function examStore(Request $request, $courseId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'duration' => 'required|integer|min:1',
            'max_attempts' => 'required|integer|min:1',
        ]);

        $exam = Exam::create([
            'course_id' => $courseId,
            'title' => $validated['title'],
            'passing_score' => $validated['passing_score'],
            'duration' => $validated['duration'],
            'max_attempts' => $validated['max_attempts'],
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Exam created successfully.',
            'exam' => $exam,
        ], 201);
    }

    public function examUpdate(Request $request, $courseId, $examId)
    {
        $exam = Exam::findOrFail($examId);

        // Validate the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:0|max:100',
            'duration' => 'required|integer|min:1',
            'max_attempts' => 'required|integer|min:1',
        ]);

        // Update the exam
        $exam->update($validatedData);

        return response()->json(['success' => true, 'message' => 'Exam updated successfully']);
    }


    public function examDestroy($examId)
    {
        $exam = Exam::findOrFail($examId);
        $exam->delete();

        return response()->json([
            'success' => true,
            'message' => 'Exam deleted successfully.',
        ]);
    }


    //untuk pertanyaan exam

    public function examQuestion($examId)
{
    // Fetch all questions for the specific exam
    $exam = Exam::with('questions')->findOrFail($examId);

    // Pass data to the view
    return view('content.apps.exam-questions', [
        'examId' => $examId, // Include the exam ID for reference
        'exam' => $exam, // Pass the list of questions
    ]);
}

public function getExamQuestions($examId)
{
    $exam = Exam::with('questions')->findOrFail($examId);
    return response()->json($exam->questions); // Return only the questions in JSON format
}

public function examQuestionStore(Request $request, $examId)
{
    $validated = $request->validate([
        'exam_id' => 'required|integer|exists:exams,id',
        'question_text' => 'required|string',
        'type' => 'required|in:multiple_choice,essay',
        'options' => 'required_if:type,multiple_choice|array',
        'correct_answer' => 'nullable|string',
        'points' => 'required|integer',
    ]);

    // Ensure the exam exists
    $exam = Exam::find($examId);
    if (!$exam) {
        return response()->json(['error' => 'Exam not found.'], 404);
    }

    // Prepare the question data
    $validated['exam_id'] = $examId;

    if ($validated['type'] === 'multiple_choice') {
        // Ensure options are stored as a JSON array
        $validated['options'] = array_values($validated['options']); // Ensures keys are numeric
    } else {
        $validated['options'] = null; // No options for essay questions
    }

    // Create the question
    $question = ExamQuestion::create($validated);

    return response()->json(['success' => true, 'message' => 'Question added successfully', 'question' => $question], 200);
}

public function examQuestionUpdate(Request $request, ExamQuestion $examQuestion)
{
    $validated = $request->validate([
        'question_text' => 'required|string',
        'type' => 'required|in:multiple_choice,essay',
        'options' => 'nullable|array',
        'correct_answer' => 'nullable|string',
        'points' => 'required|integer',
    ]);

    // Update the question
    if ($validated['type'] === 'multiple_choice' && isset($validated['options'])) {
        $validated['options'] = array_values($validated['options']); // Ensures keys are numeric
    } else {
        $validated['options'] = null; // No options for essay questions
    }

    $examQuestion->update($validated);

    return response()->json(['success' => true, 'message' => 'Question updated successfully', 'question' => $examQuestion], 200);
}

public function examQuestionDestroy($id)
{
    $question = ExamQuestion::findOrFail($id);

    // Optional: Verify if the question belongs to the specific exam
    // if ($question->exam_id !== $expectedExamId) {
    //     return response()->json(['error' => 'Unauthorized action'], 403);
    // }

    $question->delete();

    return response()->json(['message' => 'Question deleted successfully'], 200);
}



}
