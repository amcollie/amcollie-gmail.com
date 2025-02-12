{extends file="layouts/main.tpl"}

{block name=title}{$title}{/block}

{block name=body}
  <header>
    <h1>My Reading List</h1>
  </header>

  <main>

    {include file="partials/search.tpl"}

    <div class="book-list">
      <button hx-get="/books" hx-target=".book-list">Show Books</button>
    </div>

    <div class="add-book-form">
      <h2>What do you want to read?</h2>
      <form hx-on::after-request="document.querySelector('form').reset()"
        hx-on:click="console.log('new book added', event)" hx-post="/books" hx-target="main .book-list ul"
        hx-swap="beforeend">
        <div class="form-group">
          <label for="title">Title: </label>
          <input type="text" name="title" id="title" required>
        </div>
        <div class="form-group">
          <label for="author">Author: </label>
          <input type="text" name="author" id="author" required>
        </div>
        <button type="submit">Add Book</button>
      </form>
    </div>
  </main>
{/block}