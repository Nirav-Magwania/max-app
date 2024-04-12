@component('mail::message')
    Hello **{{$member->email}}**,
   ## you have been assigned the designation of **{{$member->designation}}**.
    your invitation token is **{{$member->invitation_token}}**.
    wishing you all the best for your new role 

        @component('mail::button', ['url' => url("/api/register?invitation_token=$member->invitation_token") ])
            Accept
        @endcomponent
@endcomponent