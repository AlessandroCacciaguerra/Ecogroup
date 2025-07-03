const express = require('express');
const axios = require('axios');
const cookieParser = require('cookie-parser');
const session = require('express-session');
const bodyParser = require('body-parser');
const phpExpress = require('php-express')({binPath: 'php'});
const { exec } = require('child_process');
const { execFile } = require('child_process');
const mysql = require('mysql2');
const fs = require('node:fs/promises');

const app = express();
const port = 8080;

async function set_session(userId, userType) {
  try {
    const content = `<?php session_start(); $_SESSION['user_id'] = '${userId}'; $_SESSION['user_type'] = '${userType}';?>`;
    await fs.writeFile('/www/ecogroup/dist/php/session.php', content);
  } catch (err) {
    console.log(err);
  }
}

async function destroy_session() {
  try {
    const content = "<?php session_start(); $_SESSION['user_id'] = null; $_SESSION['user_type'] = null;";
    await fs.writeFile('/www/ecogroup/dist/php/session.php', content);
  } catch (err) {
    console.log(err);
  }
}
destroy_session();
const connection = mysql.createConnection({
    host: '0.0.0.0',
    user: 'root',
    password: 'cGgF6I9WczWDhYM2EdeeNv96rYlL',
    database: 'eco_group',
    port: 3306
});

app.set('view engine', 'php');
app.engine('php', phpExpress.engine);

app.use(express.urlencoded({extended:true}));
app.use(express.json());
app.use(cookieParser());

app.post('/api/api-admin-add-category.php', function(req, res) {
    const { categoria } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-add-category.php'], {
        env: {
            ... process.env,
            CATEGORIA: categoria
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-add-question.php', function(req, res) {
    const { codModeratore, testo, categoria, isPositive, risposte } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-add-question.php'], {
        env: {
            ... process.env,
            CODMODERATORE: codModeratore,
            TESTO: testo,
            CATEGORIA: categoria,
            ISPOSITIVE: isPositive,
            RISPOSTE: risposte
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-add-survey.php', function(req, res) {
    const { adminID, titolo, numeroDomanda, peso, codDomanda, sezione, sezioniDaAggiungere } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-add-survey.php'], {
        env: {
            ... process.env,
            ADMINID: adminID,
            TITOLO: titolo,
            NUMERODOMANDA: numeroDomanda,
            PESO: peso,
            CODDOMANDA: codDomanda,
            SEZIONE: sezione,
            SEZIONIDAAGGIUNGERE: sezioniDaAggiungere
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-alter-question.php', function(req, res) {
    const { testo, categoria, isPositive, cod, testoRisposte } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-alter-question.php'], {
        env: {
            ... process.env,
            TESTO: testo,
            CATEGORIA: categoria,
            ISPOSITIVE: isPositive,
            COD: cod,
            TESTORISPOSTE: testoRisposte
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-alter-survey.php', function(req, res) {
    const { titolo, codQuestionario, codModeratore, commento, numeroDomanda, peso, codDomanda, sezione } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-alter-survey.php'], {
        env: {
            ... process.env,
            TITOLO: titolo,
            CODQUESTIONARIO: codQuestionario,
            CODMODERATORE: codModeratore,
            COMMENTO: commento,
            NUMERODOMANDA: numeroDomanda,
            PESO: peso,
            CODDOMANDA: codDomanda,
            SEZIONE: sezione
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-get-category.php', function(req, res) {
    const { categoria } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-get-category.php'], {
        env: {
            ... process.env,
            CATEGORIA: categoria
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-get-questions.php', function(req, res) {
    const { categoria } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-get-questions.php'], {
        env: {
            ... process.env,
            CATEGORIA: categoria
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-remove-category.php', function(req, res) {
    const { nomeCategoria } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-remove-category.php'], {
        env: {
            ... process.env,
            NOMECATEGORIA: nomeCategoria
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-remove-question.php', function(req, res) {
    const { index, codDomanda } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-remove-question.php'], {
        env: {
            ... process.env,
            INDEX: index,
            CODDOMANDA: codDomanda
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-remove-survey.php', function(req, res) {
    const { codQuestionario } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-remove-survey.php'], {
        env: {
            ... process.env,
            CODQUESTIONARIO: codQuestionario
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-admin-signup.php', function(req, res){
    const { username, email, passwd_input, passwd_repeat } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-admin-signup.php'], {
        env: {
            ... process.env,
            USERNAME: username,
            EMAIL: email,
            PASSWD_INPUT: passwd_input,
            PASSWD_REPEAT: passwd_repeat
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.get('/api/api-logout.php', function(req, res) {
    destroy_session();
    execFile('php', ['/www/ecogroup/dist/php/api/api-logout.php'], {
        env: {
            ... process.env,
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-user-add-done-survey.php', function(req, res) {
    const { codQuestionario, codAzienda, codDomande, risposte } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-user-add-done-survey.php'], {
        env: {
            ... process.env,
            CODQUESTIONARIO: codQuestionario,
            CODAZIENDA: codAzienda,
            CODDOMANDE: codDomande,
            RISPOSTE: risposte
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-user-login.php', function(req, res){
    const { email, pwd } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-user-login.php'], {
        env: {
            ... process.env,
            EMAIL: email,
            PWD: pwd
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        if(stdout[0] == '.') {
            user_id = (stdout.split('&')[0]).split('=')[1];
            user_type = (stdout.split('&')[1]).split('=')[1];
            set_session(user_id, user_type);
        }
        res.send(stdout.split('?')[0]);
    });
});

app.post('/api/api-user-login-get-password-reminder.php', function(req, res) {
    const { email } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-user-login-get-password-reminder.php'], {
        env: {
            ... process.env,
            EMAIL: email
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        res.send(stdout);
    });
});

app.post('/api/api-user-signup.php', function(req, res){
    const { nomeAzienda, email, pwd, passwordClue, dimensioni, cap, citta, ateco, codiciCER } = req.body;
    execFile('php', ['/www/ecogroup/dist/php/api/api-user-signup.php'], {
        env: {
            ... process.env,
            NOMEAZIENDA: nomeAzienda,
            EMAIL: email,
            PWD: pwd,
            PASSWORDCLUE: passwordClue,
            DIMENSIONI: dimensioni,
            CAP: cap,
            CITTA: citta,
            ATECO: ateco,
            CODICICER: codiciCER
        }
    }, (error, stdout, stderr) => {
        if(error) {
            console.error(error);
            return;
        }
        
        if(stdout[0] == '.') {
            user_id = (stdout.split('&')[0]).split('=')[1];
            user_type = (stdout.split('&')[1]).split('=')[1];
            set_session(user_id, user_type);
        }
        
        res.send(stdout.split('?')[0]);
    });
});

app.get('/', function(req, res) {
    let execPath = '/www/ecogroup/dist/views/index.php';
    exec('php ' + execPath, (error, stdout, stderr) => {
        if(error) {
            console.error('Error: ' + error.message);
            return;
        }
        res.write(stdout);
        res.end();
    });
});

app.get('/index.php', function(req, res) {
    let execPath = '/www/ecogroup/dist/views' + req.path;
    exec('php ' + execPath, (error, stdout, stderr) => {
        if(error) {
            console.error('Error: ' + error.message);
            return;
        }
        res.write(stdout);
        res.end();
    });
});

app.all(/.+View\.php$/, function(req, res){
    let execPath = '/www/ecogroup/dist/views' + req.path;
    exec('php ' + execPath, (error, stdout, stderr) => {
        if(error) {
            console.error('Error: ' + error.message);
            return;
        }
        res.write(stdout);
        res.end();
    });
});

app.all(/.+\.js$/, function(req, res){
    let execPath = '/www/ecogroup/dist/' + req.path;
    res.sendFile(execPath);
});

app.all(/assets/, function(req, res){
    let execPath = '/www/ecogroup/dist/' + req.path;
    res.sendFile(execPath);
});

connection.connect(error => {
    if(error) {
        console.error('Error: ' + error.message);
        return;
    }
});

app.listen(port, '0.0.0.0', function() {
    console.log("server start at port " + port);
});
