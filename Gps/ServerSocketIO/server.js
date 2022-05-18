var app = require("express")();
var https = require("https");
var fs = require("fs");
var options = {
    key: fs.readFileSync(
        "/etc/letsencrypt/live/corporacionminkay.com/privkey.pem"
    ),
    ca: fs.readFileSync(
        "/etc/letsencrypt/live/corporacionminkay.com/fullchain.pem"
    ),
    cert: fs.readFileSync(
        "/etc/letsencrypt/live/corporacionminkay.com/cert.pem"
    ),
    requestCert: false,
    rejectUnauthorized: false,
};
var httpServer = https.createServer(options, app);
const Server = require("socket.io");
const io = new Server(httpServer, {});
io.on("connection", (socket) => {
    socket.on("newUbication", (data) => {
        data.users.forEach((value, index, array) => {
            io.emit("newUbication" + value.id, JSON.parse(data.data));
        });
    });
});
httpServer.listen(3000);
console.log("Listen socket io 3000");
