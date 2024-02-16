const express = require('express');
const router = express();
const axios = require('axios');
const { errorHandler } = require('../utils/functions');
const path = require('path');

router.use(express.static('public'));
router.set('view engine', 'ejs');
router.use(express.static(path.join(__dirname, 'public')));

router.get('/*.*', (req, res) => {res.status(204).end();});

router.get('/', (req, res, next) => {
    try {
        console.log(`Redirecting...`);
        res.redirect(302, `https://adanor.eu/pet`);
    } catch (error) {
        console.log('Error happend');
    }
})

router.get('/:id', async (req, res, next) => {
    try {
        const id = req.params.id;
        const response = await axios.get(`http://localhost:8080/pets/${id}`);
        const data = response.data;

        if (data.blocked) {
            return errorHandler(410, 'Profile is Blocked', next);
        }
        if (data.success) {
            res.render('index', {
                tabTitle: `${data.id}`,
                message: `${data.id} oldala`,
            });
        }
    } catch (error) {
        console.log(error);
        const status = error.response.status || 500;
        const message = error.response.data.message || 'API Connection Error';
        return errorHandler(status, message, next);
    }
});

module.exports = router;