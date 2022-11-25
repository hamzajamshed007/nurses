
const express = require('express');
// var fs = require('fs');
const app = express();
var cors = require('cors');
var mysql = require("mysql");
// const options = {
//     key: fs.readFileSync('/home2/apimyprojectstag/ssl/keys/cfe00_34d0d_ea2b18a58aa4d8e0ce6d100a35e9f945.key'),
//     cert: fs.readFileSync('/home2/apimyprojectstag/ssl/certs/api_myprojectstaging_com_cfe00_34d0d_1697224120_839a63f8a20e320bbec561a3bdbbcc9f.crt'),
// };

// const server = require('https').createServer(options, app);
const server = require('http').createServer(app);

app.use(express.json());
app.use(cors());


const io = require('socket.io')(server, {
    cors: { 
        origin: "*",
        methods: ["GET", "POST","PATCH","DELETE"],
        credentials: false,
        transports: ['websocket', 'polling'],
        allowEIO3: true,
    }
});
// FOR MY SQL
var con_mysql = mysql.createPool({
    host              :   'localhost',
    database          :   'nurses',
    user              :   'root',
    password          :   '',
    debug             :   false
});

io.on('connection', (socket) => {
    // console.log(socket);
    console.log('connection');
    socket.on('sendChatToServer', (message)=> {
        console.log(message.id);
        
        // SQLLL
        con_mysql.getConnection(function(error,connection){
            if(error){
                console.log(error);
            }else{
                console.log('test');
                if(message.conv_id){
                    var conv = message.conv_id;
                }else{
                    var conv = `${message.sender_id}_${message.receiver_id}`;
                    console.log(conv);
                }
                var sql = 'INSERT INTO messages(sender_id, receiver_id, conversation_id, message, message_type) VALUES ('+ message.sender_id + ', ' + message.receiver_id + ',"' +conv+ '","' +message.msg+ '","' +message.msg_type+ '")';
                connection.query(sql, function(error,data){
                    connection.release();
                    if(error){
                        console.log(error);
                    }else{
                        console.log(`${message.sender_id}_${message.receiver_id}`);
                    if(message.sender_id < message.receiver_id){
                        socket.emit(`${message.sender_id}_${message.receiver_id}`, message);
                    }else{
                        socket.emit(`${message.receiver_id}_${message.sender_id}`, message);
                    }
                    //    socket.emit(`'${message.id}_${message.sender}'`, message);
                    }
                });
            }
        });
        // socket.broadcast.emit('sendChatToClient', message);
    });

    // socket.emit();

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

io.on("connect_error", (err) => {
  console.log(`connect_error due to ${err.message}`);
});

server.listen(3000, () =>{
    console.log('Server is running');
});


// database.table('messages').getAll()
// .then(messages => {
//     data = messages;
//     io.sockets.emit('sendChatToClient',message)
// }).catch(err => console.log(err));


// FOR LIVE WEBSITE



const express = require('express');
var fs = require('fs');
const app = express();
var cors = require('cors');
var mysql = require("mysql");
const options = {
    key: fs.readFileSync('/home2/apimyprojectstag/ssl/keys/cfe00_34d0d_ea2b18a58aa4d8e0ce6d100a35e9f945.key'),
    cert: fs.readFileSync('/home2/apimyprojectstag/ssl/certs/api_myprojectstaging_com_cfe00_34d0d_1697224120_839a63f8a20e320bbec561a3bdbbcc9f.crt'),
};

const server = require('https').createServer(options, app);
// const server = require('http').createServer(app);

app.use(express.json());
app.use(cors());


const io = require('socket.io')(server, {
    cors: { 
        origin: "*",
        methods: ["GET", "POST","PATCH","DELETE"],
        credentials: false,
        transports: ['websocket', 'polling'],
        allowEIO3: true,
    }
});
// FOR MY SQL
var con_mysql = mysql.createPool({
    host              :   'localhost',
    database          :   'nurses',
    user              :   'nurses',
    password          :   'RSCp7Xb%4Tlf',
    debug             :   false
});

io.on('connection', (socket) => {
    // console.log(socket);
    console.log('connection');
    socket.on('sendChatToServer', (message)=> {
        
        // SQLLL
        con_mysql.getConnection(function(error,connection){
            if(error){
                console.log(error);
            }else{
                // console.log('test');
                if(message.conv_id){
                    var conv = message.conv_id;
                }else{
                    var conv = `${message.sender_id}_${message.receiver_id}`;
                    // console.log(conv);
                }
                var sql = 'INSERT INTO messages(sender_id, receiver_id, conversation_id, message, message_type) VALUES ('+ message.sender_id + ', ' + message.receiver_id + ',"' +conv+ '","' +message.msg+ '","' +message.msg_type+ '")';
                connection.query(sql, function(error,data){
                    connection.release();
                    if(error){
                        console.log(error);
                    }else{
                        // console.log(`${message.sender_id}_${message.receiver_id}`);
                    if(message.sender_id < message.receiver_id){
                        console.log('successfull')
                        socket.broadcast.emit(`${message.sender_id}_${message.receiver_id}`, message);
                        socket.emit(`${message.sender_id}_${message.receiver_id}`, message);
                    }else{
                        console.log('successfull')
                        socket.broadcast.emit(`${message.receiver_id}_${message.sender_id}`, message);
                        socket.emit(`${message.receiver_id}_${message.sender_id}`, message);
                        // socket.emit('message', data)  // sends to the sender
                    }
                    //    socket.emit(`'${message.id}_${message.sender}'`, message);
                    }
                });
                
                // if(message.receiver_id){
                //     socket.emit(`${message.receiver_id}_${message.sender_id}`, message);
                //     socket.broadcast.emit(`${message.receiver_id}_${message.sender_id}`, message);
                //     console.log('successful');
                //     console.log(message);
                //     // socket.emit(`'${message.receiver_id}_${message.sender_id}'`, message);
                // }
            }
        });
        // socket.broadcast.emit('sendChatToClient', message);
    });

    // socket.emit();

    socket.on('disconnect', (socket) => {
        console.log('Disconnect');
    });
});

io.on("connect_error", (err) => {
  console.log(`connect_error due to ${err.message}`);
});

server.listen(3000, () =>{
    console.log('Server is running');
});


// database.table('messages').getAll()
// .then(messages => {
//     data = messages;
//     io.sockets.emit('sendChatToClient',message)
// }).catch(err => console.log(err));


