<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> 

        <title>Chat App Socket.io</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
        <style>
            .chat-row{
                margin: 50px;
            }
            ul{
                margin: 0;
                padding: 0;
                list-style: none;
            }
            ul li{
                padding: 8px;
                background: #928787;
                margin-bottom: 20px;
                color: white;
            }
            ul li:nth-child(2n-2){
                background: #c3c5c5;
            }
            .chat-input {
                border: 1px solid lightgray;
                border-top-right-radius: 10px;
                border-top-left-radius: 10px;
                padding: 8px 10px;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <div class="row chat-row">
                <div class="chat-content">
                    <ul>
                        
                    </ul>
                </div>
                <div class="chat-section">
                    <div class="chat-box">
                        <div class="chat-input bg-white" id="chatInput" contenteditable="">

                        </div>
                        <button id='chat-input'>Submit</button>
                    </div>
                </div>
            </div>
        </div>


        <script src="https://code.jquery.com/jquery-3.6.1.js" integrity="sha256-3zlB5s2uwoUzrXK3BT7AX3FyvojsraNFxCc2vC/7pNI=" crossorigin="anonymous"></script>
        <script src="https://cdn.socket.io/4.5.3/socket.io.min.js" integrity="sha384-WPFUvHkB1aHA5TDSZi6xtDgkF0wXJcIIxXhC6h8OT8EH3fC5PWro5pWJ1THjcfEi" crossorigin="anonymous"></script>

        <script>
            $(function(){
                let ip_address = '127.0.0.1';
                let socket_port = '3000';
                // var socket = io.connect('https://69.167.129.16:3000');
                let socket = io(ip_address + ':' + socket_port);
                $('#chat-input').on('click', function(){
                    let message = {sender_id: 2, receiver_id: 4, msg:'asdfasdf', msg_type:'text'}
                    socket.emit('sendChatToServer',message);
                });
                // let chatInput = $('#chatInput');
                // chatInput.keypress(function(e){
                //     // let message = $(this).html();
                //     let message = {'id'=>2,'sender'=>4,'msg'=>'this'};
                //     socket.emit('sendChatToServer',message);
                //     // console.log(message);
                //     if(e.which === 13 && !e.shiftKey){
                //         chatInput.html('');
                //         return false;
                //     }
                // });
                socket.on('2_4', (message) => {
                    // console.log(message);
                    $('.chat-content ul').append(`<li>${message.msg}</li>`)
                });
            });
        </script>
    </body>
</html>
