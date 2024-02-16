const express = require('express');
const app = express();
const { errorHandler } = require('./server/utils/functions')

const profileRoute = require('./server/routes/profile');
app.use('/', profileRoute);

// Handle 404 - Not Found
app.use((req, res, next) => {
    errorHandler(404, 'API Not found', next)
});

// Error handling middleware
app.use(async (error, req, res, next) => {
    res.status(error.status || 500);
    await res.json({
        success: false,
        status: error.status,
        message: error.message,
    });
});

module.exports = app;