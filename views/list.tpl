<ul>
  {foreach $books as $book}
    {include file="partials/book.tpl"  book=$book}
  {/foreach}
</ul>