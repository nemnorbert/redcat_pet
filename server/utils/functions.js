function errorHandler (status, message, next) {
    const error = new Error(message);
    error.status = status || 500;
    console.log(error);
    next(error);
}

function getJSON(path) {
    const fs = require('fs');
    return new Promise((resolve, reject) => {
        fs.readFile(path, 'utf8', (err, data) => {
            if (err) {
                reject(err);
                return;
            }
            resolve(JSON.parse(data));
        });
    });
}

module.exports = { errorHandler, getJSON };