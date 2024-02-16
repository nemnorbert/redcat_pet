const http = require('http');
const app = require('./app');
const port = process.env.port || 7000;
const server = http.createServer(app);

// Start Server
server.listen(port, () => console.log(`Server is on listening on port ${port}`));