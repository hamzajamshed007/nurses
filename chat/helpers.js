let MySqli = require('mysqli');

let conn = new MySqli({
    host: 'localhost',
    post: '3000',
    user: 'root',
    password: '',
    database: 'nurses' 
});