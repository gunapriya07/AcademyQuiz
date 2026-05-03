<h2>All Quizzes</h2>

<a href="{{ route('quizzes.create') }}">Create New Quiz</a>

<ul>
@foreach($quizzes as $quiz)
    <li>
        {{ $quiz->title }} - {{ $quiz->status }}
        <a href="{{ route('quizzes.questions.create', $quiz->id) }}">Add Questions</a>
        |
        <a href="{{ route('quizzes.attempt', $quiz->id) }}">Attempt Quiz</a>
    </li>
@endforeach
</ul>