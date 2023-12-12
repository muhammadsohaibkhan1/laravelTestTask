# laravelTestTask

## 1. Database Setup
- Create a database named `testDB`.
- Run migrations to create necessary tables: `php artisan migrate`.

## 2. Seed Roles
- Seed roles using `RoleSeeder`:
    ```bash
    php artisan db:seed --class=RoleSeeder
    ```

## 3. User Signup
- Use the following API endpoint to signup:
    - **Endpoint**: `POST /api/signup`
    - **Parameters**:
        - `name`: User's name
        - `email`: User's email
        - `password`: User's password
        - `password_confirmation`: Confirm the password
        - `role`: User's role (either `buyer` or `seller`)

## 4. User Signin
- Use the following API endpoint to signin and get a token:
    - **Endpoint**: `POST /api/signin`
    - **Parameters**:
        - `email`: User's email
        - `password`: User's password

## 5. Seller Operations
- As a seller, you have the following operations:
    - **Add Product**
        - **Endpoint**: `POST /api/products`
        - **Parameters**:
            - `name`: Product name
            - `description`: Product description
            - `price`: Product price
            - `quantity`: Product quantity

    - **Update Product**
        - **Endpoint**: `PUT /api/products/{id}`
        - **Parameters**:
            - `name`: Product name
            - `description`: Product description
            - `price`: Product price
            - `quantity`: Product quantity

    - **Delete Product**
        - **Endpoint**: `DELETE /api/products/{id}`

    - **View Products**
        - **Endpoint**: `GET /api/products`

    - **View All Orders**
        - **Endpoint**: `GET /api/orders`

## 6. Buyer Operations
- As a buyer, you have the following operations:
    - **Create Order**
        - **Endpoint**: `POST /api/orders`
        - **Parameters**:
            - `product_id`: ID of the product to order
            - `quantity`: Order quantity

    - **View Order**
        - **Endpoint**: `GET /api/orders`

### Note
- Ensure to include the Bearer token received after signin in the Authorization header for authenticated requests.
