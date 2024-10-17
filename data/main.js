// const mysql = require('mysql');

// const conn = mysql.createConnection({
//     host: "localhost",
//     user: "root",
//     database: "myhome",
//     password: "Sync797!"
// });

// //let a = JSON.parse(localStorage.getItem('authUser'));
// console.log(localStorage.getItem('authUser'));

// conn.connect(err => {
//     if(err) {
//         console.log(err);
//         return err;
//     }else{
//         console.log("Database ------ OK")
//     }
// })

// let query = "SELECT * FROM users WHERE email=" + a.email;
// conn.query(query, (err,result,field) => {
//     console.log(err);
//     console.log(result);
// })