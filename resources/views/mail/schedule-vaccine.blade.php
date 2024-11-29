<x-mail::message>
# Mail Confirmation of Vaccine Schedule Date

Dear {{ $user->name }},

<x-mail::panel>
    This is to inform you that your vaccine date has been scheduled. Here's the overview:

    Date: {{ \Carbon\Carbon::parse($user->vaccination_date) }}

    Name: {{ $user->name }}

    Email: {{ $user->email }}

    Center: {{ $vaccine_center->name }}

    We hope that you will be present in the scheduled date on time.
</x-mail::panel>

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
