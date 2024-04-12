@component('mail::message')
    Hello **{{$member->user->name}}**,
    you have been assigned the designation of **{{$member->designation}}**.
@endcomponent
