<h2>Quiz Result</h2>

<p><strong>Total Score: {{ $attempt->total_score }}</strong></p>

<hr>

@foreach($attempt->answers as $answer)
    <div style="margin-bottom:20px;">
        <p><strong>{{ $answer->question->body }}</strong></p>


        @php
            $given = json_decode($answer->given_answer, true);
        @endphp

        <p>Your Answer:
        @if(is_null($given))
            Not Answered
        @elseif(is_array($given))
            {{-- Multiple choice: show option texts --}}
            @php
                $texts = collect($given)->map(function($id) use ($answer) {
                    $opt = $answer->question->options->where('id', $id)->first();
                    return $opt->text ?? $id;
                })->toArray();
            @endphp
            {{ implode(', ', $texts) }}
        @else
            @php
                $option = $answer->question->options->where('id', $given)->first();
            @endphp
            {{ $option->text ?? $given }}
        @endif
        </p>

        <p>
            @if($answer->is_correct)
                <span style="color:green;">Correct</span>
            @else
                <span style="color:red;">Wrong</span>
            @endif
        </p>

        <p>Marks Awarded: {{ $answer->marks_awarded }}</p>
    </div>
@endforeach
