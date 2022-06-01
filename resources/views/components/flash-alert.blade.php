@if(session()->has('prompt'))
  @if(session()->get('prompt')['status'] == 'ok')
    <div class="alert alert-success">{{ session()->get('prompt')['message'] }}</div>
  @elseif(session()->get('prompt')['status'] == 'error')
    <div class="alert alert-danger text-white">{{ session()->get('prompt')['message'] }}</div>
  @else
    <div class="alert alert-info text-white">{{ session()->get('prompt')['message'] }}</div>
  @endif
@endif
