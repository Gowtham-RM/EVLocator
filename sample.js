const http = require("http"); // Import the HTTP module

var server = http.createServer(function (request, response) {
    if (request.url == "/") {
        response.writeHead(200, { "Content-Type": "text/html" });
        response.end(`<html><body> 
            <h1>Hello World</h1>
            This is home Page! URL was: ${request.url} 
            <br> 
            <a href="/student">Click me to go to Student Page</a> 
        </body></html>`);
    } 
    else if (request.url == "/student") {
        response.writeHead(200, { "Content-Type": "text/html" });
        response.end(`<html><body> 
            <h1>Hello World student</h1>
            This is Student Page! URL was: ${request.url} 
        </body></html>`);
    } 
    else if (request.url == "/admin") {
        response.writeHead(200, { "Content-Type": "text/html" });
        response.end(`<html><body> 
            <h1>Hello World admin</h1>
            This is Admin Page! URL was: ${request.url} 
        </body></html>`);
    } 
    else {
        response.writeHead(404, { "Content-Type": "text/plain" }); // Proper status code for invalid requests
        response.end("Invalid Request");
    }
});

server.listen(3000, () => {
    console.log("Server running on http://localhost:3000");
});
