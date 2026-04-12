<h3>
    {{ config('app.name', 'Lasu C&S') }},
    You just received a new response from contactPage from website: "{{ config('app.url', url('/')) }}".
</h3>

<p><strong>Name:</strong> {{ $data['name'] }}</p>
<p><strong>Email:</strong> {{ $data['email'] }}</p>
<p><strong>Subject:</strong> {{ $data['subject'] }}</p>

<p><strong>Message:</strong></p>
<p>{{ $data['message'] }}</p>
