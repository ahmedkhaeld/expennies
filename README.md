# Expennies
### Features
- User Authentication
    - Login/Registration
    - Password Reset
    - CSRF Protection
- Rate Limiting
    - Prevents brute force attacks
- Transaction Management
    - Create, Read, Update, Delete
    - Category Management
    - Import transactions from CSV
- Dashboard
    - Total Income
    - Total Expenses
    - Total Balance

#### Technologies
- SlimPHP
- MySQL
- Doctrine ORM & Migration
- PHP DI
- Symfony components

#### Requirements and Database initial schema
**Requirements:** <br>
we need a transactions table for tracking expenses and incomes<br>
each transaction associated to a category<br>
we want to upload receipts files to transactions<br>
user can create his categories as he wants<br>