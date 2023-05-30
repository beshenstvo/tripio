@component('mail::message')
# Заявка на экскурсию

<!-- resources/views/emails/feedback.blade.php -->

<p>Название экскурсии: {{ $exc_name }}</p>
<p>Имя клиента: {{ $name }}</p>
<p>Телефон: {{ $phone }}</p>
<p>Сообщение: {{ $message }}</p>


С наилучшими пожеланиями,<br>
{{ config('app.name') }}
@endcomponent