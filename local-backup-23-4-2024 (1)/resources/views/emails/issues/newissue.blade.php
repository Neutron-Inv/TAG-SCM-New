@component('mail::message')
# Feedback System

<b>Submitted By</b>: {{ $issue->sender_name }}<br><br>
<b>Sender Email</b>: {{ $issue->sender_email }}<br><br>
<b>Issue/Task Category</b>: {{ $issue->category }}<br><br>
<b>Priority</b>: {{ $issue->priority }}<br><br>
<b>Assigned To</b>: {{$issue->assigned->first_name}} {{$issue->assigned->last_name}} ({{$issue->assigned->email}})<br><br>
<b>Issue/Task Completion Date</b>: {{ \Carbon\Carbon::parse($issue->completion_time)->format('jS M, Y') ?? 'N/A'}}<br><br>
<b>Issue/Task</b>: {{ $issue->message }}<br>

Regards,<br>
{{ config('app.name') }}
@endcomponent
