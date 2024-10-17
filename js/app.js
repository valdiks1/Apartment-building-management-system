const mysql = require('mysql');
//let submitAuth = document.querySelector('#submitAuth');

const conn = mysql.createConnection({
    host: "localhost",
    user: "root",
    database: "myhome",
    password: "Sync797!"
});

conn.connect(err => {
    if(err) {
        console.log(err);
        return err;
    }else{
        console.log("Database ------ OK")
    }
})

// function auth(event){
//     event.preventDefault();
//     let email = document.querySelector('#exampleInputEmail1').value;
//     let pass = document.querySelector('#exampleInputPassword1').value;
//     let user = {
//         "email": email,
//         "pass": pass
//     }
//     localStorage.setItem('authUser', JSON.stringify(user))
// }

// submitAuth.addEventListener('click', auth);