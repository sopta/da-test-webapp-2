<table border="0" cellpadding="0" cellspacing="0" width="100%" class="doubleColumnsTable">
<tr>
<td align="center" valign="middle" width="20%" class="doubleColumnsContainer">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0">
<tr>
<td align="center">
<img src="{{ asset('/img/feedback-levels/'.Str::slug($groupName).'.png') }}" alt="{{ $groupName }}" width="80" height="80">
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
<td align="left" valign="middle" width="80%" class="doubleColumnsContainer">
<table border="0" cellpadding="10" cellspacing="0" width="100%">
<tr>
<td>
<table width="100%" cellpadding="0" cellspacing="0" class="feedback-table">
<tr>
<td>
{{ Illuminate\Mail\Markdown::parse($slot) }}
{{-- code cannot be intended - it means for Markdown to make <code> --}}
</td>
</tr>
</table>
</td>
</tr>
</table>
</td>
</tr>
</table>

---
