Task:

Create a simple PHP hash service.
/hash has 2 implementations
◉ Store: data is provided with POST request in JSON body structure: {“data”: “…”}, in response we expect to get SHA1 code of data provided - {“hash”: “…”}
◉ Read: read data by provided h
ash in URL (hash/[HASCODE]) in response we can have the following results:
○ If nothing was found - a 404 error
○ If we have 1 result - {“item”: “…”}
○ If we have collisions add collisions array - {“item”: “…”, “collisions”: [“…”, “…”]}
The preferred PHP framework is Symfony or Laravel
As storage files or regular DB can be used:
◉ in case of DB migration that creates a structure must be committed
Service must have
◉ Data validation - field data is required
◉ Tests that cover common logic
◉ We should check for collisions - in cease we already have data in DB with the same hash additional message about it should be added to the response.

    To start project:
    1) symfony server:start
    2) docker-compose up -d 
    3) Migrate db by symfony doctrine command 
    4) Go to 127.0.0.1:8000/api/doc to see OpenAPI docs

    Postgre database connections: 
    User: app 
    Db: app
    Password: 1234
    Port: 49539