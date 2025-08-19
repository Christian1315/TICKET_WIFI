<x-mail::message>
<h1 class="">{{$subject}}</h1> 
<br>
<h4 class="">Nom & Prénom: {{$name}} </h4>
<h4 class="">Email: {{$email}} </h4>
<h4 class="">Password: {{$password}} </h4>
<h4 class="">Message :</h4>
<p class="">{{$message}}</p>

<x-mail::button :url="env('APP_URL')">
Aller sur la plateforme
</x-mail::button>

Merci <br>
Coordialement,<br>
{{ str_replace("_","-",config('app.name')) }}
</x-mail::message>
