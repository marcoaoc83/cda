@extends('portal.index.index')
@section('content')
    <style>
        :root {
            --color-accent: #2196f3;
        }

        main {
            background-color: #eeeeee;
            display: flex;
            flex-direction: column;
            height: 50vh;
            min-height: 50vh;
        }

        /* Wrapper for chat contents */
        main .conversation-wrapper {
            display: flex;
            flex: 1;
            flex-direction: column-reverse;
            padding: 0 10px 0 15px;
            overflow-y: scroll;
        }

        /* Scroll Design */
        main .conversation-wrapper::-webkit-scrollbar
        {
            width: 10px;
        }

        main .conversation-wrapper:hover::-webkit-scrollbar-thumb
        {
            background-color: var(--color-accent);
            border-radius: 10px;
        }

        /* Wrapper for all bubbles */
        main .conversation-content {
            align-content: flex-end;
            display: flex;
            flex-wrap: wrap;
        }

        /* Chat Bubbles */
        .bubble {
            border-color: #e0e0e0;
            border-radius: 1em;
            border-style: solid;
            border-width: 3px;
            margin-top: 2px;
            max-width: 75%;
            overflow-wrap: break-word;
            padding: 12px 16px;
            text-align: start;
            vertical-align: middle;
        }

        .chat {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
            width: 100%;
        }

        .chat-bot {
            align-items: flex-start;
        }

        .chat-user {
            align-items: flex-end;
        }

        .chat-bot .bubble {
            background-color: #fafafa;
        }

        .chat-user .bubble {
            background-color: #e0e0e0;
        }

        /* Input Field */
        main footer {
            align-items: stretch;
            display: flex;
            margin-bottom: 12px;
            padding: 0 12px;
            width: 100%;
        }

        main footer textarea {
            background-color: transparent;
            border-color: #e0e0e0;
            border-radius: 0.5em;
            border-style: solid;
            border-width: 3px;
            flex-grow: 1;
            margin-right: 10px;
        }

        main footer .btn {
            background-color: var(--color-accent);
            color: #fafafa;
        }

        .borderBottom {
            border-bottom-right-radius: .4em;
        }

        .borderTop {
            border-top-right-radius: .4em;
        }

    </style>
    <div class="pf-main">
        <div class="container pt-4 pb-4 pl-4 pr-4">
            <div class="h1 pf-text-secondary font-weight-light mb-3 pf-text-titulo">Chat</div>
            <p class="pf-text-muted mb-4">Envie suas perguntas, de modo que você possa esclarecer suas dúvidas:</p>
            <div id="chat">
                <main>
                    <div class="conversation-wrapper">
                        <div class="conversation-content" id="conversation">
                        </div>
                    </div>
                    <footer>
                        <p></p>
                        <textarea id="message" placeholder="Mensagem..." aria-label="Your message"></textarea>
                    </footer>
                </main>
            </div>
        </div>
    </div>
<!-- /page content -->
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/switchery/0.8.2/switchery.min.js"></script>
    <script>
        $('#message').keypress(function (e) {
            if (e.which == 13) {
                $('#conversation').append("<div class=\"chat chat-user\"><div class=\"bubble\">"+ $('#message').val()+"</div></div>");

                $.ajax({
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        msg: $('#message').val(),
                    },
                    url: '{{ url('chatMsg') }}' ,
                    success: function( msg ) {
                        $('#conversation').append("<div class=\"chat chat-bot\"><div class=\"bubble\">"+msg+"</div></div>");
                        console.log(data);
                        $('#message').val('').blur();
                    },
                    error: function( data ) {
                        console.log(data);
                    }
                });
                $('#message').val('').blur();
            }
        });
    </script>
@endpush