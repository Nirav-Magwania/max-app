
@component('mail::message')
<h2>Hello {{$body['name']}},</h2>
<p>This is the mail from Team ServerAvatar for you successfull completeion of regestration @component('mail::button', ['url' => $body['url_a']])
ServerAvatar
@endcomponent</p>
 
<p>Featured Project by interns @component('mail::button', ['url' => $body['url_b']])
GamexPOT
@endcomponent and learn more about Server Avatar.</p>
 
 
good night!<br>
 
Thanks,<br>
<x-mail::panel>
you can contact us at any time

{{ config('app.name') }}<br>
ServerAvatar support Team.
</x-mail::panel>

@endcomponent

@component('mail::footer')

@slot('footer')
    @component('mail::footer')
        © {{ date('dd-Y') }} {{ config('app.name') }}. @lang('all rights reserved.      welcome to china')
    @endcomponent
@endslot
@endcomponent