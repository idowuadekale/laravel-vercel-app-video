@extends('layouts.default')
@section('title', 'Page Not Found - Lasu C&S Chapter')
@section("style")
<style>
* {
  -webkit-box-sizing: border-box;
          box-sizing: border-box;
}

body {
  padding: 0;
  margin: 0;
}

</style>
@endsection
@section('content')

<div id="notfound">	
    <div class="notfound">
			<div class="notfound-404">
				<h1>Oops!</h1>
			</div>
			<h2>404 - Page not found</h2>
			<p>The page you are looking for might have been removed had its name changed or is temporarily unavailable.</p>
			<a href="{{ url('/') }}">Go To Homepage</a>		
    </div>	
</div>

@endsection
@section("script")
<script>
</script>
@endsection
