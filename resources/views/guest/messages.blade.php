@extends('layouts.guest')

@section('resources')
  <style>
    .message-box {
      display: flex;
      flex-direction: row;
      height: 500px;
      width: 100%;
    }

    .message-box .message-contacts {
      border-right: 1px solid rgba(0, 0, 0, 0.125);
      overflow: auto;
      width: 15rem;
      max-width: 100%;
    }

    .message-box .message-space {
      display: flex;
      flex-direction: column;
      flex: 1;
      overflow: auto;
      padding: 1rem;
    }

    .message-box .message-space .messaging-section {
      flex: 1;
      overflow: auto;
    }

    .messaging-block {
      display: flex;
      flex-direction: row;
      margin-bottom: 0.25rem;
    }

    .messaging-block.others {
      justify-content: flex-start;
    }

    .messaging-block.you {
      justify-content: flex-end;
    }

    .messaging-block-content {
      border-radius: 0.5rem;
      padding: 0.5rem 0.75rem;
      max-width: 40%;
    }

    .messaging-block.others .messaging-block-content {
      background-color: #8edff3;
    }

    .messaging-block.you .messaging-block-content {
      background-color: #8ef3c5;
    }

    #main-section {
      min-height: 85vh;
    }
  </style>
@endsection

@section('content')
  <div id="main-section">
    <div class="container py-5">
      <div class="card">
        <div class="card-body p-0">
          <div class="message-box">
            <div class="message-contacts">
              <div class="list-group list-group-flush mb-4">
                @if($recepient->count() > 0)
                  @foreach($recepient as $recepient)
                    <a href="#" class="message-list-item list-group-item" data-id="{{ base64_encode($recepient->id) }}">
                      @if($recepient->recepient_type == 'seller')
                        <h5 class="m-0">{{ $recepient->store_name != null && $recepient->store_name != '' ? $recepient->store_name : $seller->full_name }}</h5>
                      @else
                        <h5 class="m-0">{{ $recepient->store_name != null && $recepient->store_name != '' ? $recepient->store_name : $seller->full_name }}</h5>
                      @endif
                    </a>
                  @endforeach
                @else
                  <div class="list-group-item text-center">
                    <em class="text-muted">Empty contact list</em>
                  </div>
                @endif
              </div>
            </div>
            <div class="message-space">
              <div class="messaging-header"></div>
              <div class="messaging-section">
                <div class="d-flex align-items-center justify-content-center h-100 w-100">
                  <div class="text-center">
                    <em class="text-muted">Select a recepient...</em>
                  </div>
                </div>
              </div>
              <div class="form-group mt-4 mb-0">
                <textarea id="messaging-field" rows="1" class="form-control no-resize" disabled></textarea>
                <div class="text-right">
                  <small class="form-text text-muted">Press <kbd>Enter</kbd> to send.</small>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection

@section('scripts')
    <script>
      var sent_to = null;
      var is_at_bottom = false;
      var is_loading = false;

      function loadMessages(callback = null) {
        if(sent_to == null) {
          $('.messaging-section').html(`<div class="d-flex align-items-center justify-content-center h-100 w-100">
              <div class="text-center">
                <em class="text-muted">Select a recepient...</em>
              </div>
            </div>`);

          return false;
        }

        is_loading = true;

        $.ajax({
          url: "{{ route('api.fetch.messages') }}",
          method: 'POST',
          data: {
            sent_by: '{{ base64_encode(Auth::user()->id) }}',
            sent_to: sent_to
          },
          dataType: 'json',
          success: function(response) {
            is_loading = false;
            should_scroll = is_at_bottom;

            if(response.status == 'ok') {
              $('.messaging-header').html(`<h4 class="m-0">${response.data.user.store_name != null && response.data.user.store_name != '' ? response.data.user.store_name : response.data.user.full_name}</h4><hr>`);
              $('.messaging-section').html('');
              $('#messaging-field').attr('disabled', false);

              if(response.data.messages.length > 0) {
                response.data.messages.forEach(function(item) {
                  $('.messaging-section').append(`<div class="messaging-block ${parseInt(item.sent_by) != parseInt('{{ Auth::user()->id }}') ? 'others' : 'you'}">
                      <div class="messaging-block-content">${item.message}</div>
                    </div>`);
                });
              }

              if(should_scroll) {
                $('.messaging-section').scrollTop(99999);
              }

              if(callback != null) {
                callback();
              }
            }
          }
        });
      }

      $(function() {
        setInterval(function() {
          if(!is_loading) {
            loadMessages();
          }
        }, 1000);

        $('.messaging-section').on('scroll', function() {
          is_at_bottom = Math.round($('.messaging-section').scrollTop() + $('.messaging-section')[0].clientHeight) >= $('.messaging-section')[0].scrollHeight;
        });

        $('body').on('click', '.message-list-item', function() {
          sent_to = $(this).attr('data-id');

          setTimeout(function() {
            loadMessages(function() {
              $('.messaging-section').scrollTop(99999);
            });
          }, 100);

          return false;
        });


        $('body').on('keypress', '#messaging-field', function(e) {
          if(e.keyCode == 13 && !e.shiftKey) {
            e.preventDefault();

            var thisField = $(this);

            $.ajax({
              url: "{{ route('api.send.message') }}",
              method: 'POST',
              data: {
                sent_by: '{{ base64_encode(Auth::user()->id) }}',
                sent_to: sent_to,
                message: thisField.val()
              },
              dataType: 'json',
              success: function(response) {
                if(response.status == 'ok') {
                  thisField.val('').focus();

                  setTimeout(function() {
                    $('.messaging-section').scrollTop(99999);
                  }, 100);
                }
              }
            });
          }
        });
      });
    </script>
@endsection
