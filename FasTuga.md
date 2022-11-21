# FastTuga

## OBJECTIVE

This project’s objective is to implement a platform for the "FasTuga" restaurant
- Single Page Application (SPA) frontend (Vue.js framework)
- backend that includes a Restful API  (Laravel)
- Node.Js WebSocket server.

### ex Issue 
    [FASTUGA] - US 1


## FASTUGA
- restaurant specialized in Portuguese food
  - Feijoada
  - ....


- Restaurant on a shopping mall
  - has a kitchen
  - A counter to deliver the food and beverages


- Customers of the restaurant will access
  - the menu 
  - make orders through the SPA application


- Orders are prepaid 
  - orders can only be created after a successful payment
  - each order may include several items 
    - (products of the menu)
  - a ticket number (cycle 1 to 99)


- Chefs on the kitchen 
  - receive a notification for each hot dish ordered 
      - (only hot dishes require cooking)
  - when the preparation of the dish is finished, they declare them as “ready”


- The employees on the counter (delivery employees)
  - will receive notifications when 
      - the hot dishes are ready
      - will be responsible for completing the orders 
          - (orders can include hot dishes, cold dishes, drinks, and desserts)
  - deliver them to the customers


- When an order is completed
  - the delivery employee responsible for that order will declare it as “ready”
  - the customer that made the order will receive a notification


- The application should also include a “public board”
  - with a list of all orders (each order is represented by a “ticket number”) that are ready but not delivered yet.


- Any user (including anonymous users)
  - can make orders through the SPA application because orders only require a valid payment 
      - (the customer of an order can be “unknown”).


- Users can be registered customers
  - have access to a point-based discount mechanism


- The registered customer will get 
  - 1 point for each 10 € spent on one order 
      - (e.g., orders with total = 20,5€ or total = 29,5€ will get 2 points; total = 9,5€ will get 0 points) 
  - points are gained on one order only 
  - values spent on several orders are not accumulated 
          (if a customer makes 20 orders of 9€ each, he will have 0 points)


- Each 10 points (only “blocks” of 10 points can be used) 
  - can be exchanged for a discount of 5€ on any order 
      - e.g., if a customer has 23 points, 
          - he can exchange 10 points for a 5€ discount
          - maintain 13 points, 
              or 
          - exchange 20 points for a 10€ discount 
          - maintain 3 points; 
      - if the customer has 9 points, he cannot exchange them yet

      Template e.g.
      - 20 +  10 euros 
          remaining 3 points


## MENU
- “FasTuga” menu includes
  - hot dishes
  - cold dishes
  - drinks
  - desserts.


Each item (product) of the menu has 
  - a photo, 
  - a name, 
  - a description, 
  - the current price


“FatTuga” managers are responsible for editing the menu
  - create
  - edit
  - or remove products
  - change the price of products
  - etc.




## USERS AND CUSTOMERS
- Users:
  - anonymous
  - registered customers
  - all employees
  - chefs
  - delivery
  - managers


- Login:
  - email + password


- Each user account includes 
  - type of user 
    - (customer, chef, delivery, manager)
  - name
  - email
  - password
  - photo


- All users with an account have access and can change 
  - their profile 
  - have access to their historical information 
     - e.g.
         - all orders of the customer
         - statistical information about prepared dishes
         - delivered order
         - etc


- User accounts for employees are created by the managers


- User accounts for registered customers are created by the customers themselves through a register process


- Managers can
	- view and manage all accounts
	- including blocking/unblocking and deleting users (SOFT DELETE)


- Registered customers are associated to a user 
	- (when registering a customer, the platform also creates the associated user) 
      - include a phone
      - a NIF
      - the default payment type and reference
      - the total points owned by him



## ORDERS
- Customers (either anonymous or registered customers) compose orders by adding or removing menu items (products) to it.


- After the order is composed, the customer pays the order using one of the supported payment types


- The order is only created after a successful payment


- Order status are: 
	- Preparing (The initial status of the newly created order [order is not ready yet])
	- Ready (when order is ready to be delivered); 
	- Delivered (when order was delivered to the client)
	- Cancelled (when the order was cancelled)


- Please note that any order may be cancelled by a manager for any reason they deem valid.


- When the order is cancelled, the restaurant will refund the customer the same amount that was paid and will revoke any points awarded or used in that order


- When the order is created, a “ticket number” is associated to it, so that the order is easily identified by the customer and employees


- The ticket number 
	- cycles between 1 and 99
	- is unique among the orders that are currently being handled 
		- (the restaurant cannot handle 99 orders simultaneously) 
          - quantos e que consegue aguentar? ser definido pelo BE?
    - the order should also include a unique id that is the “real” and universal identification for that order (the orders primary key).


- Each order 
	- can be associated to a registered customer (optional)
	- includes information about the date of the order, 
	- the payment type and reference
	- the price (total price of all items of the order)
	- the total that was paid by the customer
	- the employee that delivered the order


- It should also 
	- include information for the point-based discount mechanism, 
		- such as the points gained by the order, 
		- the total that was paid using points (discount)
		- how many points were used for the discount



## ORDER ITEMS
- An order
  - includes one or more items,
  - each associated to a product and a price (the price of the item is the current price for the associated product).


- Each order may have several items associated to the same product 
    - (e.g., 3 items associated to “Coca-Cola”)
    - this means that the items do not need to handle quantities


- If the product associated to the item is a hot dish
    - it must be prepared by a chef in the kitchen 
    - its initial status is Waiting.


- When 
    - the chef starts to prepare it
        - the status changes to Preparing,
    - when the chef finishes the preparation
        - the status changes to Ready


- If the product associated to the item is not a hot dish 
    - (it is a cold dish, drink or dessert), 
    - it does not need any preparation 
    - its initial and only status is Ready.


- Order items include a unique ID that identifies it univocally in the database


- They should also include the information 
    - about the chef that was responsible for the preparation (only for hot dishes)
    - an order local number (1, 2, …) that identifies the item within the order that it belongs to


- Using the order “ticket number” and the item “order local number” it is possible to identify a single item with the following notation: 
	- “24-3” (ticket number = 24; order local number = 3).

    - Perguntar ao stor, o local number e para cada order? ou tem outro significado?
        - ex:
``` 
Order - 78
    1 - hamburguer
    2 - coca cola
    3 - pasta
    4 - sumo
    5 - pizza
    6 - agua
```


## PAYMENTS
- Order payments
  - will be handled by an external payment gateway service
  - (a simplified “fake” service will be provided),
  - which the restaurant platform will consume so that the customer
  - can pay for the orders,
  - receive refunds when orders are cancelled by a manager.


- The service 
     - supports 3 types of payments: 
         - Visa
         - MbWay 
         - PayPal,
     - when creating a payment or a refund, it requires a payment reference


- The reference 
     - for a Visa payment is the Visa Card ID with 16 digits;
     - the reference for the MbWay is the mobile phone number with 9 digits
     - the reference for the PayPal is a valid email


- The external payment gateway service uses the provided payment information (type + reference) to validate and execute the transaction and returns whether the transaction was successful or not



## ADMINISTRATION
- While
  - chefs and delivery (counter) employees are responsible for day-to-day operations on the restaurant
  - the managers are responsible for
  - cancelling orders
  - editing the menu (products of the menu)
  - managing users accounts.


- The managers should also have access to platform usage and business-related statistical information



## NOTIFICATIONS AND REAL TIME DATA
- Users of the application should receive notifications when events relevant to them happen


- For instance, 
	- when a new hot dish is ordered
		- the chefs on the kitchen should be notified
	- when the ordered is ready for delivery
		- the customer of that order should be notified
	- etc
		- order without hot dishes
		 	- employee notification
		- Order cancelled by manager
			- customer notification


- Also, relevant information that is shown on the application, such as (among others): 
	- the list of orders on the public board;
	- the status of the customer’s order and order items;
	- the status of the hot dishes currently in the kitchen
		- should be updated automatically and at real time


- For this to work, employees are required to declare, within the application, 
	- all relevant status changes for the orders and hot dishes


- For instance, 
	- the chef must use the application to declare that he 
		- has started 
		- or concluded the preparation of a specific hot dish
	- the delivery employee must declare that 
		- an order is ready to be delivered 
		- or has been delivered
		- etc.