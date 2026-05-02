<h2>Create Quiz</h2>

<form method="POST" action="{{ route('quizzes.store') }}">
    @csrf

    <label>Title:</label><br>
    <input type="text" name="title"><br><br>

    <label>Description:</label><br>
    <textarea name="description"></textarea><br><br>

    <label>Status:</label><br>
    <select name="status">
        <option value="draft">Draft</option>
        <option value="published">Published</option>
    </select><br><br>

    <button type="submit">Create Quiz</button>
</form>