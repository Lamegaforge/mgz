# Megasaurus

## Configurer BDD
Configurer une connexion dans le `.env`
```
DB_CONNECTION=
DB_HOST=
DB_PORT=
DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=
```
## Installation
- `composer update`
- `php artisan key:generate`
- `php artisan db:seed`
## Oauth
Créer une nouvelle application sur le [Twitch Console](https://dev.twitch.tv/console/apps/create).
- *Nom* : "we don't care"
- *URL de redirection OAuth* : Twitch redirigera vers cette url apres l'authentification, ex http://megasaurus.vagrant/oauth/consume
- *Catégorie* : "Website Integration"

Une fois enregistré il faut se rendre sur *Gérer* pour récuperer des valeurs à placer dans le `.env`
- *Identifiant client* à renseigner pour `HELIX_CLIENT_ID=`
- *Secret du client* à renseigner pour `HELIX_CLIENT_SECRET=`
### Remise à zero du projet
- `php artisan reset`
