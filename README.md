# Symfony Project
Questo progetto è stato sviluppato in Symfony, PHP, CSS, Javascript e Postgresql.

## Start server
Per avviare il server di Symfony lanciare questo comando:
```
symfony server:start --no-tls
```
Così abiliterete in locale il server su http://localhost:8000/

## Url
Gli url disponibili per questo progetto sono:
```
http://localhost:8000/orders
http://localhost:8000/order_items
http://localhost:8000/payments
http://localhost:8000/addresses
http://localhost:8000/clients
```
Su database Postgresql le tabelle Orders e Addresses hanno il riferimento client_id come chiave esterna su Clients mentre le tabelle OrderItems e Payments hanno il riferimento order_id come chiave esterna su Orders.
