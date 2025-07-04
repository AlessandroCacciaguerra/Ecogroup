Per avviare l'applicazione, è necessario inserire la cartella 'EcogroupWeb-AlessandroCacciaguerra' nel percorso '/opt/lampp/htdocs/'.
In seguito, si dovrà aprire un terminale nella cartella 'ecogroup' e digitare il comando 'npm install' per generare 'package-lock.json' e 'node_modules'.
A quel punto, mentre XAMPP è attivo (specificamente MySQL e Apache), si dovrà aprire un terminale in corrispondenza del file .yml e digitare, come utente root, il comando 'docker compose up'.
Il programma sarà disponibile all'indirizzo 'http://localhost:8080'.
