<form
  hx-put="/books/{$book.id}"
  hx-target="closest li"
  hx-swap="outerHTML"
>
  <div class="form-group">
    <label for="title">Title: </label>
    <input type="text" name="title" id="title" value="{$book.title ?? ''}" required>
  </div>
  <div class="form-group">
    <label for="author">Author: </label>
    <input type="text" name="author" id="author" value="{$book.author ?? ''}" required>
  </div>
  <button type="submit">Confirm</button>
</form>