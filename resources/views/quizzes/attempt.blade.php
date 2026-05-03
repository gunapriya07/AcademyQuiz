<h2>{{ $quiz->title }}</h2>

<form method="POST" action="{{ route('quizzes.submit', $quiz->id) }}">
    @csrf


    @foreach($quiz->questions as $question)
        <div style="margin-bottom:20px;">
            <p><strong>{{ $loop->iteration }}. {{ $question->body }}</strong></p>

            @if(in_array($question->type, ['binary', 'single_choice']))
                @foreach($question->options as $option)
                    <label>
                        <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option->id }}">
                        {{ $option->text }}
                    </label><br>
                @endforeach
            @elseif($question->type == 'multiple_choice')
                @foreach($question->options as $option)
                    <label>
                        <input type="checkbox" name="answers[{{ $question->id }}][]" value="{{ $option->id }}">
                        {{ $option->text }}
                    </label><br>
                @endforeach
            @elseif($question->type == 'number')
                <label>Enter number:</label><br>
                <input type="number" name="answers[{{ $question->id }}]">
            @elseif($question->type == 'text')
                <label>Enter answer:</label><br>
                <input type="text" name="answers[{{ $question->id }}]">
            @endif
        </div>
    @endforeach

    <button type="submit">Submit Quiz</button>
</form>
