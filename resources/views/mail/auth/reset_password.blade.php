@component('mail::message')
# Obnova zapomenutého hesla

Dobrý den,

Tento email Vám byl zaslán, protože byla provedena žádost o obnovu zapomenutého hesla. Na změnu máte 1 hodinu, poté bude nutné žádost provést znovu.

@component('mail::button', ['url' => route('password.reset', $token, true)])
Obnovit heslo
@endcomponent

Pokud jste o změnu nežádali, tento email prosím ignorujte.

@slot('subcopy')
Pokud máte problém při kliknutí na tlačítko "Obnovit heslo", zkopírujte níže uvedený odkaz a vložte do adresního řádku vašeho prohlížeče.
[{{ route('password.reset', $token, true) }}]({{ route('password.reset', $token, true) }})
@endslot
@endcomponent
