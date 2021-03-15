{!! strip_tags(removeMarkdown($header)) !!}

{!! strip_tags(removeMarkdown($slot)) !!}

S pozdravem
Czechitas | Na problémy a dotazy je tu Slack
@isset($subcopy)

{{ removeMarkdown("---") }}
{!! strip_tags(removeMarkdown($subcopy)) !!}
@endisset

{!! strip_tags(removeMarkdown($footer)) !!}
