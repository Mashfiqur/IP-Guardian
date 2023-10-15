# IP Guardian
IP Guardian is a web-based solution for IP address management built using Laravel, Vue.js, MySQL, and Docker for containerized development and deployment. This application allows authenticated users to manage IP addresses by adding, modifying labels/comments, and viewing an audit log of changes.

## Setup Instructions
Follow these steps to set up and run the application using Docker:

**Clone the Repository**:
```bash
git clone https://github.com/Mashfiqur/IP-Guardian.git
```

**Navigate to the project directory**:
```bash
cd IP-Guardian
```

**Copy the Docker Compose configuration file and environment variables file**:
```bash
cp docker-compose-example.yml docker-compose.yml
```
```bash
cp .env.example .env
```
### Open the .env file and configure the environment variables if needed. There are used two different database. One is for the application another one is for testing. Some important environment variables in the .env file are as follows:

**APP_URL**=This is the main app URL. For example, if the port is 80, this should be set to http://localhost.

**VITE_API_URL**=This is the app's API URL. If the port is 80, the API base URL will be http://localhost/api/v1.

**DB_CONNECTION**=Main database connection type.

**DB_HOST**=Main database host

**DB_PORT**=Main database port

**DB_DATABASE**=Main database name

**DB_USERNAME**=Main database username

**DB_PASSWORD**=Main database password for the username

**FORWARD_DB_PORT**=Main database forward port to local machine

**FORWARD_PHPMYADMIN_PORT**=Main database PHPMyAdmin client forward port to the local machine.

**DB_TEST_HOST**=Test database host

**DB_TEST_PORT**=Test database port

**DB_TEST_DATABASE**=Test database name

**DB_TEST_USERNAME**=Test database username

**DB_TEST_PASSWORD**=Test database password for the username

**FORWARD_DB_TEST_PORT**=Test database forward port to local machine

##

**In the docker-compose.yml file, there are four services defined**:

**app**: This service is responsible for running the application.

**db**: This service is used for the main database.

**db_test**: This service is used for the test database.

**phpmyadmin(for the db service only)**: This service provides a PHPMyAdmin client for managing the main database.

##

**After changing the configuration, build and start the Docker containers**:
```bash
docker-compose up --build
```

**For seeding users, run the following command in the trminal**:
```bash
docker exec ip-guardian-app php artisan db:seed
```
**If seeding successfully finished, then these credentials should be in database**:
You can take any credential to login to the application portal:
| Email              | Password              |
| ---------          | -------               |
| admin1@email.com   |  !sss#@%ddavfkwewi@1  |
| admin2@email.com   |  !ss#@%dfkwtyssewi@1  |
| admin3@email.com   |  !sd#@%dfkwtysfewi@1  |
| admin4@email.com   |  !ss#@%fghwtyssewi@1  |
| admin5@email.com   |  !ss#@%dffgrrhhewi@1  |
| admin6@email.com   |  !ss#effvrvrhyjuji@1  |
| admin7@email.com   |  !ss#@%dfkwtxrx4cgdd  |


**To re-run the database migrations and seed the database, run the following command in the terminal**:
```bash
docker exec ip-guardian-app php artisan migrate:fresh --seed
```

**For entering the app container**:
```bash
docker exec -it ip-guardian-app bash
```

**After successfully build the containers, the app should run on the browser in the APP_URL of .env file. If the port is 80, URL: http://localhost**


## Testing the Application through PHPUnit:
**For testing the application through PHP Unit just run the following command in the terminal**:
```bash
docker exec ip-guardian-app php artisan test
```

**Test case(Unit)**:
##
1. Authorized user can access controller to get authenticated data
2. User cannot login with non existing email
3. User cannot login with invalid password
4. Authentication Log entry is created when user logs in
5. Authentication log is updated when user logs out
6. Personal access token is deleted from database when user logs out
7. Index method of IPAddressController
8. Show method of IPAddressController

**Test case(Feature)**:
##
1. Authorized user can access information
2. Unauthenticated user cannot access information
3. User can login 
4. Authrozied user can logout
5. Unauthrozied user cannot logout
6. Authenticated user can get paginated ip addresses 
7. Authenticated user can create ip address
8. Authenticated user can view ip address 
9. Authenticated user can edit ip address
10. Authenticated user can update ip address


## Application Features
### Authentication
**Login**: Users can log in to the system and receive an authenticated token, which is required for all subsequent actions.
`Logout`: Authenticated users can log out from the system.

### Authentication Log
**Logging**: The application keeps a record of user logins and logouts, including IP address, user agent, login time, and logout time.
**View Authentication Log**: Authenticated users can view the login and logout activity of other users.

### IP Address Management
**See IP Addresses**: Authenticated users can see a paginated list of the IP Addresses.
**Add IP Address**: Authenticated users can add a new IP address to the database and attach a label/comment to it.
**Modify IP Address**: Authenticated users can modify an existing IP address to change the label/comment associated with it.
**Show IP Address**: Authenticated users can see a IP address details with audit logs.

### Audit Log
**Logging**: The application maintains an audit log for actions like creating and updating information. It records details about who creates or updates records, which fields are modified, and when the changes occurred.
**View Audit Log**: Authenticated users can view the audit log, which includes the history of record creation and updates.


## Additional Notes
1. Deleting records or changing an IP address after entry is not supported; only the comment/label can be modified. But in the database schema there is an option of Soft Delete for future development
2. Account management functionality and the ability to modify/update the audit table are not provided.