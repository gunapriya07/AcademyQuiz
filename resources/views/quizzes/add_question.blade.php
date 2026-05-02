<h2>Add Question to {{ $quiz->title }}</h2>

<form method="POST" action="{{ route('quizzes.questions.store', $quiz->id) }}">
    @csrf

    <label>Question:</label><br>
    <textarea name="body"></textarea><br><br>


    <label>Type:</label><br>
    <select name="type" onchange="handleTypeChange()">
        <option value="binary">Binary</option>
        <option value="single_choice">Single Choice</option>
        <option value="multiple_choice">Multiple Choice</option>
        <option value="number">Number</option>
        <option value="text">Text</option>
    </select><br><br>


    <label>Marks:</label><br>
    <input type="number" name="marks" value="1"><br><br>

    <div id="options-wrapper">
        <h3>Options</h3>
        <div id="options-container">
            <div>
                <input type="text" name="options[0][text]" placeholder="Option text">
                <input type="checkbox" name="options[0][is_correct]"> Correct
            </div>
            <div>
                <input type="text" name="options[1][text]" placeholder="Option text">
                <input type="checkbox" name="options[1][is_correct]"> Correct
            </div>
        </div>
        <button type="button" onclick="addOption()">Add More Options</button>
    </div>

    <br><br>

    <button type="submit">Save Question</button>
</form>

<script>
let optionIndex = 2;

function addOption() {
    let container = document.getElementById('options-container');
    let html = `
        <div>
            <input type="text" name="options[${optionIndex}][text]" placeholder="Option text">
            <input type="checkbox" name="options[${optionIndex}][is_correct]"> Correct
        </div>
    `;
    container.insertAdjacentHTML('beforeend', html);
    optionIndex++;
}

function handleTypeChange() {
    let type = document.querySelector('select[name="type"]').value;
    let wrapper = document.getElementById('options-wrapper');
    if (type === 'number' || type === 'text') {
        wrapper.style.display = 'none';
    } else {
        wrapper.style.display = 'block';
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    handleTypeChange();
});
</script>