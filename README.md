# MTG-Manager
MTG-Manager is a project created to let players of MTG (Magic: The Gathering) manage their card collection and decks. Main purpose of the project is to make 
functional database that will allow players to:
- create account 
- create collection
- create decks containg cards from collection
- choose cards player want to sell/buy
- give/exchange cards between players

## Model of the databse
![image](https://user-images.githubusercontent.com/95052426/208505605-7ff1ce0f-0007-4c11-a5fb-c49fc0f7e3e5.png)

**Global Cards** table was created using open-source project ***MTGJSON*** (https://mtgjson.com) that shares all MTG data, which made it possible to create a table 
with specific values discribing cards and to insert a big amout of data into it easily.

## Interface 
Database is connected to user-friendly interface using php.
